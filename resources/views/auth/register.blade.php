@extends('layouts.app')

@section('titulo')
    Registro
@endsection

@section('contenido')
    <div class="row">

        <div class="col-6">
            <div class="cardbg mar-5">
                <form action="{{route('register')}}" method="POST">
                    @csrf
                    <div class="mar-5">
                        <label for="name" class="text-gray">
                            Nombre
                        </label>
                        <input class="input @error('name') otro @enderror" id="name" name="name" type="text" value="{{old('name')}}" placeholder="Tu nombre"/>
                        @error('name')
                            <p class="error">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="mar-5">
                        <label for="username" class="text-gray">
                            Username    
                        </label>
                        <input class="input @error('username') otro @enderror" id="username" name="username" value="{{old('username')}}" type="text" placeholder="Tu nombre de usuario"/>
                        @error('username')
                            <p class="error">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="mar-5">
                        <label for="email" class="text-gray">
                            Email
                        </label>
                        <input class="input @error('email') otro @enderror" id="email" name="email" type="email" value="{{old('email')}}" placeholder="Tu correo"/>
                        @error('email')
                            <p class="error">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="mar-5">
                        <label for="password" class="text-gray">
                            Password
                        </label>
                        <input class="input @error('password') otro @enderror" id="password" name="password" type="password" value="{{old('password')}}" placeholder="Password de registro"/>
                        @error('password')
                            <p class="error">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="mar-5">
                        <label for="password_confirmation" class="text-gray">
                            Repetir password
                        </label>
                        <input class="input" id="password_confirmation" name="password_confirmation" type="password" placeholder="Repetir password"/>
                    </div>
                    <!-- ver el id del boton-->
                    <input class="btn btn-primary input" id="password_confirmation" type="submit" value="Crear cuenta"/>
                    
                </form>
            </div>
        </div>

        <div class="col-6">
            image here
        </div>

    </div>
@endsection