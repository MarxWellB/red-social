<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Tag;
use \App\Models\Ciudad;
use \App\Models\Cities;
use Illuminate\Support\Facades\DB;
use \App\Models\Volcado;
use Carbon\Carbon;
use App\Models\busquedas;
use App\Helpers\LocationHelper;


class SearchController extends Controller
{
    //
    function jaccard_similarity($setA, $setB) ////////////////////
    {
        $intersection = count(array_intersect($setA, $setB));
        $union = count(array_unique(array_merge($setA, $setB)));
        
        if ($union === 0) {
            return 0;
        }
        
        return $intersection / $union;
    }
    public function buscar(Request $request)
    {    
        $this->validate($request,[
                    'q'=>'required|min:1',
                ]);
                    $q = $request->input('q');
                    
                    if(strlen($q)>1){
                        if (strpos($q, ':') === 0) {
                            // Eliminar el ':' y dividir los tags
                            $tagNames = explode(',', substr($q, 1));
                            $tagNames = array_filter(array_map('trim', $tagNames));

                            // Obtener los tags de la base de datos
                            $tags = Tag::whereIn('name', $tagNames)->get();

                            // Si no se encontraron tags, no hay posts para mostrar
                            if ($tags->isEmpty()) {
                                return view('search.posts', ['posts' => collect()]);
                            }

                            // Obtener los IDs de los tags
                            $tagIds = $tags->pluck('id');

                            // Buscar posts que contengan todos los tags especificados
                            $postsWithSharedTags = Post::whereHas('tags', function ($query) use ($tagIds) {
                                $query->whereIn('tags.id', $tagIds);
                            })->paginate(60);

                            /* Filtrar posts por medida de similitud (Jaccard)
                            $similarPosts = $postsWithSharedTags->filter(function ($post) use ($tagIds) {
                                $postTagIds = $post->tags->pluck('id')->toArray();
                                $similarity = $this->jaccard_similarity($tagIds->toArray(), $postTagIds);
                                return $similarity >= 0.5;
                            });
                        */
                            // Retornar la vista con los posts filtrados
                            return view('search.posts', ['posts' => $postsWithSharedTags]);
                    } else {
                        $posts = Post::whereRaw('BINARY titulo LIKE ?', ['%' . $q . '%'])
                        ->orWhereHas('tags', function($query) use ($q) {
                            $query->whereRaw('BINARY name LIKE ?', ['%' . $q . '%']);
                        })
                        ->distinct()->take(30)
                        ->get();
                        $tags = Tag::whereRaw('BINARY name LIKE ?', ['%' . $q . '%'])
                        ->take(20)
                        ->get();
                        $cuentas = User::whereRaw('BINARY name LIKE ?', ['%' . $q . '%'])
                        ->orWhereRaw('BINARY username LIKE ?', ['%' . $q . '%'])->take(10)
                        ->get();
                    }
                        }else{
                            $posts = Post::whereRaw('BINARY titulo LIKE ?', [ $q . '%'])
                            ->orWhereHas('tags', function($query) use ($q) {
                                $query->whereRaw('BINARY name LIKE ?', [ $q . '%']);
                            })
                            ->distinct()->take(60)
                            ->get();
                            $tags = Tag::whereRaw('BINARY name LIKE ?', [ $q . '%'])->take(40)
                            ->get();; $cuentas = User::whereRaw('BINARY name LIKE ?', [ $q . '%'])
                            ->orWhereRaw('BINARY username LIKE ?', [ $q . '%'])->take(40)
                            ->get();
                        }
                    try {
                        $busqueda = busquedas::where('nombre', $q)->first();
                    } catch (\Throwable $th) {
                        $busqueda=false;
                    }
                    if ($busqueda) {
                    } else {
                        busquedas::create([
                            'nombre' => $q
                        ]);
                    }
                    $location = LocationHelper::getClientCity();
                    $ubicacion= new PostController();
                    $ciudad=$ubicacion->ubicacion($location);
                    $currentHour = Carbon::now()->format('H');
                $busqueda = busquedas::firstOrCreate(
                    ['nombre' => $q],
                    ['otros_campos' => 'valor']  
                );
                $idElemento = $busqueda->id; 
                try {
                    $volcado = Volcado::where('elemento', $idElemento)
                    ->where('id_elemento', 5)
                    ->where('cities_id', $ciudad->id)
                    ->whereDate('fecha_metrica', Carbon::today())
                    ->where('hora', $currentHour)
                    ->first();
                } catch (\Throwable $th) {
                    $volcado=Volcado::where('elemento', $idElemento)
                    ->where('id_elemento', 5)
                    ->where('cities_id', 2)
                    ->whereDate('fecha_metrica', Carbon::today())
                    ->where('hora', $currentHour)
                    ->first();
                }
                if ($volcado) {
                    $volcado->increment('numero_vista');
                } else {
                    if ($ciudad) {
                        Volcado::create([
                            'numero_vista' => 1,
                            'elemento' => $idElemento,
                            'id_elemento' =>5 ,
                            'cities_id' => $ciudad->id,
                            'fecha_metrica' => Carbon::today(),
                            'hora' => $currentHour,
                        ]);
                    } else {
                        Volcado::create([
                            'numero_vista' => 1,
                            'elemento' => $idElemento,
                            'id_elemento' =>5 ,
                            'cities_id' => 2, 
                            'fecha_metrica' => Carbon::today(),
                            'hora' => $currentHour,
                        ]);
                    }
                }
            return view('search.index', compact('posts', 'cuentas', 'tags','q'));
    }

    public function buscarPosts( $q){
       
                    if(strlen($q)>1){
                        $posts = Post::whereRaw('BINARY titulo LIKE ?', ['%' . $q . '%'])
                        ->orWhereHas('tags', function($query) use ($q) {
                            $query->whereRaw('BINARY name LIKE ?', ['%' . $q . '%']);
                        })
                        ->distinct()->paginate(60);
    
                        }else{
                            $posts = Post::whereRaw('BINARY titulo LIKE ?', [ $q . '%'])
                            ->orWhereHas('tags', function($query) use ($q) {
                                $query->whereRaw('BINARY name LIKE ?', [ $q . '%']);
                            })
                            ->distinct()->paginate(60);
        
                        }
                
                    
                        return view('search.posts', ['posts' => $posts]);
    }
    public function buscarTags( $q){
        if(strlen($q)>1){
        $tags = Tag::whereRaw('BINARY name LIKE ?', ['%' . $q . '%'])
        ->paginate(40);
        }else{
            $tags = Tag::whereRaw('BINARY name LIKE ?', [ $q . '%'])
        ->paginate(40);
        }

    
        return view('search.tags', ['tags' => $tags]);
    }
    public function buscarAccounts( $q){
                    if(strlen($q)>1){
                        $cuentas = User::whereRaw('BINARY name LIKE ?', ['%' . $q . '%'])
                        ->orWhereRaw('BINARY username LIKE ?', ['%' . $q . '%'])->paginate(40);
                    }else{
                        $cuentas = User::whereRaw('BINARY name LIKE ?', [ $q . '%'])
                        ->orWhereRaw('BINARY username LIKE ?', [ $q . '%'])->paginate(40);
                    }
                    return view('search.accounts', ['cuentas' => $cuentas]);
    }
}
