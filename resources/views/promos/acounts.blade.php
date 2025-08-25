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

<button id="mostrarForm">Crear Promoción</button>

<div id="formulario" style="display: none;">
    <form action="{{ route('promos.storeA') }}" method="POST">
        @csrf
        <input type="text" name="username" placeholder="Nombre de Usuario">
        <input type="text" name="name" placeholder="Nombre comprador">
        <input type="text" name="email" placeholder="Correo Electrónico">
        <input type="text" name="method" placeholder="Método de Pago">
        <input type="text" name="include" placeholder="todo incluido">
        <select name="promoId">
            @foreach($promos as $promo)
                <option value="{{ $promo->id }}">{{ $promo->name }}</option>
            @endforeach
        </select>
        
        <input type="date" name="paymentDay" placeholder="Fecha de Pago">
        <input type="date" name="startDay" placeholder="Fecha de inicio">
        <input type="date" name="endDay" placeholder="Fecha de finalización">
        <button type="submit">Crear Promo</button>
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
<table>
    <thead>
        <tr>
            <th>Usuario</th>
            <th>Nombre del Comprador</th>
            <th>Email</th>
            <th>Método de Pago</th>
            <th>Incluido</th>
            <th>ID Promoción</th>
            <th>Fecha de Pago</th>
            <th>Fecha de Inicio</th>
            <th>Fecha de Finalización</th>
            <th>Activo</th>
        </tr>
    </thead>
    <tbody>
        @foreach($promotions as $promo)
        <tr style="color:#f2f2f2">
          <td>{{ $promo->user->username ?? 'N/A' }}</td>
          <td>{{ $promo->name }}</td>
          <td>{{ $promo->email }}</td>
          <td>{{ $promo->method }}</td>
          <td>{{ $promo->include }}</td>
          <td>{{ $promo->promo->name ?? 'N/A' }}</td>
          <td>{{ $promo->paymentDay }}</td>
          <td>{{ $promo->startDay }}</td>
          <td>{{ $promo->endDay }}</td>
          <td>{{ $promo->active ? "Sí" : "No" }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection