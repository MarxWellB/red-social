<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Tag;
use App\Models\Denuncia;
use Illuminate\Pagination\Paginator;
use App\Models\Volcado;
use App\Models\Discount;
use App\Models\onlinestore;
use Illuminate\Support\Facades\DB;
use App\Models\PostController;
use App\Models\SupportRequest;
use App\Models\UserAccount;
use App\Models\PromotionRequest;
use App\Models\AccountDeletionRequest;
use Carbon\Carbon;
use App\Models\ListaPromocion;
use App\Models\Promotion;
use Illuminate\Support\Facades\File;

use GuzzleHttp\Client;
class AdminController extends Controller
{

    public function __construct(){
            $this->middleware('auth');
    }
    public function profileCache(){
        $users=User::where('level',1)->where('is_admin',0)->where('profile_cach',0)->get();
        foreach ($users as $user) {
            $this->descargarcache($user);
            $user->profile_cach=1;
            $user->save();
        }
        return redirect()->back();
    }
    public function descargarcache(User $user){
        $imageUrl = $user->prof;
            // Proceder a eliminar el caché
                // Eliminar el archivo de caché
                $cacheBio = public_path('img' . DIRECTORY_SEPARATOR .'B'. $user->username . '.png');
                $cache = public_path('img' . DIRECTORY_SEPARATOR . 'P'.$user->username . '.png');
                if (File::exists($cache)) {
                    File::delete($cache);
                }
                if (File::exists($cacheBio)) {
                    File::delete($cacheBio);
                }
        if (filter_var($imageUrl, FILTER_VALIDATE_URL)) {
            $client = new Client();
    
            try {
                $response = $client->get($imageUrl);
    
                if ($response->getStatusCode() === 200) {
                    $imageContent = $response->getBody()->getContents();
    
                    $nombreImagen = 'P'.$user->username . '.png';
    
                    $rutaAlmacenamiento = public_path('img' . DIRECTORY_SEPARATOR . $nombreImagen);
    
                    if (!file_exists($rutaAlmacenamiento)) 
                    {
                        file_put_contents($rutaAlmacenamiento, $imageContent);
                    }
                } else {
                    return "No se pudo descargar la imagen. Código de estado: " . $response->getStatusCode();
                }
            } catch (\Exception $e) {
                return "Error al descargar la imagen: " . $e->getMessage();
            }
        } else {
            return "URL de imagen no válida.";
        }
}
    public function limit(Request $request){
        $number = Volcado::where('id_elemento',7)->where('fecha_metrica','>=',Carbon::now()->subDays(7))->sum('numero_vista');
        $base=500;
        $basic=($number/570)<35?35:round($number/570)+2;
        $medium=($number/1000)<20?20:round($number/1000)+2;
        $premium=($number/1333)<15?15:round($number/1333)+2;
        ListaPromocion::where('name', 'basic')->update(['max' => $basic]);
        ListaPromocion::where('name', 'medium')->update(['max' => $medium]);
        ListaPromocion::where('name', 'premium')->update(['max' => $premium]);
        return redirect()->back();

    }
    public function updatePromotionHours() {
        $activePromotions = Promotion::where('active', 1)->with('listaPromocion')->get();
        foreach ($activePromotions as $promotion) {
            $lastUpdated = $promotion->last_updated_at;
            $currentHours = now()->diffInHours($lastUpdated);
            $totalHours = $promotion->status + $currentHours;
            $promotion->status = $totalHours;
            $promotion->last_updated_at = now();
            // Revisar si la promoción ha excedido su tiempo límite
            if ( $totalHours >= $promotion->listaPromocion->time) {
                $promotion->active = 3; // Estado para promociones finalizadas
            }
    
            $promotion->save();          
        }
        if($promotion->method==99){
            return redirect(route('admin.PersonalizateManagmente'));
        }else
        {
            return redirect(route('admin.BasicManagment'));
        }
    }
    public function startPromotion($id) {
        $promotion = Promotion::findOrFail($id);
        $promotion->active = 1;
        $promotion->last_updated_at = now(); // Reiniciar el seguimiento del tiempo
        $lp=ListaPromocion::where('id',$promotion->id_type )->first();
        
        if ($promotion->status >= $promotion->listaPromocion->time) {
            $promotion->active = 3; // Estado para promociones finalizadas
            $lp->decrement('actives');
        }else{
            $lp->increment('actives');
        }
        $promotion->save();
        if($promotion->method==99){
            return redirect(route('admin.PersonalizateManagmente'));
        }else
        {
            return redirect(route('admin.BasicManagment'));
        }
        
    }
    
    public function pausePromotion($id) {
        $promotion = Promotion::findOrFail($id);
        $lastUpdated = $promotion->last_updated_at;
        $currentHours = now()->diffInHours($lastUpdated);
        $promotion->status += $currentHours;
        $promotion->last_updated_at = now();
        $promotion->active = 2; // Estado para promociones pausadas
        $lp=ListaPromocion::where('id',$promotion->id_type )->first();
            
        if ( $promotion->status >= $promotion->listaPromocion->time) {
            $promotion->active = 3; // Estado para promociones finalizadas
            $lp->decrement('actives');
           
        }else{
            $lp->decrement('actives');
        }
        $promotion->save();
        if($promotion->method==99){
            return redirect(route('admin.PersonalizateManagmente'));
        }else
        {
            return redirect(route('admin.BasicManagment'));
        }
    }
    
    /*public function updatePromotionHours() {
        $activePromotions = Promotion::where('active', 1)->get();
        foreach ($activePromotions as $promotion) {
            // Si la promoción está activa o fue pausada recientemente
            
                $lastUpdated = $promotion->last_updated_at ;
                $currentHours = now()->diffInHours($lastUpdated);
                $promotion->status += $currentHours;
                $promotion->last_updated_at = now();
                
                $promotion->save();          
        }
        return redirect(route('admin.BasicManagment'));
    }
    public function startPromotion($id) {
        $promotion = Promotion::findOrFail($id);
        $promotion->active = 1;
        $promotion->last_updated_at = now(); // Reiniciar el seguimiento del tiempo
        $promotion->save();
    
        return redirect(route('admin.BasicManagment'));
    }
    public function pausePromotion($id) {
        $promotion = Promotion::findOrFail($id);
        $lastUpdated = $promotion->last_updated_at;

        $currentHours = now()->diffInHours($lastUpdated);
        $promotion->status += $currentHours;
        $promotion->last_updated_at = now();
        $promotion->active = 2;
        $promotion->save();
    
        return back()->with('success', 'Promoción pausada correctamente.');
    }
    
    public function updatePromotionHours()
    {
        $activePromotions = Promotion::where('active', 1)->get(); // Asumiendo que el status 1 es para promociones activas

        foreach ($activePromotions as $promotion) {
            $lastUpdated = $promotion->last_updated_at ?? $promotion->created_at;
            $elapsedHours = $promotion->elapsed_hours ?? 0;
            $currentHours = now()->diffInHours($lastUpdated);
            $promotion->elapsed_hours = $elapsedHours + $currentHours;
            $promotion->last_updated_at = now();
            $promotion->save();
        }
        $activePromotions = Promotion::where('active', 1)->get();
        foreach ($activePromotions as $promotion) {
            $lastUpdated = $promotion->last_updated_at ?? $promotion->created_at;
            $elapsedHours = $promotion->elapsed_hours ?? 0;
            $currentHours = now()->diffInHours($lastUpdated);
            $promotion->elapsed_hours = $elapsedHours + $currentHours;
            $promotion->last_updated_at = now();
            $promotion->save();
        }
        return back()->with('success', 'Horas de promoción actualizadas correctamente.');
    }

    public function startPromotion($id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->active = 1;
        $promotion->save();

        return redirect(route('admin.BasicManagment'));
    }

    // Pausar una promoción
    public function pausePromotion($id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->update(['active' => 2]);

        return back()->with('success', 'Promoción pausada correctamente.');
    }*/

    // Cancelar o terminar una promoción
    public function endPromotion($id)
    {
        $promotion = Promotion::findOrFail($id);
        $promotion->update(['active' => 3]);
        $lp=ListaPromocion::where('id',$promotion->id_type )->first();
        $lp->decrement('actives');
        return back()->with('success', 'Promoción terminada correctamente.');
    }
    public function managmentBasic(Request $request) {
        $query = Promotion::where('method','!=',99);
    
        // Filtrar por nombre de usuario
        if ($userName = $request->input('user_name')) {
            $query->whereHas('user', function($q) use ($userName) {
                $q->where('name', 'like', '%' . $userName . '%');
            });
        }
    
        // Filtrar por tipo de promoción
        if ($type = $request->input('type')) {
            $query->where('id_type', $type);
        }
    
        // Filtrar por estado
        if ($status = $request->input('status')) {
            $query->where('active', $status);
        }
    
        // Filtrar por fecha
        if ($startDate = $request->input('start_date')) {
            $query->where('startday', '>=', $startDate);
        }
    
        // Filtrar por duración en horas
        if ($hours = $request->input('hours')) {
            $query->where('status', '>=', $hours);
        }
    
        // Paginación
        $promotions = $query->paginate(50);
    
        return view('admin.bm', ['promotions' => $promotions]);
    }
    
  /*  function managmentBasic(Request $request) {
        $query = Promotion::query();

        // Búsqueda
        if ($searchTerm = $request->input('search')) {
            $query->where(function ($query) use ($searchTerm) {
                $query->where('name', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('username', 'LIKE', "%{$searchTerm}%");
            });
        }
    
        // Ordenamiento
        if ($sortColumn = $request->input('sort_by')) {
            $sortOrder = $request->input('sort_order', 'asc');
            $query->orderBy($sortColumn, $sortOrder);            
        }
    
        // Paginación
        $promotions = $query->paginate(10);
    
        return view('admin.bm', ['promotions' => $promotions]);
}*/

function managmentPersonalizate(Request $request) {
    $query = Promotion::query()->where('method',99);

    // Filtrar por nombre de usuario
    if ($userName = $request->input('user_name')) {
        $query->whereHas('user', function($q) use ($userName) {
            $q->where('name', 'like', '%' . $userName . '%');
        });
    }

    // Filtrar por tipo de promoción
    if ($type = $request->input('type')) {
        $query->where('id_type', $type);
    }

    // Filtrar por estado
    if ($status = $request->input('status')) {
        $query->where('active', $status);
    }

    // Filtrar por fecha
    if ($startDate = $request->input('start_date')) {
        $query->where('startday', '>=', $startDate);
    }

    // Filtrar por duración en horas
    if ($hours = $request->input('hours')) {
        $query->where('status', '>=', $hours);
    }

    // Paginación
    $promotions = $query->paginate(50);
    $fecha = Carbon::now()->addDays(2)->format('Y-m-d');
   
    return view('admin.pmanager', compact('fecha','promotions'));
}
public function promcreate(Request $request)
{
    $listaPromocion = ListaPromocion::create([
        'name' => $request->nombre.now(),
        'cost' => $request->price,
        'time' => $request->hours,
        'active' => 1
    ]);
    if (!$request->isMethod('post') || !$request->has('startday')) {
        // Si no es una petición POST o no tiene los datos esperados, redirige al usuario
        return redirect()->back();
    }
    // Crear la promoción
    // Suponiendo que User::where(...) devuelve el usuario correcto
    $startday = Carbon::parse($request->startday);

    $userId = User::where('username', $request->username)->first()->id;

    // Calcula endDay usando Carbon
    $endDay = Carbon::parse($request->startday)->addDays(3);
    $st=$endDay->subDays(3);
    $hola=Carbon::parse($request->startday)->addDays(3);
    $prom=ListaPromocion::latest()->first()  ; 
    $promotion = new Promotion([
        'IdUsr' => $userId,
        'name' => $request->nombre,
        'email' => $request->email,
        'id_type' =>   $prom->id   , // Necesitas una lógica para asignar esto basado en 'paquete'
        'include' => $request->has('include') ? 1 : 0,
        'method' => 99,
        'startday' => $endDay->format('Y-m-d'),
        'endDay' => $hola->format('Y-m-d'),
        'nowpay' => $request->nowpay,
        'active' => 0,
        'paymentDay'=> $now = Carbon::now(),
        'idDiscount' =>  $request->idDiscount ?? null,
        'nowpay'=>$request->nowpay,
        
    ]);

    $promotion->save();

    return back()->with('success', 'Promoción creada con éxito.');
}
















    function deleteCache() {
            $thresholdDate = Carbon::today()->subDays(2);
        
            // Parte 1: Posts con caché activo y vistas, pero no en los últimos dos días
            $postsWithOldViews = Post::where('cache_active', 1)
                ->leftJoin('volcado', 'posts.id', '=', 'volcado.elemento')
                ->where('volcado.fecha_metrica', '<', $thresholdDate)
                ->orWhereNull('volcado.fecha_metrica') // Incluye los posts sin vistas registradas
                ->select('posts.*')
                ->get();
        
            // Parte 2: Posts con caché activo pero sin registros en 'volcado'
            $postsWithoutViews = Post::where('cache_active', 1)
                ->whereDoesntHave('volcado')
                ->get();
        
            // Unir ambas listas de posts
            $postsToDelete = $postsWithOldViews->merge($postsWithoutViews);
        
            // Proceder a eliminar el caché
            foreach ($postsToDelete as $post) {
                // Eliminar el archivo de caché
                $cachePath = public_path('img' . DIRECTORY_SEPARATOR . $post->id . '.png');
                
                if (File::exists($cachePath)) {
                    File::delete($cachePath);
                }
        
                // Actualizar el estado de caché en la base de datos
                $post->cache_active = 0;
                $post->save();
            }
        
            echo "Eliminados " . $postsToDelete->count() . " elementos del caché.";
            return redirect()->back();
    }
    public function deleteLeastViewedCache() {
        // Obtener el total de posts con cache activo
        $totalActiveCache = Post::where('cache_active', 1)->count();
        
        // Calcular el 10% de los posts
        $limit = (int) ceil($totalActiveCache * 0.1);
        
        // Obtener el 10% de los posts con menos vistas
        $postsToDelete = Post::where('cache_active', 1)
                            ->leftJoin('volcado', 'posts.id', '=', 'volcado.elemento')
                            ->orderBy('volcado.numero_vista', 'asc')
                            ->select('posts.*')
                            ->limit($limit)
                            ->get();
        
        foreach ($postsToDelete as $posta) {
            // Ruta del archivo de caché
            $cachePath = public_path('img' . DIRECTORY_SEPARATOR . $posta->id . '.png');
            
            // Eliminar el archivo de caché si existe
            if (File::exists($cachePath)) {
                File::delete($cachePath);
            }
    
            // Actualizar el estado de caché en la base de datos
            $posta->cache_active = 0;
            $posta->save();
        }
    
        echo "Eliminados " . $postsToDelete->count() . " elementos del caché.";
        return redirect()->back();
    }
    public function index()//revisado
    {  
        
        
        if(auth()->user()->is_admin === 1)
        {
        $totalPosts = Post::where('level', '!=', 1)->count();
        $totalUsers = User::where('level', '!=', 1)->count();
        $totalTags  = Tag::where('level', '!=', 1)->count();
        $soporte=SupporRequest::where('status',0)->count();
    
        $tagViews = Volcado::getStats(3)->orderBy('numero_vista', 'desc')->get();
        $postViews = Volcado::getStats(1)->orderBy('numero_vista', 'desc')->get();
        $userViews = Volcado::getStats(2)->orderBy('numero_vista', 'desc')->get();
        $onlineStoreViews = Volcado::getStats(4)->orderBy('numero_vista', 'desc')->get();
        $searchViews = Volcado::getStats(5)->orderBy('numero_vista', 'desc')->get();
        
        //$inclusion=UserAccount::where('status', 0)->count();
        //$delete=AccountDeletionRequest::where('status', 0)->count();
    
        return view('admin.dashboard',[
            'tagViews' => $tagViews,
            'postViews' => $postViews,
            'userViews' => $userViews,
            'onlineStoreViews' => $onlineStoreViews,
            'searchViews' => $searchViews,
            'totalPosts' => $totalPosts,
            'totalUsers' => $totalUsers,
            'totalTags' => $totalTags,
            'soporte'=>$soporte
            
        ]); 
        }else{
            return redirect()->route('posts.principal');
        } 
    }

    public function seePosts(Post $post){
        if(auth()->user()->is_admin===1){
            $user=User::find($post->user_id);
            $all = Post::where('level',"=", 1)->inRandomOrder()->paginate(30);    
            $tags = $post->tags()->orderBy('name')->get();
            $onlinestore = $post->onlinestore;
            $url = User::select('prof')->where('name', $post->name);    
            return view(
                'admin.seePosts', [
                'post' => $post,
                'user' => $user,
                'all' => $all,
                'tags' => $tags,
                'onlinestore' => $onlinestore,
                'url' => $url,
            ]);
        }
    }

