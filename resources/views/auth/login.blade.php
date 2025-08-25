@extends('layouts.app')

@section('titulo')
  - iniciar sesion
@endsection

@section('contenido')
    <div class="row">

        <div class="col-6">
            <div class="cardbg mar-5">
                <form action="{{route('login')}}" method="POST">
                    @csrf
                    @if (session('mensaje'))
                    <p class="error">
                        {{session('mensaje')}}
                    </p>
                    @endif
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

                    <div>
                        <p>
                        <input type="checkbox" name="remember" >                        
                            Mantener sesion abierta
                        </p>
                    </div>
                    <input class="btn btn-primary input" id="password_confirmation" type="submit" value="Iniciar Sesion"/>
                    
                </form>
            </div>
        </div>

        <div class="col-6">
        </div>

    </div>
@endsection