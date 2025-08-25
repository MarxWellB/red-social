@extends('layouts.app')
@section('titulo')
 
@endsection
@section('contenido')
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.js"></script>



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
    .blur-effect {
    filter: blur(0.5px);
}

</style>

@php
    $postCount = 0;
    $indice=0;
    $totalPromociones = count($promotedUsers);
    $totalinitial = count($initial);
@endphp
<style>
    .responsive-container {
        margin: auto;
        padding: 5px;
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;
        position: relative; 
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
@media (min-width: 1275px) {
    .publicidad{
        left: 0.8%; 
    }
    }
 .publicidad{
        row-gap: 5px;
    }

@media (max-width: 1014px) {
    .responsive-container {
        justify-content: center;
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

@media (min-width: 1241px)  {
    .xy,.ydos{
        display: none;
    }
    .xdos{
        display: block;
    }
}
@media (min-width: 787px) and  (max-width: 1240px) {
    .xdos,.ydos{
        display: none;
    }
    .xy{
        display: block;
    }
}

@media (min-width: 505px) and  (max-width: 786px) {
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

</style>
    <div class="responsive-container publicidad grid-initial" style="display: flex;flex-wrap:wrap;margin:0; padding:0;">  
                @foreach ($initial as $item)
                                <a class=" grid-link user" href="{{route('posts.index', ['user'=>$item])}}">
                                    <div  class="grid-itemsinitial" width="250">
                                        <div class="card bg-dark text-white">
                                            <img class="rounded-3" src="{{$item->profile_cach>0? asset('img/P' . $item->username . '.png'):$item->prof}}" style="max-height: 250px;object-fit:cover;" width="250" height="@php $im=getimagesize($item->prof); echo (250/$im[0])*$im[1]; @endphp" alt="imagen del post de $user->username}}">
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
        <div class="responsive-container grid-containe" style="padding:0;">            
            

            @foreach($all as $al)
            @php
                try {
                    if($conx->where('onlinestore_id',$al->onlinestore->id)->where('user_id',$al->user_id)->first()->enlace){
                        $tienda=true;
                    }
                } catch (\Throwable $th) {
                    $tienda=false;
                }   
                $postCount++;
                $random=rand(3, 6);
            @endphp
            


            @if (imageExists($al->url) && $tienda && !($postCount%$random==0))
                @php
                    $imagenAleatoria = $imagenes[array_rand($imagenes)];
                    $posicionTop = rand(0, 80);
                    $posicionLeft = rand(0, 80);
                @endphp
            <a href="{{route('posts.show',['post'=>$al,'user'=>$al->user])}}">
                <div  class="grid-items" >
                    <div class="card bg-dark text-white">
                        <img loading="lazy" class="rounded-3 blur-effect" src="{{$al->cache_active>0? asset('img/' . $al->id . '.png'):$al->url;}} " 
                        width="250" height="@php if($al->cache_active>0 && $al->width>0 && $al->image_height>0){$im=$al->width>0?$al->width:250; echo 250/($im)*$al->image_height;} else{$im=getimagesize($al->url); echo (250/$im[0])*$im[1]; } @endphp"
                        alt="imagen del post de "{{$al->user->username}}>
                        <div class="card-img-overlay cs" style="pointer-events: none;bottom:-1px;">
                            <div class="crds">
                                @php
                                    app('App\Http\Controllers\PostController')->descargarcache($al);
                                @endphp 
                            </div>
                        </div>
                    </div>                  
                    <div style="display: flex;">
                        <a href="{{route('posts.index', ['user'=>$al->user])}}" style="position: absolute;margin-top:-1.7rem;text-decoration:none;" class="card-title ns">
                            {{$al->user->username}}
                        </a>
                    <a href="{{$conx->where('onlinestore_id',$al->onlinestore->id)->where('user_id',$al->user_id)->first()->enlace}}" style="position:absolute;margin-top: -10%;right:-2%;" target="_blank">
                        <img src="{{ asset('img/'.$al->onlinestore->logourl )}}" alt="{{ $al->nombre }}" width="25" height="25" style="border-radius:2%;margin-right: 0.3rem; margin-top:-0.5rem;">
                        
                    </a>
                    </div>
                </div>
            </a>  
                
            @else
                @if ($indice<$totalPromociones )
                    <a class="grid-link user" href="{{route('posts.index', ['user'=>$promotedUsers[$indice]])}}">
                <div  class="grid-items" width="250">
                    <div class="card bg-dark text-white">
                        <img class="rounded-3" src="{{$promotedUsers[$indice]->profile_cach>0?asset('img/P' . $promotedUsers[$indice]->username . '.png'):$promotedUsers[$indice]->prof}}" width="250" height="@php $im=getimagesize($promotedUsers[$indice]->prof); echo (250/$im[0])*$im[1]; @endphp" alt="imagen del post de $user->username}}">
                        <div class="card-img-overlay cs" style="pointer-events: none;">
                            <div class="crds">
                                <a style="position: absolute;margin-top:-1.7rem;text-decoration:none;" class="card-title ns">{{$promotedUsers[$indice]->username}}</a>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </a>  
                @endif
            
                @php
                    $indice++;
                @endphp
            @endif
            @endforeach
        </div>
    </div>
   
<script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.js"></script>
<script>
     
    
    var elem=document.querySelector(".grid-containe");
    var msnry=new Masonry(elem, {
        itemSelector:".grid-items",
        columnWidth: 250,
        gutter: 5,
        isFitWidth:true
    });
</script>
@endsection