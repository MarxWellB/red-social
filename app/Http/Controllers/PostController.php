<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use \App\Models\Tag;
use \App\Models\PostTag;
use \App\Models\Ciudad;
use \App\Models\Cities;
use \App\Models\Country;
use \App\Models\cxsturs;
use \App\Models\CacheUser;
use \App\Models\onlinestore;
use Illuminate\Support\Facades\DB;
use App\Helpers\LocationHelper;
use App\Http\Controllers\ImagenController;
use Illuminate\Support\Facades\File;
use App\Jobs\DescargarPostRecomendado;
use GuzzleHttp\Client;
use \App\Models\Volcado;
use \App\Models\Promotion;
use Carbon\Carbon;

class PostController extends Controller
{

    public function index(User $user)//revisado
    {
        if ($user->level<>1 || $user->is_admin===1) {
            return redirect()->route('posts.principal');
        }
        $posts = Post::where('user_id', $user->id)->where('level',"=", 1)->inRandomOrder()->paginate(30);

        $tags = collect();

        foreach ($posts as $post) {
            $postTags = $post->tags()->get();
            $tags = $tags->merge($postTags);
        }

        $tags = $tags->unique('id');

        $location = LocationHelper::getClientCity();
        $ciudad=$this->ubicacion($location);
        $currentHour = Carbon::now()->format('H');
        try {
            $volcado = Volcado::where('elemento', $user->id)
            ->where('id_elemento', 4) 
            ->where('cities_id', $ciudad->id)
            ->whereDate('fecha_metrica', Carbon::today())
            ->where('hora', $currentHour)
            ->first();
        } catch (\Throwable $th) {
            $volcado=Volcado::where('elemento', $user->id)
            ->where('id_elemento', 4) 
            ->where('cities_id', 2)
            ->whereDate('fecha_metrica', Carbon::today())
            ->where('hora', $currentHour)
            ->first();
        }
        
        if ($volcado && $volcado->numero_vista < 2) {
            $volcado->increment('numero_vista');
        } else {
            try {
                Volcado::create([
                'numero_vista' => 1,
                'elemento' => $user->id,
                'id_elemento' => 4, 
                'cities_id' => $ciudad->id,
                'fecha_metrica' => Carbon::now(),
                'hora' => $currentHour,
            ]);
            } catch (\Throwable $th) {
                Volcado::create([
                    'numero_vista' => 1,
                    'elemento' => $user->id,
                    'id_elemento' => 4, 
                    'cities_id' => 2,
                    'fecha_metrica' => Carbon::now(),
                    'hora' => $currentHour,
                ]);
            }
            
            
        }
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
    public function ubicacion($location){
        $cita = $location['geoplugin_city'];
        $country = $location['geoplugin_countryName'];
        $code=$location['geoplugin_region'];
        $countra = Country::firstOrCreate(
            ['name' =>($country==""?'Unknow-'.$country:($country==null?'Unknow':$country)),'code' => ($code==""?'Unknow-'.$code:($code==null?'Unknow':$code)), 'level' => 1] // Asume 'level' predeterminado
        );

        $city = Cities::firstOrCreate(
            ['nombre_ciudad' => ($cita==''?'Unknow-'.$country:($cita==null?'Unknow':$cita)), 'country_id' => $countra->id] 
        );
        return $city;
    
    }
    public function principal(User $user) //revisado
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



        $userviable = User::where('is_admin','=',0)->where('level', 1)->pluck('id');
        $all = Post::where('level', 1)
            ->whereIn('user_id', $userviable)
            ->inRandomOrder()
            ->paginate(60);

        $maximumAttempts = 10;
        $usr = null;

        for ($attempt = 1; $attempt <= $maximumAttempts; $attempt++) {
            $usr = User::where('level', 1)->where('is_admin', 0)->inRandomOrder()->first();
            if ($usr !== null) {
                break;
            }
        }

        if ($usr === null) {
            $usr = User::where('level', 1)->where('is_admin', 0)->inRandomOrder()->first();
        }
                $location = LocationHelper::getClientCity();
                $ciudad=$this->ubicacion($location);
                $currentHour = Carbon::now()->format('H');
                try {
                    $volcado = Volcado::where('elemento', 1)
                    ->where('id_elemento', 7)
                    ->where('cities_id', $ciudad->id)
                    ->where('fecha_metrica', Carbon::today())
                    ->where('hora', $currentHour)
                    ->first();
                } catch (\Throwable $th) {
                    $volcado=Volcado::where('elemento', 1)
                    ->where('id_elemento', 7)
                    ->where('cities_id', 2)
                    ->where('fecha_metrica', Carbon::today())
                    ->where('hora', $currentHour)
                    ->first();
                }
                
                if ($volcado ) {
                    $volcado->increment('numero_vista');
                } else {
                    try {
                        Volcado::create([
                        'numero_vista' => 1,
                        'elemento' => 1,
                        'id_elemento' => 7,
                        'cities_id' => $ciudad->id,
                        'fecha_metrica' => Carbon::now(),
                        'hora' => $currentHour,
                    ]);
                    } catch (\Throwable $th) {
                        Volcado::create([
                            'numero_vista' => 1,
                            'elemento' => 1,
                            'id_elemento' => 7,
                            'cities_id' => 2,
                            'fecha_metrica' => Carbon::now(),
                            'hora' => $currentHour,
                        ]);
                    }
                    
                }
            $conx=cxsturs::all();
            $activePromotions = Promotion::where('active', 1)
                                    ->inRandomOrder()
                                    ->take(4)
                                    ->get();
        $accounts = collect();
        if ($usr) {
            $accounts->push($usr);
        }

        $accounts = $accounts->merge($activePromotions);
        $imagenes = [
            asset('img/chibi.png'),
            asset('img/bi.png')
            
        ];
        $accounts = $accounts->shuffle();
                return view('posts.principal', [
                    'promocionesSeleccionadas' => $promocionesSeleccionadas,
                    'promotedUsers'=>$promotedUsers,
                    'initial'=>$initial,
                    'all' => $all,
                    'usr'=> $usr,
                    'conx'=>$conx,
                    'imagenes'=>$imagenes
                ]);
    }

    function jaccard_similarity($setA, $setB) ////////////////////
    {
        $intersection = count(array_intersect($setA, $setB));
        $union = count(array_unique(array_merge($setA, $setB)));
        
        if ($union === 0) {
            return 0;
        }
        
        return $intersection / $union;
    }
    
    public function create()//revisado
    {
        if(auth()->user()){
        $tags = Tag::all();
        $userStores = cxsturs::where('user_id', auth()->user()->id)->pluck('onlinestore_id')->toArray();
        $onlinestores = onlinestore::whereIn('id', $userStores)->get();
        
        return view('posts.create', ['tags' => $tags, 'onlinestores' => $onlinestores]);
        }else{ return redirect()->route('posts.principal');}
    }

    public function store(Request $request)//revisado
    {
        if(auth()->user()){
        $validatedData = $request->validate([
            'titulo' => 'required|max:255',
            'url' => 'required',
            'tags' => 'required|string|max:255',
        ]);

        $post = $request->user()->posts()->create([
            'titulo' => $validatedData['titulo'],
            'url' => $validatedData['url'],
            'onlinestore_id' => $request->red,
            'user_id' => $request->user()->id,
            'flushe' => 1,
            'related' => 1
        ]);
        $tagList = Tag::all();
        $tags = array_map('trim', explode(',', $validatedData['tags']));

        foreach ($tags as $tagName) {
            $tag = Tag::where('name', $tagName)->first();

            if ($tag) {
                $tag->increment('counter');
            } else {
                $tag = Tag::create(['name' => $tagName, 'fdo' => 'https://pbs.twimg.com/media/F2OfxkSXMAAXrH0?format=webp&name=small', 'counter' => 1]);
                $tag->increment('counter');
            }
            $post->tags()->attach($tag->id);
        }

        return redirect()->route('posts.index', auth()->user()->username);
        }else{ return redirect()->route('posts.principal');}
    }

