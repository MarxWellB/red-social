@extends('layouts.app')

@section('titulo')
    Befans - crear publicacion
@endsection

@section('contenido')

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
@endpush

    <div class="row">
        <div class="col-6">
            <form action="{{route('imagenes.store')}}" id="dropzone" class="dropzone" >
                @csrf
            </form>
        </div>
        <div class="col-6">
                  <form action="{{route('posts.store')}}" method="POST" >
                    @csrf
                    <div class="mar-5">
                        <label for="titulo" class="text-gray" >
                            Titulo
                        </label>
                        <input class="input @error('titulo') otro @enderror" id="titulo" name="titulo" type="text" value="{{old('titulo')}}" placeholder="Titulo"/>
                        @error('titulo')
                            <p class="error">{{$message}}</p>   
                        @enderror
                    </div>
                    <div class="mar-5">
                        <label for="url" class="text-gray" >
                            Url
                        </label>
                        <input class="input @error('url') otro @enderror" id="url" name="url" type="text" value="{{old('url')}}" placeholder="Inserte Url de la imagen"/>
                        @error('url')
                            <p class="error">{{$message}}</p>
                        @enderror
                    </div>
                
                    <div class="conta">
                        <div class="tconta">
                            <input name='tags' type="text">
                        </div>
                    </div>
                    <div id="redes-sociales">
                      <div class="red-social">
                        <select id="red" name="red">
                          @foreach($onlinestores as $onlinestore)
                            @if ($onlinestore!=null)
                                 <option value="{{ $onlinestore->id }}" style="color:#141414;">{{ $onlinestore->nombre }}</option>
                            @endif
                          @endforeach
                        </select>
                        </div>
                     </div>
                    <input class="btn btn-primary input" type="submit" value="Crear Post"/>
                </form>
<style>
    @import url('https://fonts.googleapis.com/icon?family=Material+Icons');
.conta {
  width: 60%;
  margin: 40px;
  color: #fffefe;
}
.tconta {
  border:2px solid #ccc;
  display: flex;
}
.tconta .tg {
  padding:5px;
  cursor: default;
  border: 1px solid #ccc;
  background: rgb(70, 70, 70);
  border-radius: 3px;
  margin: 5px;
  display: flex;
  align-items: center;
}
.tg span {
  font-size: 16px;
  margin-left: 5px;
}
.tconta input {
  flex: 1;
  font-size:16px;
  padding: 5px; 
  outline: none;
  border: 0;
}
</style>
        </div>
    </div>
    
@endsection