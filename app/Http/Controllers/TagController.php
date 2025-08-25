<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Helpers\LocationHelper;
use App\Models\User;
use \App\Models\Ciudad;
use \App\Models\Cities;
use Illuminate\Support\Facades\DB;
use \App\Models\Volcado;
use Carbon\Carbon;
use \App\Models\Promotion;

class TagController extends Controller
{
    public function index()//revisado
    {
        if(auth()->user())
        {
            $tags=Tag::all()->where('level',1);
            return view('tag.index',['tags'=>$tags]);
        }
        else
        {
            return redirect(route('posts.principal'));
        }
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
    public function edit(Request $request, Tag $tag)//revisado
    {
        if(auth()->user()->is_admin ===1){
        $tags=Tag::all();
        $p = Tag::find($tag->id);
        return view('tag.index',['tags'=>$tags,'p'=>$p,'tag'=>$tag]);
        }else{return redirect()->route('posts.principal');}
    }

    public function show(Request $request, Tag $tag) //revisado
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
        if ($viewType == 'latest') {
                $users = User::where('is_admin',0)->where('level', 1)
                    ->whereHas('posts.tags', function ($query) use ($tag) {
                        $query->where('tags.id', $tag->id);
                    })
                    ->orderByDesc('created_at')
                    ->take(8)
                    ->get();
                    $posts = $tag->posts()
                    ->where('level', 1)
                    ->orderByDesc('created_at')
                    ->take(42) 
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
                        if($combined){

                        }
                    } catch (\Throwable $th) {
                        $combined=0;
                    }
        } else {
            $users = User::where('is_admin',0)->where('level', 1)
            ->whereHas('posts.tags', function ($query) use ($tag) {
                $query->where('tags.id', $tag->id);
            })
            ->inRandomOrder()
            ->take(18) 
            ->get();
            $posts =  $tag->posts()
            ->where('level', 1)
            ->inRandomOrder()
            ->take(60)
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
        if ($filterType === 'posts') {
            $posts = $posts->whereNotNull('url');
        } else if ($filterType === 'users') {
            $posts = $posts->whereNull('url');
        }
        $currentHour = Carbon::now()->format('H');
        try {
            $volcado = Volcado::where('elemento', $tag->id)
            ->where('id_elemento', 2) 
            ->where('cities_id', $ciudad->id)
            ->whereDate('fecha_metrica', Carbon::today())
            ->where('hora', $currentHour)
            ->first();
        } catch (\Throwable $th) {
            $volcado=Volcado::where('elemento', $tag->id)
            ->where('id_elemento', 2) 
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
                'elemento' => $tag->id,
                'id_elemento' => 2,
                'cities_id' => $ciudad->id,
                'fecha_metrica' => Carbon::now(),
                'hora' => $currentHour,
            ]);
            } catch (\Throwable $th) {
                Volcado::create([
                    'numero_vista' => 1,
                    'elemento' => $tag->id,
                    'id_elemento' => 2,
                    'cities_id' => 2,
                    'fecha_metrica' => Carbon::now(),
                    'hora' => $currentHour,
                ]);
            }
        }
        return view('tag.principal', [
            'promocionesSeleccionadas' => $promocionesSeleccionadas,
            'promotedUsers'=>$promotedUsers,
            'initial'=>$initial,
            'tag' => $tag,
            'posts' => $posts,
            'combined' => $combined,
            'filterType' => $filterType,
            'viewType' => $viewType,
            'cityvist' => $ciudad,
            'userss' => $users,
        ]);
    }

    public function showTag(Request $request, Tag $tag) //revisado
    {
        $location = LocationHelper::getClientCity();
        $ubicacion= new PostController();
        $ciudad=$ubicacion->ubicacion($location);
        $filterType = $request->input('filter') ?? 'all';
        $viewType = $request->input('viewType') ?? 'random';
        if ($viewType == 'latest') {
                $users = User::where('is_admin',0)->where('level', 1)
                    ->whereHas('posts.tags', function ($query) use ($tag) {
                        $query->where('tags.id', $tag->id);
                    })
                    ->orderByDesc('created_at')
                    ->take(8)
                    ->get();
                    $posts = $tag->posts()
                    ->where('level', 1)
                    ->orderByDesc('created_at')
                    ->take(42) 
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
        } else {
            $users = User::where('is_admin',0)->where('level', 1)
            ->whereHas('posts.tags', function ($query) use ($tag) {
                $query->where('tags.id', $tag->id);
            })
            ->inRandomOrder()
            ->take(18) 
            ->get();

            $posts = $tag->posts()
            ->where('level', 1)
            ->inRandomOrder()
            ->take(42) 
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
            shuffle($combined); 
            
        }   
        if ($filterType === 'posts') {
            $posts = $posts->whereNotNull('url');
        } else if ($filterType === 'users') {
            $posts = $posts->whereNull('url');
        }
        $currentHour = Carbon::now()->format('H');
        $volcado = Volcado::where('elemento', $tag->id)
            ->where('id_elemento', 2) 
            ->where('cities_id', $ciudad->id)
            ->whereDate('fecha_metrica', Carbon::today())
            ->where('hora', $currentHour)
            ->first();

        if ($volcado) {
            $volcado->increment('numero_vista');
        } else {
            Volcado::create([
                'numero_vista' => 1,
                'elemento' => $tag->id,
                'id_elemento' => 2, 
                'cities_id' => $ciudad->id,
                'fecha_metrica' => Carbon::now(),
                'hora' => $currentHour,
            ]);
        }
        return view('tag.show', [
            'tag' => $tag,
            'posts' => $posts,
            'combined' => $combined,
            'filterType' => $filterType,
            'viewType' => $viewType,
            'cityvist' => $city,
            'userss' => $users,
        ]);
    }

    public function navshowAllTags()//revisado
    {
        
        $resultado = DB::table('volcado')
        ->join('tags', 'volcado.elemento', '=', 'tags.id')
        ->select('tags.name', 'tags.level', DB::raw('SUM(volcado.numero_vista) as total_vistas'))
        ->where('volcado.id_elemento', 2)
        ->where('tags.level', 1)
        ->where('volcado.fecha_metrica', '>', DB::raw('DATE_SUB(CURDATE(), INTERVAL 15 DAY)'))
        ->groupBy('tags.name', 'tags.id', 'tags.level')
        ->orderByDesc('total_vistas')
        ->take(18) 
        ->get();


        return $resultado;


    }

    public function showAllTags() //revisado
    {

        $resultado = DB::table('posts')
        ->join('post_tag', 'posts.id', '=', 'post_tag.post_id')
        ->join('tags', 'post_tag.tag_id', '=', 'tags.id')
        ->select('tags.name', 'tags.level',  DB::raw('COUNT(posts.titulo) as count'))
        ->groupBy('tags.name', 'tags.level')
        ->get();

        return view('navbar.navtag',['tags'=>$resultado]);
    }

    public function pagesTags( ) //revisado
    {
       
            
        $resultado = Tag::where('level', 1)->paginate(60);
       
        $alfa=['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','r','s','t','u','v','w','y','z'];
        return view('navbar.navtag',['tags'=>$resultado,'alfa'=>$alfa]);
    }

    public function pagesf($filtro) 
    {
        $resultado = Tag::where('name', 'like', $filtro . '%')->paginate(60);
        $alfa=['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','r','s','t','u','v','w','y','z'];
        return view('navbar.navtag', ['tags' => $resultado, 'alfa' => $alfa,'filtro'=>$filtro]);
    }

    public function principalshowAllTags() //revisado
    {
        $tags=Tag::all()->where('level',1);
        $p=0;
        return view('navbar.principal',['tags'=>$tags,'p'=>$p]);
    }

    public function store(Request $request)//revisado
    {
        if(auth()->user()->is_admin===1){
            $this->validate($request,[
        'name'=> 'required|unique:tags|min:3|max:20']);
        $tag=new Tag;
        $tag->name=$request->name;
        $tag->fdo=$request->fdo;
        $tag->save();
        return redirect()->route('tag.index');  
        }else{return redirect()->route('posts.principal');}
        
    }

    public function update(Request $request)//revisado
    {
        if(auth()->user()->is_admin===1){
        $tag = Tag::find($request->tag_idi);
        $tag->name = $request->namei;
        $tag->fdo = $request->fdoi;
        $tag->save();
        
        return back();
        }else{return redirect()->route('posts.principal');}
    }
}
