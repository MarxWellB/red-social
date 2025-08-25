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
    <br>
    <div class="grid-containe" style="margin: 0 auto;">    
        @if ($cuentas->count())
            @foreach ($cuentas as $user)
            @if (imageExists($user->prof))
                    <a class="grid-link user" href="{{route('posts.index', ['user'=>$user])}}">
                                <div  class="grid-items" >
                                    <div class="card bg-dark text-white">
                                        <img class="rounded-3" src="{{$user->profile_cach>0?asset('img/P' . $user->username . '.png'):$user->prof}}" width="250" style="max-height: 250px;object-fit:cover;" height="@php $im=getimagesize($user->prof); echo (250/$im[0])*$im[1];  @endphp" alt="imagen del post de $user->username}}">
                                        <div class="card-img-overlay cs" style="pointer-events: none;">
                                            <div class="crds">
                                                <a style="position: absolute;margin-top:-1.7rem;text-decoration:none;" class="card-title ns">{{$user->username}}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    </a>  
                @endif   
            @endforeach
        @else
            <h2>
                no hay cuentas
            </h2>
            <br><br>
        @endif        
        
    </div>
    <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.js"></script>
<script>
    var elem=document.querySelector(".grid-containe");
    var msnry=new Masonry(elem, {
        itemSelector:".grid-items",
        columnWidth:250,
        gutter: 5,
        isFitWidth:true
    });
</script>
</div>
<div style="display: flex; justify-content: center;">
    {{$cuentas->links('pagination::bootstrap-4')}}


@endsection