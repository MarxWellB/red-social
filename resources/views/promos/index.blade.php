@extends('layouts.app')

@section('contenido')
<style>
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
    <form action="{{ route('promos.store') }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Nombre">
        <input type="number" name="cost" placeholder="Costo">
        <input type="number" name="time" placeholder="Tiempo en días">
        <button type="submit">Crear Promo</button>
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
            <th>Nombre</th>
            <th>costo</th>
            <th>dias</th>
            <th>active</th>
        </tr>
    </thead>
    <tbody style="color:#f2f2f2">
        @foreach($promos as $promo)
        <tr>
            <td>{{ $promo->name }}</td>
            <td>${{ $promo->cost }}</td>
            <td>{{ $promo->time }}</td>
            <td>{{ $promo->active===1?"si":"no"; }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection