@extends('layouts.app')

@section('contenido')
<style>
    /* Estilos generales */
    body {
        font-family: Arial, sans-serif;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    th, td {
        padding: 10px;
        border: 1px solid #ccc;
    }
    
    th 
    {
        background-color: #f2f2f2;
    }
    /* Estilos para el formulario */
    #formulario {
        padding: 20px;
        border: 1px solid #ccc;
        margin-top: 20px;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .input-group {
        margin-bottom: 15px;
    }
    .input-group label {
        display: block;
        margin-bottom: 5px;
    }
    .input-group input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 3px;
    }
    button {
        padding: 10px 20px;
        border: none;
        border-radius: 3px;
        background-color: #007bff;
        color: white;
        cursor: pointer;
    }
    button[type="button"] {
        background-color: #ccc;
    }
</style>


<button id="mostrarForm">Crear Descuento</button>

<div id="formulario" style="display: none;">
    <form action="{{ route('descuentos.store') }}" method="POST" style="color:#ccc">
        @csrf

        <div class="input-group">
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div class="input-group">
            <label for="percent">Porcentaje:</label>
            <input type="number" id="percent" name="percent" required>
        </div>
        
        
        <button type="submit">Crear</button>
        <button type="button" id="cancelar">Cancelar</button>
    </form>
</div>
<script>
    document.getElementById("mostrarForm").addEventListener("click", function() {
        document.getElementById("formulario").style.display = "block";
    });
    document.getElementById("cancelar").addEventListener("click", function() {
        document.getElementById("formulario").style.display = "none";
    });
</script>
<br><br>
<table >
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Porcentaje</th>
            <th>active</th>
        </tr>
    </thead>
    <tbody >
        @foreach($lista as $descuento)
            <tr>
                <td>{{ $descuento->id }}</td>
                <td>{{ $descuento->name }}</td>
                <td>{{ $descuento->percent }}%</td>
                <td>{{ $descuento->active }} </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection