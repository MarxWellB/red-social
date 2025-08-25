@extends('layouts.app')
<style>
    .admin-container {
        max-width: 800px;
        margin: auto;
        padding: 20px;

        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .admin-container h1 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;
    }

    .table {
        width: 100%;
        margin-bottom: 20px;
        border-collapse: collapse;
    }

    .table th, 
    .table td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .table th {
        background-color: #4CAF50;
        color: white;
    }

    .btn {
        padding: 6px 12px;
        color: white;
        background-color: #007bff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn:hover {
        background-color: #0056b3;
    }

    .status-pending {
        color: #ff9800;
    }

    .status-reviewed {
        color: #4CAF50;
    }
    table tr td{
        color: #ddd;
    }
</style>
@section('contenido')
<div class="admin-co">
    <h1>Solicitudes de Promoción</h1>
    <table class="table">
        <thead>
            <tr>
                <th>inicio</th>
                <th>fin</th>
                <th>Nombre</th>
                <th>usuario</th>
                <th>Email</th>
                <th>paquete</th>
                <th>nowpay</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @php
                use App\Models\User;
            @endphp
            @foreach($promotionRequests as $request)
            <tr>
                <td>{{ $request->startday }}</td>   
                <td>{{ $request->endDay }}</td>   
                <td>{{ $request->name }}</td>             
                <td>@php echo User::select('username')->where('id',$request->idUsr)->first(); @endphp</td>
                <td>{{ $request->email }}</td>
                <td>{{ $request->id_type == 1 ? 'basico' : ($request->active == 2 ? 'standar' : 'premium' )}}</td>
                <td>{{ $request->nowpay }}</td>
                
                <td>{{ $request->active == 1 ? 'vigente' : 'Pendiente' }}</td>
                <td>
                    @if($request->active == 0)
                    <form action="{{ route('admin.promocionarA', $request->id) }}" method="POST">
                        @csrf
                        @method('put')
                        <button type="submit" class="btn btn-primary">Marcar como Revisado</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection