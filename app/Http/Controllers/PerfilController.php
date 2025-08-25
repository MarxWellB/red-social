<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CacheUser;
use App\Models\Tag;
use Illuminate\Support\Str;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\File;
use \App\Models\Promotion;
class PerfilController extends Controller
{
    
    public function index() //revisado
    {
        if(auth()->user()){
            return view('perfil.index');
        }else{
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
    public function showmodels()//revisado
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



        $alfa=['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','r','s','t','u','v','w','y','z'];
        $users = User::where('level', 1)->where('is_admin',0)->paginate(48);
        return view('perfil.show', [
            'users' => $users,
            'alfa'=>$alfa,
            'promocionesSeleccionadas' => $promocionesSeleccionadas,
            'promotedUsers'=>$promotedUsers]);
    }
    public function showmodelsf($filtro)//revisado
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
        $alfa=['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','r','s','t','u','v','w','y','z'];
        $users = User::where('level', 1)->where('is_admin',0)->where('name', 'like', $filtro . '%')->paginate(68);
        return view('perfil.show', [
            'promocionesSeleccionadas' => $promocionesSeleccionadas,
            'promotedUsers'=>$promotedUsers,
            'initial'=>$initial,
            'users' => $users,
            'alfa'=>$alfa,
            'filtro'=>$filtro]);
    }

    public function store(Request $request) //revisado
    {
        $this->middleware('auth');
        $request->request->add(['username'=>Str::slug($request->username)]);
        $this->validate($request,[
            'nombre'=>'min:3',
            'username'=>['unique:users,username,'.auth()->user()->id,'min:3','max:20','not_in:twitter'],
            
        ]);
        $usuario=User::find(auth()->user()->id);
    
        
        $usuario->name=$request->nombre;
        $usuario->email=$request->email;
        $usuario->id_country=$request->country;
        $usuario->description=$request->descripcion;
        $usuario->prof=$request->perfil;
        $usuario->biograph=$request->bio;
        $lastusername=$usuario->username;
        $usuario->username=$request->username;

        $this->descargarcache($usuario,$lastusername);
        $usuario->profile_cach=1;
        $usuario->save();
        return redirect()->route('posts.index',$usuario->username);
    }    
    public function descargarcache(User $user,$lastusername){
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
    

    if( imageExists($user->prof)) {

        $imageUrl = $user->prof;
            // Proceder a eliminar el caché
                // Eliminar el archivo de caché
                $cache = public_path('img' . DIRECTORY_SEPARATOR . 'P'.$lastusername . '.png');
                if (File::exists($cache)) {
                    File::delete($cache);
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
}
    public function showTag() //revisado
    {
        return view('tag.show');
    }
}
