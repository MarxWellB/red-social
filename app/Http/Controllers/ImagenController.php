<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Redis;

class ImagenController extends Controller
{
    //
    public function store(Request $request)
    {
        $image =$request->file('file');
        $nombreImagen=Str::uuid().".".$image->extension();
        $iamgenServidor=Image::make($image);
        $imagenPath=public_path('uploads').'/'.$nombreImagen;
        $iamgenServidor->save($imagenPath);
        return response()->json(['imagen'=> "probando respuesta"]);
    }


    public function descargar($post)
{
    $lockKey = 'lock:' . $post->id;

    if (Redis::setnx($lockKey, 1)) {
        try {
            if ($post->cache_active == 1) {
                $imageUrl = $post->url;
                $client = new Client();
                $response = $client->get($imageUrl);

                if ($response->getStatusCode() === 200) {
                    $imageContent = $response->getBody()->getContents();

                    $gdImage = imagecreatefromstring($imageContent);
                    if ($gdImage !== false) {
                        $nombreImagen = $post->id . '.jpg';
                        $rutaAlmacenamiento = public_path('img/' . $nombreImagen);

                        $width = imagesx($gdImage);
                        $height = imagesy($gdImage);
                        $newWidth = $width / 2; 
                        $newHeight = $height / 2;                            
                        $resizedImage = imagescale($gdImage, $newWidth, $newHeight);
                        imagejpeg($resizedImage, $rutaAlmacenamiento, 75);
                        imagedestroy($resizedImage);
                        $post->cache_active = 1;
                        $post->fecha_cache = now();
                        $post->save(); 
                    }
                }
            }
        } finally {
            
            Redis::del($lockKey);
        }
    } else {
        return "Otro proceso ya está descargando la imagen. Por favor, espera.";
    }
    return $post;
}
}
