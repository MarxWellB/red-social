@extends('layouts.app')
@section('titulo')
 
@endsection
@section('contenido')
@php
if (!function_exists('get_http_response_code')) {
    function get_http_response_code($url) {
    $headers = get_headers($url);
    return substr($headers[0], 9, 3);
}
}
if (!function_exists('imageExists')) {
    function imageExists($url) { 
    if ($url>0) {
        $headers = get_headers($url);
        if (strpos($headers[0], '200') !== false) {
            try {
                $image_info = getimagesize($url);
                if ($image_info !== false) {
                    return true;
                }
            } catch (Exception $e) {
                return false;
            }
        }
    }
    return false;
}
}
@endphp
<br>
<style>
    
    .card-img {
    width: 100%; 
    height: 160px; 
    object-fit: cover; 
    
}
.card {
    margin-bottom: 0.2rem; 
}

@media (max-width: 600px) {
    .card {
        width: 100%; 
    }
    .card-img {
        height: 150px; 
    }
}

@media (min-width: 601px) {
    .card {
        width: 250px; 
    }
    .tt{
        position: relative;
    }
}

@media (min-width: 769px) {
    .card {
        width: 220px; 
    }
    .tt{
        left: 0.5rem;
        position: relative;
    }
}
@media (min-width: 1024px) {
    .card {
        width: 300px; 
    }
    .tt{
        left: 1.5rem;
        position: relative;
    }
}
  </style>
  <div class="container tt" style="margin:0 auto;">
    <div class="tag-container" style="display: flex; flex-wrap: wrap;">
        @foreach (($tags->sortBy('name')) as $tag)
            @if ($tag->level == 1)
                <a href="{{ route('tag.show', $tag->name) }}" class="card">
                    <img src="@php echo imageExists($tag->fdo) ? $tag->fdo : 'https://picsum.photos/1024/450.jpg'; @endphp" alt="" class="card-img">
                    <div class="card-img-overlay">
                        <div class="crds">
                        </div>
                        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.308);"></div>
                    <h2 style="-webkit-text-stroke: 0.1px black;
                    text-stroke: 0.1px black;
                    color: white;display: block;text-shadow: 1px 1px 14px rgba(0, 0, 0, 10); text-align: center; margin: 0; padding: 2px; font-weight: bold;">{{ $tag->name }} </h2>
                    <span style="-webkit-text-stroke: 0.1px black;
                    text-stroke: 0.1px black;
                    color: white; display: block;border-color:black;text-shadow: 1px 1px 14px rgba(0, 0, 0, 10);text-align: center; margin:  0; font-weight: bold;"> {{ $tag->counter }} posts</span>
                    
                    </div>
                </a>
            @endif
        @endforeach
    </div>
</div>
<div style="display: flex; justify-content: center;">
    {{$tags->links('pagination::bootstrap-4')}}
</div>

@endsection