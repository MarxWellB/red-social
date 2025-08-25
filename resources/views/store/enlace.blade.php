@extends('layouts.app')

@section('titulo')
    Editar Perfil : {{auth()->user()->username}}
@endsection

@section('contenido')
    <style>
        label{
            color: aliceblue;
        }
        input[type="checkbox"],
    input[type="text"],
    button {
        display: block;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        padding: 5px;
        border-radius: 5px;
    }

    input[type="checkbox"] {
        margin-right: 10px;
    }

    button[type="submit"] {
        background-color: #4CAF50;
        color: white;
        border: none;
        padding: 10px;
        border-radius: 5px;
    }

    button[type="submit"]:hover {
        cursor: pointer;
        background-color: #2D862D;
    }

    ul {
        margin-top: 20px;
        padding: 0;
    }

    li {
        margin-bottom: 10px;
    }

    .enlace-tienda {
        margin-bottom: 5px;
        display: flex;
        align-items: center;
    }

    .enlace-tienda__nombre {
        margin-right: 10px;
    }

    .enlace-tienda__enlace {
        margin-right: 10px;
        border: none;
        background-color: #eee;
        padding: 5px;
        border-radius: 5px;
        flex: 1;
    }

    .enlace-tienda__boton {
        background-color: #f44336;
        color: white;
        border: none;
        padding: 5px;
        border-radius: 5px;
    }

    .enlace-tienda__boton:hover {
        cursor: pointer;
        background-color: #d42d21;
    }
    form{
        display: flex;
    }
    th,td{
        color: #ccc;
    }
    </style>
    @php
          $onlinestores = \App\Models\onlinestore::all();
          $conx= \App\Models\cxsturs::all()->where('user_id');
         $conexion = auth()->user()->onlinestores()->get()->keyBy('id')->toArray();

        @endphp

<h2>Enlaces de tiendas en línea</h2>

<form action="{{route('store.storead')}}" method="post">
    @csrf

    <table>
        <thead>
            <tr>
                <th>Tienda en línea</th>
                <th>Enlace</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($onlinestores as $onlinestore)
                <tr>
                    <td>{{ $onlinestore->nombre }}</td>
                    <td>
                        <input type="text" name="enlaces[{{ $onlinestore->id }}]" value="{{ $conx->where('onlinestore_id', $onlinestore->id)->where('user_id', auth()->user()->id)->first()->enlace ?? '' }}"
                        >

                    </td>
                    <td style="display: flex;">
                        @if(auth()->user()->onlinestores->find($onlinestore->id))
                            <button type="submit" name="action" value="update-{{ $onlinestore->id }}">Guardar cambios</button>
                            <button type="submit" name="action" value="delete-{{ $onlinestore->id }}">Eliminar enlace</button>
                        @else
                            <button type="submit" name="action" value="create-{{ $onlinestore->id }}">Guardar enlace</button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</form>

@endsection