    public function seeUser(User $user){
        if(auth()->user()->is_admin===1){
            $posts = Post::where('user_id', $user->id)->where('level',"=", 1)->inRandomOrder()->paginate(30);

            $tags = collect();
    
            foreach ($posts as $post) {
                $postTags = $post->tags()->get();
                $tags = $tags->merge($postTags);
            }
    
            $tags = $tags->unique('id');
            
            $onlinestores = $user->onlinestores;
            $conx= \App\Models\cxsturs::all()->where('user_id');
    
            return view('dashboard', [
                'user' => $user,
                'posts' => $posts,
                'tags' => $tags,
                'onlinestores'=>$onlinestores,
                'conx'=>$conx
            ]);
        }
    }

    public function indexposts()//revisado
    {if(auth()->user()->is_admin === 1)
        {
            $goodPosts = Post::where('level', 1)->get();
            $reportedPosts = Post::where('level', '!=', 1)->get();        
            $denuncia=Denuncia::where('estado', 0)->where('tipo_elemento',2)->get();
            $letrasCorrespondencia = [
                'spam' => 'a',
                'acoso' => 'b',
                'contenido_ofensivo' => 'c',
                'contenido_inapropiado' => 'd',
                'violacion_de_derechos' => 'e',
                'otras_razones' => 'f',
            ];
            $letras = array_flip($letrasCorrespondencia);
            return view('admin.posts', ['goodPosts' => $goodPosts, 'reportedPosts' => $reportedPosts,'denuncia'=>$denuncia,'letras'=>$letras]);
        }else{
                return redirect()->route('posts.principal');
        } 
    }
    
    public function indexacounts()//revisado
    {
        if(auth()->user()->is_admin === 1)
        {
        $goodPosts = User::where('level', 1)->get();
        $reportedPosts = User::where('level', '!=', 1)->get();
        $denuncia=Denuncia::where('estado', 1)->where('tipo_elemento',1)->get();
        $letrasCorrespondencia = [
            'spam' => 'a',
            'acoso' => 'b',
            'contenido_ofensivo' => 'c',
            'contenido_inapropiado' => 'd',
            'violacion_de_derechos' => 'e',
            'otras_razones' => 'f',
        ];
        $letras = array_flip($letrasCorrespondencia);
        return view('admin.acounts', ['goodPosts' => $goodPosts, 'reportedPosts' => $reportedPosts,'denuncia'=>$denuncia,'letras'=>$letras]);
        }else{
            return redirect()->route('posts.principal');
        } 
    }
    
    public function indextags()//revisado
    {
        if(auth()->user()->is_admin === 1)
        {
        $goodPosts = Tag::where('level', 1)->get();
        $reportedPosts = Tag::where('level', '!=', 1)->get();
    
        return view('admin.tags', ['goodPosts' => $goodPosts, 'reportedPosts' => $reportedPosts]);
        }else{
            return redirect()->route('posts.principal');
        } 
    }     
    public function enablePost(Post $post)
    {
        if (auth()->user()->is_admin === 1) {
            // Consultar la tabla denuncia para el tipo_elemento "post" y estado 0
            $denuncia = Denuncia::where('tipo_elemento', 3)
                                ->where('estado', 0)
                                ->where('id_elemento_denunciado', $post->id)
                                ->first();
            
            if ($denuncia) {
                // Cambiar el estado de la denuncia a 1
                $denuncia->estado = 1;
                $denuncia->save();
                
                // Cambiar el nivel del post a 1
                $post->level = 1;
                $post->save();
                
                return redirect()->back()->with('success', 'El post ha sido habilitado.');
            } else {
                return redirect()->back()->with('error', 'No se encontró una denuncia válida.');
            }
        } else {
            return redirect()->route('posts.principal');
        }
    }


    public function enableUser(User $user)
    {
        if (auth()->user()->is_admin === 1) {
            // Consultar la tabla denuncia para el tipo_elemento "user" y estado 0
            $denuncia = Denuncia::where('tipo_elemento', 1)
                                ->where('estado', 0)
                                ->where('id_elemento_denunciado', $user->id)
                                ->first();
            
            if ($denuncia) {
                // Cambiar el estado de la denuncia a 1
                $denuncia->estado = 1;
                $denuncia->save();
                
                // Cambiar el nivel del usuario a 1
                $user->level = 1;
                $user->save();
                
                return redirect()->back()->with('success', 'La cuenta ha sido habilitada.');
            } else {
                return redirect()->back()->with('error', 'No se encontró una denuncia válida.');
            }
        } else {
            return redirect()->route('posts.principal');
        }
    }


