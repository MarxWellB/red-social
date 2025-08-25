@extends('layouts.app')
@section('titulo')
 
@php
    try {
        if($filtro)
        {
            echo ' - All tags in ' . strtoupper($filtro);
        }
    } catch (Exception $e) {
        echo ' - All tags';
    }
@endphp

@endsection
@section('contenido')
<div class="tag-container container" >
    <div class="tags-wrapper" style="margin:0 auto;">
    <a href="{{ route('navbar.navtag') }}" class="tag" data-section="NavTag" data-value="All" >All</a>
        @foreach ($alfa as $item)
        <a href="{{ route('navbar.navtagf', ['filtro' => $item]) }}" class="tag">{{ $item }}</a>
    @endforeach
    
    </div>
</div>
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
.tag-T {
    display: flex;
    flex-wrap: wrap;
    margin: 0 auto;
    justify-content: center; 
    align-items: center; 
}

.tag-c, .tag-l {
    -webkit-text-stroke: 0.1px black;
    text-stroke: 0.1px black;
    color: white;
    display: block;
    border-color: black;
    text-shadow: 1px 1px 14px rgba(0, 0, 0, 1);
    text-align: center;
    margin: 0;
    font-weight: bold;
}

    
  </style>
  <div class="container tt" style="margin:0 auto;">
    <div class="tag-container" style="display: flex; flex-wrap: wrap;">
        @foreach (($tags->sortBy('name')) as $tag)
            @if ($tag->level == 1)
                <a href="{{ route('tag.show', $tag->name) }}" class="card" style="border:none;">
                    <img src="@php echo imageExists($tag->fdo) ? $tag->fdo : 'https://picsum.photos/1024/450.jpg'; @endphp" alt="" class="card-img">
                    <div class="card-img-overlay">
                        <div class="crds">
                        </div>
                        <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.596);"></div>
                    <h3 style="position: absolute;max-width:220px; webkit-text-stroke: 0.1px black;
                    text-stroke: 0.1px black;
                    color: white;display: block;text-shadow: 1px 1px 14px rgba(0, 0, 0, 10); font-weight: bold;z-index:2000;">{{ $tag->name }} </h3>
                    <div style="position: absolute;margin-top:2.3rem;color:gainsboro;z-index:2000;" class="tag-T">                    
                        <span class="tag-c">{{ $tag->counter }}&nbsp;</span>
                        <span class="tag-l" data-section="NavTag" data-value="Post">Posts</span>
                    </div>
                    </div>
                </a>
            @endif
        @endforeach
    </div>
</div>
<div style="display: flex; justify-content: center;">
    {{$tags->links('pagination::bootstrap-4')}}
</div>
@php

function imageExists($url) 
{
    if($url){
        $headers = get_headers($url);
        if (strpos($headers[0], '200') !== false) {
            $image_info = getimagesize($url);
            if ($image_info !== false) {
                return true;
            }
        }
    }
    return false;
}   
@endphp
@endsection