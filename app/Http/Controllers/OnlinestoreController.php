<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\onlinestore;
use App\Models\Post;
use App\Models\User;
use \App\Models\Ciudad;
use \App\Models\Cities;
use Illuminate\Support\Facades\DB;
use App\Helpers\LocationHelper;
use \App\Models\Volcado;
use Carbon\Carbon;
use \App\Models\Promotion;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redis;


class OnlinestoreController extends Controller
{
        protected $table = 'onlinestore';
       
    public function index()
    {
        
        if (!auth()->user()) {
            return redirect()->route('posts.principal');
        }
        
        
            $stores=onlinestore::all();
            return view('store.index',['stores'=>$stores]);

    }
    public function obtenerPromocionesActivas() {
        $promocionesActivas = Promotion::where('active', 1)
                                        ->with('listaPromocion') 
                                        ->get();
        
        foreach ($promocionesActivas as $promocion) {
            if ($promocion->method == 99) { 
                $promocion->tipo = 'personalizada';
            } elseif ($promocion->id_type == 1) {
                $promocion->tipo = 'basico';
            } elseif ($promocion->id_type == 2) {
                $promocion->tipo = 'medium';
            } elseif ($promocion->id_type == 3) {
                $promocion->tipo = 'premium';
            } else {
                $promocion->tipo = 'desconocido'; 
            }
        }
    
        return $promocionesActivas;
    }
    public function all()
    {
        $userProms=Promotion::where('active',1)->get();
        $promocionesSeleccionadas = [];
        $promocionesDisponibles = $this->obtenerPromocionesActivas();
    
        $contadorPremium = 0;
        $contadorMedium = 0;
        $contadorBasico = 0;
        $contadorPersonalizada = 0;
    
        foreach ($promocionesDisponibles as $promocion) {
            if ($contadorPremium < 4 && $promocion->tipo == 'premium') {
                $promocionesSeleccionadas[] = $promocion;
                $contadorPremium++;
            } elseif ($contadorMedium < 2 && $promocion->tipo == 'medium') {
                $promocionesSeleccionadas[] = $promocion;
                $contadorMedium++;
            } elseif ($contadorBasico < 1 && $promocion->tipo == 'basico') {
                $promocionesSeleccionadas[] = $promocion;
                $contadorBasico++;
            } elseif ($contadorPersonalizada < 1 && $promocion->tipo == 'personalizada') {
                $promocionesSeleccionadas[] = $promocion;
                $contadorPersonalizada++;
            }
        }
    
        foreach ($promocionesDisponibles as $promocion) {
            if (count($promocionesSeleccionadas) < 10 && !in_array($promocion, $promocionesSeleccionadas)) {
                $promocionesSeleccionadas[] = $promocion;
            }
        }
        $promocionesSeleccionadas = collect($promocionesSeleccionadas); 
        $idsPromociones = $promocionesSeleccionadas->pluck('idUsr'); 

        $promotedUsers = User::where('level', 1)->whereIn('id', $idsPromociones)->get();
        $promotedUsers = $promotedUsers->shuffle();
        $initial = $promotedUsers->splice(0, 2);


        $os=Onlinestore::all();

        return view('store.all',[
            'promocionesSeleccionadas' => $promocionesSeleccionadas,
            'promotedUsers'=>$promotedUsers,
            'initial'=>$initial,
            'os'=>$os]);
    }
    public function update(Request $request)
    {
        

            
        $store = Onlinestore::find($request->tag_idi);
        $store->nombre = $request->namei;
        
        if($request->logoi){
            $imageUrl = $request->logoi;
            $client = new Client();
                $response = $client->get($imageUrl);


                if ($response->getStatusCode() === 200) {
                    $imageContent = $response->getBody()->getContents();
                    $gdImage = imagecreatefromstring($imageContent);
                    if ($gdImage !== false) {
                        $nombreImagen = time() . '.jpg';
                        $rutaAlmacenamiento = public_path('img/' . $nombreImagen);
                            $width = imagesx($gdImage);
                            $height = imagesy($gdImage);
                            $newWidth = $width / 2; 
                            $newHeight = $height / 2; 

                            $resizedImage = imagescale($gdImage, $newWidth, $newHeight);
                            imagejpeg($resizedImage, $rutaAlmacenamiento, 75);
                            imagedestroy($resizedImage);}}
                            $store->logourl = $nombreImagen;
        }
        
        $store->fdo=$request->fdoi;
        $store->save();
    
        return redirect()->route('store.index');
    }
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required'
        ]);
            $imageUrl = $request->logo;
            $client = new Client();
                $response = $client->get($imageUrl);


                if ($response->getStatusCode() === 200) {
                    $imageContent = $response->getBody()->getContents();
                    $gdImage = imagecreatefromstring($imageContent);
                    if ($gdImage !== false) {
                        $nombreImagen = time() . '.jpg';
                        $rutaAlmacenamiento = public_path('img/' . $nombreImagen);
                            $width = imagesx($gdImage);
                            $height = imagesy($gdImage);
                            $newWidth = $width / 2; 
                            $newHeight = $height / 2;

                            $resizedImage = imagescale($gdImage, $newWidth, $newHeight);
                            imagejpeg($resizedImage, $rutaAlmacenamiento, 75);
                            imagedestroy($resizedImage);
            $store = new Onlinestore;
            $store->nombre = $validated['name'];
            $store->logourl = $nombreImagen;
            $store->fdo = $request->fdo;
            $store->save();
                    }
                }
            
            
        
            return redirect()->route('store.index');
      
    }
    public function indexStore()
    {
        if(auth())
        {
            return view('store.enlace');
        }else
        {
            return redirect()->route('posts.principal');
        }
    }
    public function navShowOs()
    {
        $resultado = DB::table('volcado')
            ->join('onlinestores', 'volcado.elemento', '=', 'onlinestores.id')
            ->select('onlinestores.nombre','onlinestores.logourl', DB::raw('SUM(volcado.numero_vista) as total_vistas'))
            ->where('volcado.id_elemento', 3)
            ->where('volcado.fecha_metrica', '>', DB::raw('DATE_SUB(CURDATE(), INTERVAL 15 DAY)'))
            ->groupBy('onlinestores.nombre', 'onlinestores.id', 'onlinestores.logourl')
            ->orderByDesc('total_vistas')
            ->take(3) 
            ->get();
        return $resultado;
    }
    public function storead(Request $request)
    {
        $usuario = User::find(auth()->user()->id);
        $onlinestoreId = (int)explode('-', $request->input('action'))[1]; 
        $enlace = $request->input('enlaces.' . $onlinestoreId); 
        $onlinestore = Onlinestore::find($onlinestoreId);
    
        if ($request->input('action') === 'create-' . $onlinestoreId) { 
            $usuario->onlinestores()->syncWithoutDetaching([$onlinestoreId => ['enlace' => $enlace]]); 
        } elseif ($request->input('action') === 'update-' . $onlinestoreId) { 
            $usuario->onlinestores()->syncWithoutDetaching([$onlinestoreId => ['enlace' => $enlace]]); 
        } elseif ($request->input('action') === 'delete-' . $onlinestoreId) { 
            $usuario->onlinestores()->detach($onlinestoreId); 
        }
    
        return redirect()->back();
    }
    public function show(Request $request, OnlineStore $onlineStore)
{   
    $userProms=Promotion::where('active',1)->get();
    $promocionesSeleccionadas = [];
    $promocionesDisponibles = $this->obtenerPromocionesActivas();
    $contadorPremium = 0;
    $contadorMedium = 0;
    $contadorBasico = 0;
    $contadorPersonalizada = 0;

    foreach ($promocionesDisponibles as $promocion) {
        if ($contadorPremium < 4 && $promocion->tipo == 'premium') {
            $promocionesSeleccionadas[] = $promocion;
            $contadorPremium++;
        } elseif ($contadorMedium < 2 && $promocion->tipo == 'medium') {
            $promocionesSeleccionadas[] = $promocion;
            $contadorMedium++;
        } elseif ($contadorBasico < 1 && $promocion->tipo == 'basico') {
            $promocionesSeleccionadas[] = $promocion;
            $contadorBasico++;
        } elseif ($contadorPersonalizada < 1 && $promocion->tipo == 'personalizada') {
            $promocionesSeleccionadas[] = $promocion;
            $contadorPersonalizada++;
        }
    }
    foreach ($promocionesDisponibles as $promocion) {
        if (count($promocionesSeleccionadas) < 10 && !in_array($promocion, $promocionesSeleccionadas)) {
            $promocionesSeleccionadas[] = $promocion;
        }
    }
    $promocionesSeleccionadas = collect($promocionesSeleccionadas); 
    $idsPromociones = $promocionesSeleccionadas->pluck('idUsr'); 

    $promotedUsers = User::where('level', 1)->whereIn('id', $idsPromociones)->get();
    $promotedUsers = $promotedUsers->shuffle();
    $initial = $promotedUsers->splice(0, 2);
    $location = LocationHelper::getClientCity();
    
    $ubicacion= new PostController();
    $ciudad=$ubicacion->ubicacion($location);
    $filterType = $request->input('filter') ?? 'all';
    $viewType = $request->input('viewType') ?? 'random';
    if ($viewType=='latest') {
        
        $users = User::where('level',1)
        ->where('is_admin', '=', 0)
        ->where('id_country', '!=', $ciudad)
            ->whereHas('onlinestores', function($query) use ($onlineStore) {
                $query->where('onlinestore_id', $onlineStore->id);})->orderByDesc('created_at')
                ->take(8)
                ->get();
        $posts = Post::where('level',1)
        ->where('onlinestore_id',$onlineStore->id)   
                ->orderByDesc('created_at')
                    ->take(30) 
                    ->get();
        foreach ($posts as $post) {
                    $combined[] = [
                    'type' => 'post',
                    'data' => $post,
                ];
        }
            
        foreach ($users as $user) {
                    $combined[] = [
                    'type' => 'user',
                    'data' => $user,
                ];
        }
    }else {
            $users = User::where('level',1)
            ->where('is_admin', '=', 0)
            ->where('id_country', '!=', $ciudad)
                ->whereHas('onlinestores', function($query) use ($onlineStore) {
                    $query->where('onlinestore_id', $onlineStore->id);
                    })
                ->inRandomOrder()
                ->take(8) 
                ->get();
            $posts = Post::where('level',1)
                ->where('onlinestore_id',$onlineStore->id)                
                ->inRandomOrder()
                ->take(30) 
                ->get();
            foreach ($posts as $post) {
                $combined[] = [
                    'type' => 'post',
                    'data' => $post,
                    ];
            }        
            foreach ($users as $user) {
                    $combined[] = [
                    'type' => 'user',
                    'data' => $user,
                    ];
            }
            try {
                shuffle($combined); 
            } catch (\Throwable $th) {
                $combined=0;
            }
    }
    $posts = $onlineStore->posts()
                ->join('users', 'users.id', '=', 'posts.user_id');
    if ($filterType === 'posts') {
        $combined = array_filter($combined, function ($item) {
            return $item['type'] === 'post';
        });
    } else if ($filterType === 'users') {
        $combined = array_filter($combined, function ($item) {
            return $item['type'] === 'user';
        });
    }

    
    $currentHour = Carbon::now()->format('H');
    try {
        $volcado = Volcado::where('elemento', $onlineStore->id)
        ->where('id_elemento', 3) 
        ->where('cities_id', $ciudad->id)
        ->whereDate('fecha_metrica', Carbon::today())
        ->where('hora', $currentHour)
        ->first();
    } catch (\Throwable $th) {
        $volcado=Volcado::where('elemento', $onlineStore->id)
        ->where('id_elemento', 3) 
        ->where('cities_id', 2)
        ->whereDate('fecha_metrica', Carbon::today())
        ->where('hora', $currentHour)
        ->first();
    }
    if ($volcado) {
        $volcado->increment('numero_vista');
    } else {
        try {
            Volcado::create([
            'numero_vista' => 1,
            'elemento' => $onlineStore->id,
            'id_elemento' => 3,
            'cities_id' => $ciudad->id,
            'fecha_metrica' => Carbon::now(),
            'hora' => $currentHour,
        ]);
        } catch (\Throwable $th) {
            Volcado::create([
                'numero_vista' => 1,
                'elemento' => $onlineStore->id,
                'id_elemento' => 3,
                'cities_id' => 2,
                'fecha_metrica' => Carbon::now(),
                'hora' => $currentHour,
            ]);
        }
    }

    return view('store.show', [
        'promocionesSeleccionadas' => $promocionesSeleccionadas,
        'promotedUsers'=>$promotedUsers,
        'initial'=>$initial,
        'posts' => $posts,
        'combined' => $combined,
        'filterType' => $filterType,
        'onlineStore' => $onlineStore,
        'cityvist'=>$ciudad,
        'userss'=>$users
    ]);
}


}
