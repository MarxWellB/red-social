<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Denuncia;
use App\Models\Post;
use App\Models\User;
use App\Models\Tag;
class DenunciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    public function depost(Post $post, Request $request) //revisado
    {
        $letrasCorrespondencia = [
            'spam' => 'a',
            'acoso' => 'b',
            'contenido_ofensivo' => 'c',
            'contenido_inapropiado' => 'd',
            'violacion_de_derechos' => 'e',
            'otras_razones' => 'f',
        ];
    
        $opcionesSeleccionadas = $request->input('opciones');
        $opcionesCodificadas = [];
    
        foreach ($opcionesSeleccionadas as $opcion) {
            if (isset($letrasCorrespondencia[$opcion])) {
                $opcionesCodificadas[] = $letrasCorrespondencia[$opcion];
            }
        }
        $post->level = 2;
        $post->save();
        
        $denuncia = new Denuncia();
        $denuncia->tipo_elemento= 3;
        $denuncia->id_elemento_denunciado = $post->id; // 1 usuario
        $denuncia->correo_que_denuncia = $request->email;
        $denuncia->detalles = $request->detalles;
        $denuncia->motivacion = implode('', $opcionesCodificadas);
        $denuncia->estado= 0;
        $denuncia->save();
            
        return redirect()->route('posts.principal');
    }
    public function deuser(User $user, Request $request) //revisado
    {
        $letrasCorrespondencia = [
            'spam' => 'a',
            'acoso' => 'b',
            'contenido_ofensivo' => 'c',
            'contenido_inapropiado' => 'd',
            'violacion_de_derechos' => 'e',
            'otras_razones' => 'f',
        ];
    
        $opcionesSeleccionadas = $request->input('opciones');
        $opcionesCodificadas = [];
    
        foreach ($opcionesSeleccionadas as $opcion) {
            if (isset($letrasCorrespondencia[$opcion])) {
                $opcionesCodificadas[] = $letrasCorrespondencia[$opcion];
            }
        }
        $user->level = 2;
        $user->save();

        $denuncia = new Denuncia();
        $denuncia->tipo_elemento= 1;
        $denuncia->id_elemento_denunciado = $user->id; // 1 usuario
        $denuncia->correo_que_denuncia = $request->email;
        $denuncia->detalles = $request->detalles;
        $denuncia->motivacion = implode('', $opcionesCodificadas);        
        $denuncia->estado= 0;
        $denuncia->save();
            
        return redirect()->route('posts.principal');
    }
    public function detag(Tag $tag, Request $request)
    {
        $letrasCorrespondencia = [
            'spam' => 'a',
            'acoso' => 'b',
            'contenido_ofensivo' => 'c',
            'contenido_inapropiado' => 'd',
            'violacion_de_derechos' => 'e',
            'otras_razones' => 'f',
        ];
        $opcionesSeleccionadas = $request->input('opciones');
        $opcionesCodificadas = [];
    
        foreach ($opcionesSeleccionadas as $opcion) {
            if (isset($letrasCorrespondencia[$opcion])) {
                $opcionesCodificadas[] = $letrasCorrespondencia[$opcion];
            }
        }
        $tag->level = 2;
        $tag->save();
        $denuncia = new Denuncia();
        $denuncia->tipo_elemento= 2;
        $denuncia->id_elemento_denunciado = $tag->id; 
        $denuncia->correo_que_denuncia = $request->email;
        $denuncia->detalles = $request->detalles;
        $denuncia->motivacion = implode('', $opcionesCodificadas);
        $denuncia->estado= 0;
        $denuncia->save();


        
        return redirect()->route('posts.principal');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
