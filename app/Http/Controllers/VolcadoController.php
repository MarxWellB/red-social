<?php

namespace App\Http\Controllers;

use App\Models\Volcado;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Busqueda;
use App\Models\User;
use App\Models\OnlineStore;
use Illuminate\Http\Request;
class VolcadoController extends Controller
{
    //
    public function getEntityFromVolcado(Volcado $volcado)
    {
        switch ($volcado->id_elemento) {
            case 1:
                return Post::find($volcado->elemento);
            case 2:
                return Tag::find($volcado->elemento);
            case 3:
                return Busqueda::find($volcado->elemento);
            case 4:
                return User::find($volcado->elemento);
            case 5:
                return OnlineStore::find($volcado->elemento);
            default:
                return null;
        }
    }



}