    public function descargarcache(Post $post){
            if (!function_exists('imageExists')) {
            function imageExists($url) { 
            if ($url>0) {
                $headers = get_headers($url);
                if (strpos($headers[0], '200') !== false) {
                    try {
                        $image_info = getimagesize($url);
                        if ($image_info !== false) {
                            return true;
                        }
                    } catch (Exception $e) {
                        return false;
                    }
                }
            }
            return false;
        }
        }
        if($post->cache_active == 0 && imageExists($post->url)) {
            $imageUrl = $post->url;
            $post->cache_active = 1;
            $post->fecha_cache = now();
            $size=getimagesize($imageUrl);
            $post->image_height=$size[1];
            $post->width=$size[0];
            $post->save(); 
            if (filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                $client = new Client();
        
                try {
                    $response = $client->get($imageUrl);
        
                    if ($response->getStatusCode() === 200) {
                        $imageContent = $response->getBody()->getContents();
        
                        $nombreImagen = $post->id . '.png';
        
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
    }
    
    public function show(User $user,Post $post)
    {
                if($post->cache_active == 0) {
                    $post->cache_active = 1;
                    $post->fecha_cache = now();
                    $post->save(); 
                    $imageUrl = $post->url;        
                    if (filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                        $client = new Client();        
                        try {
                            $response = $client->get($imageUrl);
                
                            if ($response->getStatusCode() === 200) {
                                $imageContent = $response->getBody()->getContents();
                
                                $nombreImagen = $post->id . '.png';
                
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
                $currentPostTags = $post->tags()->pluck('tag_id')->toArray();
                
                $userviable = User::where('is_admin',0)->where('level', 1)->pluck('id');
                $tags = $post->tags()->orderBy('name')->get();
                $onlinestore = $post->onlinestore;
                $url = User::select('prof')->where('name', $post->name);
                $location = LocationHelper::getClientCity();
                $ciudad=$this->ubicacion($location);
                $currentHour = Carbon::now()->format('H');
                try {
                    $volcado = Volcado::where('elemento', $post->id)
                    ->where('id_elemento', 1)
                    ->where('cities_id', $ciudad->id)
                    ->where('fecha_metrica', Carbon::today())
                    ->where('hora', $currentHour)
                    ->first();
                } catch (\Throwable $th) {
                    $volcado=Volcado::where('elemento', $post->id)
                    ->where('id_elemento', 1)
                    ->where('cities_id', 2)
                    ->where('fecha_metrica', Carbon::today())
                    ->where('hora', $currentHour)
                    ->first();
                }
                if ($volcado ) {
                    $volcado->increment('numero_vista');
                } else {
                    try {
                        Volcado::create([
                        'numero_vista' => 1,
                        'elemento' => $post->id,
                        'id_elemento' => 1,
                        'cities_id' => $ciudad->id,
                        'fecha_metrica' => Carbon::now(),
                        'hora' => $currentHour,
                    ]);
                    } catch (\Throwable $th) {
                        Volcado::create([
                            'numero_vista' => 1,
                            'elemento' => $post->id,
                            'id_elemento' => 1,
                            'cities_id' => 2,
                            'fecha_metrica' => Carbon::now(),
                            'hora' => $currentHour,
                        ]);
                    }
                    
                }
                $postsWithSharedTags = Post::where('id', '!=', $post->id) 
                ->whereHas('tags', function ($query) use ($currentPostTags) {
                    $query->whereIn('tags.id', $currentPostTags);
                })
                ->take(60)->get();
            $similarPosts = $postsWithSharedTags->filter(function ($similarPost) use ($currentPostTags) {
            $similarPostTags = $similarPost->tags()->pluck('tags.id')->toArray();
            $similarity = $this->jaccard_similarity($currentPostTags, $similarPostTags);
            return $similarity >= 0.5;
            });
            if ($similarPosts->count() < 60) {
            $userviable = User::where('level', 1)->pluck('id');
            $additionalPosts = Post::where('level', 1)
                ->whereIn('user_id', $userviable)
                ->whereNotIn('id', $similarPosts->pluck('id')->toArray())
                ->inRandomOrder()
                ->limit(60 - $similarPosts->count())
                ->get();

            $similarPosts = $similarPosts->merge($additionalPosts);
            }
                    return view('posts.show', [
                        'post' => $post,
                        'user' => $user,
                        'all' => $similarPosts,
                        'tags' => $tags,
                        'onlinestore' => $onlinestore,
                        'url' => $url,
                    ]);
    }

    public function destroy(Post $post)
    {
        if (auth()->user()) {
            $this->authorize('delete', $post);
            $tags = $post->tags;
            DB::transaction(function () use ($tags, $post) {
                foreach ($tags as $tag) {
                    if ($tag->counter > 0) {
                        $tag->decrement('counter');
                    }
                }
                $post->delete();
            });
    
            return redirect()->route('posts.index', auth()->user()->username);
        } else {
            return redirect()->route('posts.principal');
        }
    }
    
}
