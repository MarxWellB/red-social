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
  <div class="grid-contain" style="margin: 0 auto">
    @if (count($posts)>0)
    @foreach($posts as $al)
        @if (imageExists($al->url))  
        <a href="{{route('posts.show',['post'=>$al,'user'=>$al->user])}}">
            <div  class="grid-items" >
                <div class="card bg-dark text-white">
                    <img class="rounded-3" src="{{$al->cache_active>0?asset('img/'.$al->id.'.png'):$al->url}}" 
                        width="250" 
                        height="@php if($al->cache_active>0 && $al->width>0 && $al->image_height>0){$im=$al->width>0?$al->width:250; echo 250/($im)*$al->image_height;} else{$im=getimagesize($al->url); echo (250/$im[0])*$im[1]; } @endphp"
                        alt="imagen del post de "{{$al->user->username}}>
                  <div class="card-img-overlay cs" style="pointer-events: none;">
                      <div class="crds">                
                      </div>
                  </div>
              </div>
              @php  
                    $conx= \App\Models\cxsturs::all();
                @endphp
              <div style="display: flex;">
                   <a href="{{route('posts.index', ['user'=>$al->user])}}" style="position: absolute;margin-top:-1.7rem;text-decoration:none;" class="card-title ns">
                  {{$al->user->username}}
              </a>
              <a href="{{$conx->where('onlinestore_id',$al->onlinestore->id)->where('user_id',$al->user_id)->first()->enlace}}" style="position:absolute;margin-top: -10%;right:-2%;" target="_blank">
                  <img src="{{ asset('img/'.$al->onlinestore->logourl )}}" alt="{{ $al->nombre }}" width="25" height="25" style="border-radius:2%;margin-right: 0.5rem;">
              </a>
              </div>                 
          </div>
      </a>               
        @endif  
    @endforeach
</div>    
@else
        <h5>Without results</h5>


@endif
</div>
<div style="display: flex; justify-content: center;">
    {{$posts->links('pagination::bootstrap-4')}}
</div>
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.js"></script>
      <script>
          var elem=document.querySelector(".grid-contain");
          var msnry=new Masonry(elem, {
              itemSelector:".grid-items",
              columnWidth:250,
              gutter: 5,
              isFitWidth:true
          });
      </script>
@endsection