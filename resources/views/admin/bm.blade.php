@extends('layouts.app')
@section('contenido')
<div class="container">
    <h2>Gestión de Promociones</h2>
    <form action="{{ route('admin.updatePromotionHours') }}" method="post">
        @csrf
        <button type="submit" class="btn btn-warning">calcular horas activas</button>
    </form>
    <style>
        th,td{
            color: aliceblue;
        }
    </style>
    <form action="{{ route('admin.BasicManagment') }}" method="GET">
        <input type="text" name="user_name" placeholder="Nombre de Usuario" value="{{ request('user_name') }}">
        <select name="type">
            <option value="">Selecciona Tipo</option>
            <option value="1" {{ request('type') == '1' ? 'selected' : '' }}>Básica</option>
            <option value="2" {{ request('type') == '2' ? 'selected' : '' }}>Media</option>
            <option value="3" {{ request('type') == '3' ? 'selected' : '' }}>Premium</option>
        </select>
        <select name="status">
            <option value="">Selecciona Estado</option>
            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Activo</option>
            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactivo</option>
        </select>
        <input type="date" name="start_date" placeholder="Desde Fecha" value="{{ request('start_date') }}">
        <input type="number" name="hours" placeholder="Horas Mínimas" value="{{ request('hours') }}">
        <button type="submit">Buscar</button>
    </form>
    <table class="table">
        <thead>
            <tr>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Usuario</th>
                <th>Tipo</th>
                <th>Horas </th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($promotions as $promotion)
                <tr>
                    <td>{{ $promotion->startday }}</td>
                    <td>{{ $promotion->end_date }}</td>
                    <td>{{ $promotion->user->username }}</td>
                    <td>{{ $promotion->id_type == 1 ? 'basico' : ($promotion->id_type == 2 ? 'medium' : 'premium' )}}</td>
                    <td>{{ $promotion->status}}</td>
                    <td>{{ $promotion->active == 1 ? 'iniciado' : ($promotion->active == 2 ? 'pausado' :($promotion->active == 3 ? 'finalizado' : 'inactivo' )) }}</td>
                    <td>
                        <div style="display: flex;">
                        @if ($promotion->active == 2 ||$promotion->active == 0)
                            <form action="{{ route('admin.startPromotion', $promotion->id) }}" method="post">
                                @csrf
                                <button type="submit" class="btn btn-success">Iniciar</button>
                            </form>
                        @endif
                        @if ($promotion->active == 1)
                            <form action="{{ route('admin.pausePromotion', $promotion->id) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-warning">Pausar</button>
                        </form>
                        
                        
                        <form action="{{ route('admin.endPromotion', $promotion->id) }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-danger">Terminar</button>
                        </form>
                        @endif
                    </div>
                        
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection