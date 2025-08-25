@extends('layouts.app')

@section('contenido')
<div class="container">
    <div class="row">
        <div class="col-sm-4">
            <h3>Posts Denunciados</h3>
            <p>Total de Denuncias: {{ $totalPosts }}</p>
            <a href="{{ route('admin.posts') }}" class="btn btn-primary">Gestionar</a>
        </div>
        <div class="col-sm-4">
            <h3>Usuarios Denunciados</h3>
            <p>Total de Denuncias: {{ $totalUsers }}</p>
            <a href="{{ route('admin.acounts') }}" class="btn btn-primary">Gestionar</a>
        </div>
        <div class="col-sm-4">
            <h3>Tags Denunciados</h3>
            <p>Total de Denuncias: {{ $totalTags }}</p>
            <a href="{{ route('admin.tags') }}" class="btn btn-primary">Gestionar</a>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-sm-4">
            <h3>Soporte</h3>
            <p>peticiones: @php
                use App\Models\SupportRequest; echo SupportRequest::where('status',0)->count();
            @endphp </p>
            <a href="{{ route('info.supportReq') }}" class="btn btn-primary">Gestionar</a>
        </div>
        <div class="col-sm-4">
            <h3>Incluir cuentas</h3>
            <p>peticiones:  @php
                use App\Models\UserAccount; echo UserAccount::where('status',0)->count();
            @endphp </p>
            <a href="{{ route('admin.adder') }}" class="btn btn-primary">Gestionar</a>
        </div>
        <div class="col-sm-4">
            <h3>Eliminar cuentas</h3>
            <p>peticiones: @php
                use App\Models\AccountDeletionRequest; echo AccountDeletionRequest::where('status',0)->count();
            @endphp</p>
            <a href="{{ route('admin.remover') }}" class="btn btn-primary">Gestionar</a>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <h3>Promocionar cuentas</h3>
            <p>peticiones: @php
                use App\Models\PromotionRequest; echo PromotionRequest::where('status',0)->count();
            @endphp</p>
            <a href="{{ route('admin.promotion') }}" class="btn btn-primary">Gestionar</a>
        </div>
        
    
        <div class="col-sm-4">
            <h3>Promocionar cuentas</h3>
            <p>peticiones: @php
                use App\Models\Promotion; echo Promotion::where('active',0)->count();
            @endphp</p>
            <a href="{{ route('admin.promotionarr') }}" class="btn btn-primary">Gestionar</a>
        </div>
        
        <div class="col-sm-4">
            <h3>elmininar cache antiguo</h3><br>
        <form action="{{ route('posts.deleteCache') }}" method="POST">
            @csrf
            @method('DELETE')
            <button class="tag" type="submit">Eliminar Cache</button>
        </form>
        </div>
        <div class="col-sm-4">
            <h3>elmininar cache 10%</h3><br>
            <form action="{{ route('admin.deleteCache') }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="tag" type="submit">Eliminar Cache</button>
            </form>
          
    </div>

<style>
        td,th{
            color: aliceblue;
        }
    </style>
    <hr>
    <div class="tag-container container" >
        <div class="tags-wrapper input-group ad-container">

    
    <a class="tag" href="{{ route('admin.BasicManagment') }}">
        gestionar publicidad 
    </a>
    <a class="tag" href="{{ route('admin.PersonalizateManagmente')}}">
        gestionar publicidad personalizada
    </a>
    <a class="tag" href="{{ route('admin.limit')}}">
        calcular limites
    </a>
    <a class="tag" href="{{ route('store.index')}}">
        añadir tiendas
    </a>
    <a class="tag" href="{{ route('tag.index')}}">
        Gestionar tags
    </a>
    <a class="tag" href="{{ route('admin.profileCache')}}">
        descargar imagenes
    </a>
</div>
    </div>

</div>


@endsection
