@extends('layouts.app')

@section('titulo')
    Editar Perfil : {{auth()->user()->username}}
@endsection
@section('contenido')

<style>
        #my-form {
  max-width: 500px;
  margin: 0 auto;
  text-align: center;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 5px;
}

#my-form input[type=text],
#my-form input[type=email],
#my-form select,
#my-form textarea {
  display: block;
  width: 100%;
  margin-bottom: 20px;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 16px;
  font-family: Arial, sans-serif;
}

#my-form input[type=submit] {
  background-color: #4CAF50;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  font-size: 16px;
  font-family: Arial, sans-serif;
  cursor: pointer;
}

#my-form input[type=submit]:hover {
  background-color: #45a049;
}

</style>
<form action="{{route('perfil.store')}}" id="my-form"  method="post">
    @csrf
    <h1>Modificar información personal</h1>
    <p for="nombre">Nombre:</p>
    <input type="text" id="nombre" name="nombre" value="{{auth()->user()->name}}">

    <p for="username">Username:</p>
    <input type="text" id="username" name="username" value="{{auth()->user()->username}}">

    <p for="email">Correo electrónico:</p>
    <input type="email" id="email" name="email" value="{{auth()->user()->email}}">

    <p for="country">Country</p>
    <input type="text" id="country" name="country" value="{{auth()->user()->id_country}}">

    <p for="descripcion">Descripción:</p>
    <textarea id="descripcion" name="descripcion">{{auth()->user()->description}}</textarea>

    <p for="perfil">perfil</p>
    <input type="text" id="perfil" name="perfil" value="{{auth()->user()->prof}}">
    <p for="bio">biograph</p>
    <input type="text" id="bio" name="bio" value="{{auth()->user()->biograph}}">
		@php
          $onlinestores = \App\Models\onlinestore::all();
        @endphp
   
    <input type="submit" value="Actualizar información">
</form>



@endsection