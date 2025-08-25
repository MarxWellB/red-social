<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\DB;
use App\Helpers\LocationHelper;
use App\Http\Controllers\ImagenController;

use GuzzleHttp\Client;

use \App\Models\Post;
use Carbon\Carbon;

class DescargarPostRecomendado implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Post $post)
    {
        if($post->cache_active == 1) {
            // Obtener la URL de la imagen
            $imageUrl = $post->url;
        
            // Verificar si la URL de la imagen es válida
            if (filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                // Configurar el cliente Guzzle
                $client = new Client();
        
                try {
                    // Realizar la solicitud para descargar la imagen
                    $response = $client->get($imageUrl);
        
                    // Verificar si la solicitud fue exitosa
                    if ($response->getStatusCode() === 200) {
                        // Obtener el contenido de la imagen descargada
                        $imageContent = $response->getBody()->getContents();
        
                        // Generar un nombre único para la imagen (usando el ID del post)
                        $nombreImagen = $post->id . '.png';
        
                        // Definir la ubicación donde se almacenará la imagen en tu servidor
                        $rutaAlmacenamiento = public_path('img' . DIRECTORY_SEPARATOR . $nombreImagen);
        
                        // Almacenar la imagen en el servidor
                        if (!file_exists($rutaAlmacenamiento)) 
                        {
                            file_put_contents($rutaAlmacenamiento, $imageContent);
                        }
                        // Actualizar el campo url del Post
                        // Guardar el modelo Post actualizado en la base de datos
                    } else {
                        // Manejar el caso en que la solicitud no sea exitosa
                        return "No se pudo descargar la imagen. Código de estado: " . $response->getStatusCode();
                    }
                } catch (\Exception $e) {
                    // Manejar excepciones en caso de errores
                    return "Error al descargar la imagen: " . $e->getMessage();
                }
            } else {
                return "URL de imagen no válida.";
            }
        }
        //
    }
}
