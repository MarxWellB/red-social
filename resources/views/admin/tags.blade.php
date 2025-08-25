@extends('layouts.app')

@section('contenido')
<div class="container">
    <p>
        
        <a href="">regresar</a> 
     </p>
    <div class="row">
        <div class="col-sm-6">
            <h3>Tags buenos</h3>
            <ul class="list-group">
                @foreach($goodPosts as $post)
                    <li class="list-group-item" style="display: flex;gap:1rem;">
                        <h4 style="width: 6rem;">{{ $post->name }}</h4>
                        <a href=" route('admin.posts.edit', $post->id) " class="btn btn-warning">Editar</a>
                        <form action=" route('admin.posts.destroy', $post->id) " method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="col-sm-6">
            <h3>Tags denunciados</h3>
            <ul class="list-group">
                @foreach($reportedPosts as $post)
                <li class="list-group-item" style="display: flex;gap:1rem;">
                    <h4 style="width: 6rem;">{{ $post->name }}</h4>
                    <form action="{{ route('admin.tags.enable', $post) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-warning">Habilitar</button>
                    </form>
                        <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

@endsection