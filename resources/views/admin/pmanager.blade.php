@extends('layouts.app')
@section('contenido')
<style>
    .form-container {
        background-color: rgb(31, 30, 30); 
        border-radius: 8px; 
        padding: 20px; 
        box-shadow: 0 4px 8px rgba(0,0,0,0.1); 
        max-width: 500px; 
        margin: auto;
    }
  
    .form-container h3 {
        color: #ddd; 
        margin-bottom: 15px; 
    }
  
    .form-container input[type="text"],
    .form-container input[type="email"],
    .form-container textarea {
        width: 100%; 
        padding: 10px; 
        margin-bottom: 10px; 
        border: 1px solid #ddd; 
        border-radius: 4px; 
    }
    input[type="text"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
    }
    .form-container textarea {
        height: 100px; 
        resize: vertical; 
    }
    .form-container button {
        color: #ddd; 
        border: none; 
        padding: 10px 20px; 
        border-radius: 4px; 
        cursor: pointer; 
        margin-right: 10px; 
    }
    .form-container .tag {
        background-color: #6c757d; 
    }
  
    .form-container .tag:hover {
        background-color: #5a6268; 
    }
  </style>
    <div id="purchase-form" class="form-container" style=" text-align: center; margin-top: 2rem;margin-bottom:1rem;">
    <form action="{{ route('admin.promcreate') }}" method="POST">
        @csrf
        <input  type="text" name="nombre" data-place="Form" data-val="name" placeholder="Your name" required style="outline:none; background-color: #1b1b1b; color: #fff; border: none; ">

        <input type="number" id="price" name="price" placeholder="price" class="form-control" required style="outline:none; background-color: #1b1b1b; color: #fff; border: none; ">

        <input type="number" id="hours" name="hours" placeholder="hours" class="form-control" required style="outline:none; background-color: #1b1b1b; color: #fff; border: none; ">

        <input class="input @error('username') otro @enderror" data-place="Form" data-val="Username" type="text" name="username" placeholder="Nombre del usuario" required style="outline:none; background-color: #1b1b1b; color: #fff; border: none; ">
        @error('username')
                            <p class="error">{{$message}}</p>
                        @enderror
        <input type="email" name="email" data-place="Form" data-val="Email"  placeholder="Your Email" required style="outline:none; background-color: #1b1b1b; color: #fff; border: none; ">
        <input type="text" name="idDiscount" data-place="Form" data-val="Discount" placeholder="Código de Descuento (opcional)" style="outline:none; background-color: #1b1b1b; color: #fff; border: none; ">

    


        <div style="display: flex;column-gap:1rem;">
        
        <p style="margin-top: 1rem;margin-left:0.8rem;" data-section="Prom" data-value="Date">Fecha de inicio: </p> 
        <style>
        .date-input {
            outline: none;
            background-color: #1b1b1b;
            color: #fff;
            border: 1px solid #333; 
            padding: 10px;
            border-radius: 4px;
            width: 100%; 
        }
        
        .date-input::-webkit-calendar-picker-indicator {
            filter: invert(1); 
        }
        </style>

        <input type="date" id="startday" min="@php echo today(); @endphp" name="startday" class="date" placeholder="Fecha de inicio"  style="outline:none; background-color: #1b1b1b; color: #fff; border: none; " required>
    </div>
    <select class="miSelect" name="paquete" id="package-select" style="outline:none; background-color: #1b1b1b; color: #fff; border: none;" >
        <option value="basico" data-section="Prom" data-value="PBasic">Paquete Básico - $29</option>
        <option value="estandar" data-section="Prom" data-value="PStandar">Paquete Estándar - $49</option>
        <option value="premium" data-section="Prom" data-value="PPremium">Paquete Premium - $89</option>
    </select>



    <a href="" class="tag" id="paqueteEnlace" style="text-decoration: none;" data-section="Prom" data-value="ToBuy">
    Proceder a Comprar
    </a>

        <input type="text" name="nowpay" data-place="Form" data-val="Id" placeholder="Id de transacción de Nowpayments" required style="outline:none; background-color: #1b1b1b; color: #fff; border: none; ">
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            var selectElement = document.querySelector('.premium');
            var enlace = document.getElementById('paqueteEnlace');
        
            selectElement.addEventListener('click', function() {
                var seleccion = this.value;                  
                enlace.href = 'https://nowpayments.io/payment/?iid=6009457539';                      
                });
            });

        document.addEventListener('DOMContentLoaded', function() {
            var selectElement = document.querySelector('.mid');
            var enlace = document.getElementById('paqueteEnlace');
        
            selectElement.addEventListener('click', function() {
                var seleccion = this.value;
                
                        enlace.href = 'https://nowpayments.io/payment/?iid=5412699817';
                                        
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            var selectElement = document.querySelector('.basic');
            var enlace = document.getElementById('paqueteEnlace');
        
            selectElement.addEventListener('click', function() {
                var seleccion = this.value;
                
                        enlace.href = 'https://nowpayments.io/payment/?iid=4975916679';
                                    
            });
        });


        document.addEventListener('DOMContentLoaded', function() {
            var selectElement = document.getElementById('package-select');
            var enlace = document.getElementById('paqueteEnlace');
        
            selectElement.addEventListener('click', function() {
                var seleccion = this.value;
                
                switch(seleccion) {
                    case 'basico':
                        enlace.href = 'https://nowpayments.io/payment/?iid=4975916679';
                        break;
                    case 'estandar':
                        enlace.href = 'https://nowpayments.io/payment/?iid=5412699817';
                        break;
                    case 'premium':
                        enlace.href = 'https://nowpayments.io/payment/?iid=6009457539';
                        break;
                    default:
                        enlace.href = '';
                        enlace.textContent = 'Selecciona un paquete';
                }
            });
        });
        </script>
        
        <div  style="display: flex;margin-top:1rem;">
        <button style="width: 50%;" type="submit" class="tag" data-section="Prom" data-value="Send">Enviar Solicitud</button>
        <button style="width: 50%;" type="button" class="tag" onclick="document.getElementById('purchase-form').style.display='none'" data-section="Prom" data-value="Cancel">Cancelar</button>
        </div>
    </form>
    </div>

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
    {{-- Buscador --}}
    <form action="{{ route('admin.PersonalizateManagmente') }}" method="GET">
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
    

    {{-- Tabla de Promociones --}}
    <table class="table">
        <thead>
            <tr>
                <th>Inicio</th>
                <th>Fin</th>
                <th>Usuario</th>
                <th>Horas limit</th>
                <th>Horas used </th>
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
                    <td>{{ $promotion->listapromocion->time}}</td>
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

@endsection