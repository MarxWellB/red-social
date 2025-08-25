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
<div class="admin-container">
    <h1>Solicitudes de Borrado de Cuenta</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Razón</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($deletionRequests as $request)
            <tr>
                <td>{{ $request->id }}</td>
                <td>{{ $request->email }}</td>
                <td>{{ $request->reason }}</td>
                <td>{{ $request->status == 1 ? 'Revisado' : 'Pendiente' }}</td>
                <td>
                    @if($request->status == 0)
                    <form action="{{ route('admin.removerStatus', $request) }}" method="POST">
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