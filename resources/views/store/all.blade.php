@extends('layouts.app')
@section('titulo')
 - Plataforms
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

<style>
    .tags-wrapperr {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 10px; 
    }

    .cardr {
        width: 250px; 
        overflow: hidden; 
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2); 
    }

    .card-img-overla {
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        
        background: rgba(0, 0, 0, 0.5); 
    }

    .card h2, .card span {
        text-align: center;
        color: white;
        -webkit-text-stroke: 0.1px black;
        text-shadow: 1px 1px 14px rgba(0, 0, 0, 0.5);
    }

    @media (max-width: 600px) {
        .card {
            width: 100%; 
        }
    }
</style>
<style>
    .responsive-container {
        margin: auto;
        padding: 5px;
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-start; 
    }

@media (max-width: 768px) {
    .responsive-container {
        justify-content: center;
    }
}
    @media (min-width: 770px) {
        .responsive-container {
            justify-content: flex-start;
        }    
    }
@media (min-width: 1278px) {
    .responsive-container {
        justify-content: flex-start;
        margin-left: 0.8%;
    }

  
}
@media (min-width: 1014px) {
.responsive-container {
    margin: 0;
    justify-content: flex-start;
}

}
@media (min-width: 1241px)  {
.xy,.ydos{
    display: none;
}
.xdos{
    display: block;
}
}
@media (min-width: 786px) and  (max-width: 1240px) {
.xdos,.ydos{
    display: none;
}
.xy{
    display: block;
}
}

@media (min-width: 505px) and  (max-width: 785px) {
.xdos{
    display: block;
}
.ydos,.xy{
    display: none;
}
}

@media screen and  (max-width: 504px) {
.xdos{
    display: none;
}
.ydos,.xy{
    display: block;
}
}
@media  (min-width: 1224px) {
    .publicidad{
    left: 0.8rem;
}
}
@media (min-width: 1015px) and  (max-width: 1032px) {
    .responsive-container {
        justify-content: flex-start;
        position: relative;
    }
    .publicidad{
        left:0.5rem;
    }
}
@media (min-width: 1033px) and  (max-width: 1056px) {
    .responsive-container {
        justify-content: flex-start;
        position: relative;
    }
    .publicidad{
        left:1rem;
    }
}
@media (min-width: 1057px) and  (max-width: 1079px) {
    .responsive-container {
        justify-content: flex-start;
        position: relative;
    }
    .publicidad{
        left:1.5rem;
    }
}
@media (min-width: 1152px) and  (max-width: 1231px) {
    .responsive-container {
        justify-content: flex-start;
        position: relative; 
        max-width: 83%;
    }

    .publicidad{
        left:6.5rem;
    }
}
@media (min-width: 1232px) and  (max-width: 1255px) {
    .responsive-container {
        justify-content: flex-start;
        position: relative; 
        max-width: 83%;
    }

    .publicidad{
        left:7.2rem;
    }
}
@media (min-width: 1256px) and  (max-width: 1269px) {
    .responsive-container {
        justify-content: flex-start;
        position: relative; 
        max-width: 83%;
    }

    .publicidad{
        left:8rem;
    }
}
@media (min-width: 1109px) and  (max-width: 1137px) {
    .responsive-container {
        justify-content: flex-start;
        position: relative; 
    }
    .publicidad{
        left:3.4rem;
    }
}
@media (min-width: 1138px) and  (max-width: 1151px) {
    .responsive-container {
        justify-content: flex-start;
        position: relative; 
    }
    .publicidad{
        left:4.2rem;
    }
}
@media (min-width: 1080px) and  (max-width: 1108px) {
    .responsive-container {
        justify-content: flex-start;
        position: relative; 
        max-width: 95%;
    }
    .publicidad{
        left:2.4rem;
    }
}

</style>
<div class="responsive-container publicidad grid-initial" style="display: flex;flex-wrap:wrap;">  
    @foreach ($initial as $item)
                    <a class=" grid-link user" href="{{route('posts.index', ['user'=>$item])}}">
                        <div  class="grid-itemsinitial" width="250">
                            <div class="card bg-dark text-white">
                                <img class="rounded-3" src="{{$item->profile_cach>0?asset('img/P'.$item->username.'.png'):$item->prof}}" width="250" style="max-height: 250px;object-fit:cover;" height="@php $im=getimagesize($item->prof); echo (250/$im[0])*$im[1]; @endphp" alt="imagen del post de $user->username}}">
                                <div class="card-img-overlay cs" style="pointer-events: none;">
                                    <div class="crds">
                                        <a style="position: absolute;margin-top:-1.7rem;text-decoration:none;" class="card-title ns">{{$item->username}}</a>                                
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>  
            @endforeach
            <div class="grid-itemsinitial ">
                <div class="xy"> 
                    <script type="text/javascript" data-cfasync="false" async src="https://poweredby.jads.co/js/jads.js"></script>
                    <ins id="1046008" data-width="250" data-height="262"></ins>
                    <script type="text/javascript" data-cfasync="false" async>(adsbyjuicy = window.adsbyjuicy || []).push({'adzone':1046008});</script>
                </div>
            </div>
            <div class="grid-itemsinitial hidedoPublicy" height="262"> 
                <div class="ydos">
                    <script type="text/javascript" data-cfasync="false" async src="https://poweredby.jads.co/js/jads.js"></script>
                    <ins id="1046009" data-width="258" data-height="528"></ins>
                    <script type="text/javascript" data-cfasync="false" async>(adsbyjuicy = window.adsbyjuicy || []).push({'adzone':1046009});</script>
                </div>
            </div>
            <div  class=" grid-itemsinitial" >
                <div class="xdos" height="262">
                    <script type="text/javascript" data-cfasync="false" async src="https://poweredby.jads.co/js/jads.js"></script>
                    <ins id="1046010" data-width="516" data-height="270"></ins>
                    <script type="text/javascript" data-cfasync="false" async>(adsbyjuicy = window.adsbyjuicy || []).push({'adzone':1046010});</script>
                </div> 
            </div>
</div>
<div >    

    <div class="grid-contain tt" style="margin:0 auto;">
        <div class="tag-container" style="display: flex; flex-wrap: wrap;">
        @foreach ($os as $tag)
        <a class="grid-items" href="{{ route('store.show', $tag->nombre) }}">
            <div class="" >
                <img style="object-fit: cover;" width="250" height="140" class="rounded-3 myImage" src="@php if(imageExists($tag->fdo)){
                                        echo  $tag->fdo;
                                    }else{
                                        echo "https://picsum.photos/1024/450.jpg";
                                    } @endphp" alt="">

                <div class="card-img-overla" style="pointer-events: none;">
                    <div class="crdr">
                    </div>
                    <div style="position: absolute; top: 0; left: 0; width: 250px; height: 100%; background-color: rgba(0, 0, 0, 0.63);"></div>
                    <h4 style="position: absolute;webkit-text-stroke: 0.1px black;
                text-stroke: 0.1px black;
                color: white;text-shadow: 1px 1px 14px rgba(0, 0, 0, 10); font-weight: bold;margin-left:0.2rem;">{{ ucfirst($tag->nombre) }} </h4>
             
                </div>
            </div>
        </a>
        @endforeach
    </div>
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
            
                var elem=document.querySelector(".grid-initial");
                var msnry=new Masonry(elem, {
                    itemSelector:".grid-itemsinitial",
                    columnWidth: 250,
                    gutter: 5,
                    isFitWidth:true
                });
            </script>
@endsection