    public function enableTag(Tag $tag)
    {
        if (auth()->user()->is_admin === 1) {
            // Consultar la tabla denuncia para el tipo_elemento "tag" y estado 0
            $denuncia = Denuncia::where('tipo_elemento', 2)
                                ->where('estado', 0)
                                ->where('id_elemento_denunciado', $tag->id)
                                ->first();
            
            if ($denuncia) {
                // Cambiar el estado de la denuncia a 1
                $denuncia->estado = 1;
                $denuncia->save();
                
                // Cambiar el nivel del tag a 1
                $tag->level = 1;
                $tag->save();
                
                return redirect()->back()->with('success', 'El tag ha sido habilitado.');
            } else {
                return redirect()->back()->with('error', 'No se encontró una denuncia válida.');
            }
        } else {
            return redirect()->route('posts.principal');
        }
    }


    public function filtro(Request $request)//semi revisado
    {
        if(auth()->user()->is_admin === 1)
        {
        // Obtén los parámetros de búsqueda del formulario
        $filter = $request->input('filter', 'all');
        $searchTerm = $request->input('search_term', '');
        $startDate = $request->input('start_date', date('Y-m-d', strtotime('-2 days')));
        $endDate = $request->input('end_date', date('Y-m-d'));
        $startTime = $request->input('start_time', '00:00:00');
        $endTime = $request->input('end_time', '23:59:59');
        $dateRange = $request->input('date_range', 'day');
    
        $filteredResults = [];
    
        if ($filter === 'all') {
            $filteredResults = DB::table('volcado')
                ->where('fecha_metrica', '>=', $startDate)
                ->where('fecha_metrica', '<=', $endDate)
                ->whereBetween('hora', [$startTime, $endTime])
                ->groupBy('elemento','id_elemento')
                ->select('elemento','id_elemento', DB::raw('SUM(numero_vista) as total_vistas'))
                ->paginate(10);
        } elseif ($filter === 'posts') {
            $filteredResults = DB::table('volcado')
                ->where('elemento', '=', 1)
                ->where('fecha_metrica', '>=', $startDate)
                ->where('fecha_metrica', '<=', $endDate)
                ->whereBetween('hora', [$startTime, $endTime])
                ->select('elemento','id_elemento', DB::raw('SUM(numero_vista) as total_vistas'))
                ->paginate(10);
        } elseif ($filter === 'tags') {
            $filteredResults = Tag::query()
                ->where('fecha_metrica', '>=', $startDate)
                ->where('fecha_metrica', '<=', $endDate)
                ->whereBetween('hora', [$startTime, $endTime])
                ->select('elemento','id_elemento', DB::raw('SUM(numero_vista) as total_vistas'))
                ->paginate(10);
        } elseif ($filter === 'online_stores') {
            $filteredResults = OnlineStore::query()
                ->where('fecha_metrica', '>=', $startDate)
                ->where('fecha_metrica', '<=', $endDate)
                ->whereBetween('hora', [$startTime, $endTime])
                ->select('elemento', 'id_elemento',DB::raw('SUM(numero_vista) as total_vistas'))
                ->paginate(10);
        } elseif ($filter === 'users') {
            $filteredResults = Usuario::query()
                ->where('fecha_metrica', '>=', $startDate)
                ->where('fecha_metrica', '<=', $endDate)
                ->whereBetween('hora', [$startTime, $endTime])
                ->select('elemento','id_elemento', DB::raw('SUM(numero_vista) as total_vistas'))
                ->paginate(10);
        } elseif ($filter === 'searches') {
            $filteredResults = Busqueda::query()
                ->where('fecha_metrica', '>=', $startDate)
                ->where('fecha_metrica', '<=', $endDate)
                ->whereBetween('hora', [$startTime, $endTime])
                ->select('elemento', 'id_elemento',DB::raw('SUM(numero_vista) as total_vistas'))
                ->paginate(10);
        }
    
            $perPage = 10; // Número de elementos por página
            $currentPage = Paginator::resolveCurrentPage(); // Obtiene el número de página actual
            $filteredResults = new Paginator($filteredResults->items(), $perPage, $currentPage, [
                'path' => Paginator::resolveCurrentPath(),
            ]);

            $totalPosts = Post::where('level', '!=', 1)->count();
        $totalUsers = User::where('level', '!=', 1)->count();
        $totalTags  = Tag::where('level', '!=', 1)->count();
            // Obtén los datos de las vistas por elemento para el gráfico
            $postViews = []; // Datos de vistas de posts
            $userViews = []; // Datos de vistas de usuarios
            $tagViews = []; // Datos de vistas de tags
            $onlineStoreViews = []; // Datos de vistas de online stores
            $searchViews = []; // Datos de vistas de búsquedas

            return view('admin.dashboard', [
                'totalPosts' => $totalPosts,
                'totalUsers' => $totalUsers,
                'totalTags' => $totalTags,
                'filteredResults' => $filteredResults ,
                'postViews' => $postViews,
                'userViews' => $userViews,
                'tagViews' => $tagViews,
                'onlineStoreViews' => $onlineStoreViews,
                'searchViews' => $searchViews,
                'filter' => $filter,
                'searchTerm' => $searchTerm,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'startTime' => $startTime,
                'endTime' => $endTime,
                'dateRange' => $dateRange,
            ]);}else{
                return redirect()->route('posts.principal');
            } 
    }

