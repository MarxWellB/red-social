@extends('layouts.app')

@section('contenido')
<div class="container">
    <p>        
        <a href="">regresar</a> 
    </p>
    
    <div class="row">
        <div class="col-sm-6">
            <h3>Posts buenos</h3>
            <ul class="list-group">
                @foreach($goodPosts as $post)
                <li class="list-group-item" style="display: flex;gap:1rem;">
                        <p style="width: 12rem;">{{ $post->titulo}}</p>
                        <a href="{ route('admin.posts.edit', $post->id) }}" class="btn btn-warning">desahilitar</a>
                        <form action="{ route('admin.posts.destroy', $post->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                        
                        <a href="{ route('admin.posts.edit', $post->id) }}" class="btn btn-warning">ver contenido</a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="col-sm-6">
            <h3>Posts denunciados</h3>
            <ul class="list-group">
                @foreach($reportedPosts as $post)
                    <li class="list-group-item">
                        <li class="list-group-item" style="display: flex;gap:1rem;">
                        <p style="width: 12rem;">{{ $post->titulo }}</p>
                        <form action="{{ route('admin.posts.enable', $post) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-warning">Habilitar</button>
                        </form>
                        <form action="{{route('posts.destroy',$post)}}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" value="Eliminar" class="btn btn-danger">Eliminar</button>
                        </form>
                        
                        <a href="{{ route('admin.seeposts', $post->id) }}" class="btn btn-warning">ver contenido</a>
                        <a style="color: rgb(143, 143, 151);">
                            <button id="hola" class="btn btn-warning">detalle</button>
                                <div id="denuncia-modal" class="modal">
                                <div class="modal-content">
                                    <span class="close">&times;</span>
                                    <h2 style="margin: 0 auto;">Denunciar contenido {{$denuncia}}</h2>
                                    @foreach ($denuncia as $item)
                                        @if ($item->tipo_elemento_denunciado === $post->id)
                                            id: {{$item->id_elemento_denunciado}}<br><br>
                                            correo: {{$item->correo_que_denuncia}}<br><br>
                                            detalles: {{$item->detalles}}<br><br> razones:<br>
                                            @foreach (str_split($item->motivacion) as $itm)
                                                @if (isset($letras[$itm]))
                                                    {{$letras[$itm]}}<br>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                </div>
                                </div>
        
                            <script>
                                var btnDenuncia = document.getElementById("hola");
        
                                var modal = document.getElementById("denuncia-modal");
                                var span = document.getElementsByClassName("close")[0];
        
                                btnDenuncia.onclick = function() {
                                  modal.style.display = "block";
                                }
        
                                span.onclick = function() {
                                  modal.style.display = "none";
                                }
        
                                window.onclick = function(event) {
                                  if (event.target == modal) {
                                    modal.style.display = "none";
                                  }
                                }
        
                            </script>                         
                          </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