    /////////////////////////////////////////////////////////////////cuentaspromos
    public function acounts()
{
    $promotions = Promotion::all();
    $promos = ListaPromocion::all();
    return view('promos.acounts', ['promotions' => $promotions, 'promos' => $promos]);
}


    public function created()
    {
        return view('promos.acounts');
    }

    public function storeA(Request $request)
    {
        
        /*9  $request->validate([
            'username' => 'required|exists:users,username',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'method' => 'required|string|max:255',
            'promoId' => 'required|exists:listapromociones,id',
            'paymentDay' => 'required|date',
            'include' => 'required|date',
            'startDay' => 'required|date',
            'endDay' => 'required|date|after_or_equal:startDay',
        ]);*/
        // Busca al usuario por username
        $user = User::where('username', $request->username)->firstOrFail();

        // Crear la promoción con los datos validados
        $promotion = new Promotion();
        $promotion->IdUsr = $user->id;
        $promotion->name = $request->name;
        $promotion->email = $request->email;
        $promotion->method = $request->method;
        $promotion->include = $request->include;
        $promotion->id_type = $request->promoId; // 'id_type' es la FK que apunta a 'lista_promociones'
        $promotion->paymentDay = $request->paymentDay;
        $promotion->startDay = $request->startDay;
        $promotion->endDay = $request->endDay;
        $promotion->active = true; // Establecer active automáticamente
        $promotion->save();
    
        return redirect()->route('promos.acounts')->with('success', 'Promoción creada con éxito.');
    }
    
///////////////////promos
public function indexProm()
{
    if (auth()->user()->is_admin === 1) 
    {
        $promos = ListaPromocion::all();
        return view('promos.index', compact('promos'));
    }
}

public function create()
{
    if (auth()->user()->is_admin === 1) 
    {
        return view('promos.create');
    }
}

public function storeProm(Request $request)
{
    if (auth()->user()->is_admin === 1) 
    {
        ListaPromocion::create($request->all());
        return redirect()->route('promos.index');
    }
}

public function edit(Promo $promo)
{
    if (auth()->user()->is_admin === 1) 
    {
        return view('promos.edit', compact('promo'));
    }
}

public function update(Request $request, Promo $promo)
{
    if (auth()->user()->is_admin === 1) 
    {
        $promo->update($request->all());
        return redirect()->route('promos.index');
    }
}

public function destroy(Promo $promo)
{
    if (auth()->user()->is_admin === 1) 
    {
        $promo->delete();
        return redirect()->route('promos.index');
    }

}

/////////////////////////////////////support
public function supportReq()
{
    if (auth()->user()->is_admin === 1) 
    {
        $requests = SupportRequest::all(); // O cualquier lógica para obtener las solicitudes
        return view('admin.support_requests_index', compact('requests'));
    }
}
public function supportUpdate(Request $request, $suport)
{
    if (auth()->user()->is_admin === 1) 
    {
       // dd($suport);     ************esto quiza deje de funcionar 
        $supportRequest = SupportRequest::where('id', $suport)->first();

        if ($supportRequest) {
            $supportRequest->status = 1; // Cambiar el estado a 'revisado'
            $supportRequest->save();
    
            return redirect()->back()->with('success', 'Solicitud actualizada correctamente');
        } else {
            return redirect()->back()->with('error', 'Solicitud de soporte no encontrada.');
        }
    
    }
}
////////////////////////////adder acounts
public function adder()
{
    if (auth()->user()->is_admin === 1) 
    {
        $accounts = UserAccount::all(); // O cualquier lógica para obtener las solicitudes
        return view('admin.adder', compact('accounts'));
    }
}
public function adderStatus(Request $request, $suport)
{
    if (auth()->user()->is_admin === 1) 
    {
       // dd($suport);     ************esto quiza deje de funcionar 
        $supportRequest = UserAccount::where('id', $suport)->first();

        if ($supportRequest) {
            $supportRequest->status = 1; // Cambiar el estado a 'revisado'
            $supportRequest->save();
    
            return redirect()->back()->with('success', 'Solicitud actualizada correctamente');
        } else {
            return redirect()->back()->with('error', 'Solicitud de soporte no encontrada.');
        }
    
    }
}


////////////////////remover

public function remover()
{
    if (auth()->user()->is_admin === 1) 
    {
        $deletionRequests = AccountDeletionRequest::all(); // O cualquier lógica para obtener las solicitudes
        return view('admin.remover', compact('deletionRequests'));
    }
}
public function removerStatus(Request $request, $suport)
{
    if (auth()->user()->is_admin === 1) 
    {
       // dd($suport);     ************esto quiza deje de funcionar 
        $supportRequest = AccountDeletionRequest::where('id', $suport)->first();

        if ($supportRequest) {
            $supportRequest->status = 1; // Cambiar el estado a 'revisado'
            $supportRequest->save();
    
            return redirect()->back()->with('success', 'Solicitud actualizada correctamente');
        } else {
            return redirect()->back()->with('error', 'Solicitud de soporte no encontrada.');
        }
    
    }
}

/////////////////////////////////////promoter request
public function promotion()
{
    if (auth()->user()->is_admin === 1) 
    {
        $promotionRequests  = PromotionRequest::all(); // O cualquier lógica para obtener las solicitudes
        return view('admin.promotion', compact('promotionRequests'));
    }
}
public function promotionStatus(Request $request, $suport)
{
    if (auth()->user()->is_admin === 1) 
    {
       // dd($suport);     ************esto quiza deje de funcionar 
        $supportRequest = PromotionRequest::where('id', $suport)->first();

        if ($supportRequest) {
            $supportRequest->status = 1; // Cambiar el estado a 'revisado'
            $supportRequest->save();
    
            return redirect()->back()->with('success', 'Solicitud actualizada correctamente');
        } else {
            return redirect()->back()->with('error', 'Solicitud de soporte no encontrada.');
        }
    
    }
}


/////////////////////////////////////////////////// solo promoter
public function promotionar()
{
    if (auth()->user()->is_admin === 1) 
    {
        $promotionRequests  = Promotion::all(); // O cualquier lógica para obtener las solicitudes
        
        return view('admin.promotionsrequest', compact('promotionRequests'));
    }

}
public function promocionarA(Request $request, $suport)
{
    if (auth()->user()->is_admin === 1) 
    {
       // dd($suport);     ************esto quiza deje de funcionar 
        $supportRequest = Promotion::where('id', $suport)->first();

        if ($supportRequest) {
            $supportRequest->active = 1; // Cambiar el estado a 'revisado'
            $supportRequest->save();
    
            return redirect()->back()->with('success', 'Solicitud actualizada correctamente');
        } else {
            return redirect()->back()->with('error', 'Solicitud de soporte no encontrada.');
        }
    
    }
}

///////////////////////DESCUENTOS
    public function createDes()
    {
        if (auth()->user()->is_admin === 1) 
        {
            $lista=Discount::all();
            return view('descuentos.create',['lista'=>$lista]);
        }
    }

    public function storeDes(Request $request)
    {
        if (auth()->user()->is_admin === 1) 
        {
            $denuncia = new Discount();
            $denuncia->name= $request->name;
            $denuncia->percent = $request->percent; // 1 usuario
            $denuncia->active = 1;
            $denuncia->save();
            return redirect()->back();
        }
    }

    public function editDes(Discount $discount)
    {   
        if (auth()->user()->is_admin === 1) 
        {
            return view('discounts.edit', compact('discount'));
        }
    }

    public function updateDes(Request $request, Discount $discount)
    {
        if (auth()->user()->is_admin === 1) 
        {
            $discount->update($request->all());
            return redirect()->back();
        }
    }

    public function destroyDes(Discount $discount)
    {
        if (auth()->user()->is_admin === 1) 
        {
            $discount->delete();
            return redirect()->route('nombre_de_la_ruta_donde_quieras_redirigir');
        }
    }
}
