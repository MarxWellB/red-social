@extends('layouts.app')
@section('titulo')
 @php
try {
    if($filtro)
    {
        echo ' - All Models in ' . strtoupper($filtro);
        
    }
} catch (Exception $e) {
    echo ' - All Models';
}
@endphp
@endsection
@section('contenido')
@php
function get_http_response_code($url) {
   $headers = get_headers($url);
   return substr($headers[0], 9, 3);
}

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

   @endphp
   <div class="tag-container container" >
    <div class="tags-wrapper" style="margin:0 auto;">
    <a href="{{ route('perfil.show') }}" class="tag" data-section="NavTag" data-value="All">All</a>
        @foreach ($alfa as $item)
        <a href="{{ route('perfil.showf', ['filtro' => $item]) }}" class="tag">{{ $item }}</a>
    @endforeach
    
    </div>
</div>
<br>
    <style>
       .responsive-container {
            margin: auto;
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
            margin-left: 0.1%;
        }
    
      
    }

    
    @media (min-width: 1014px)  {
        .responsive-container{
            justify-content: flex-start;
        }
        .publicidad{
            justify-content: start;
        }
}
/************************/
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
        left:0.5rem;margin:0
    }
}
@media (min-width: 1033px) and  (max-width: 1056px) {
    .responsive-container {
        justify-content: flex-start;
        position: relative;
    }
    .publicidad{
        left:1rem;margin:0
    }
}
@media (min-width: 1057px) and  (max-width: 1079px) {
    .responsive-container {
        justify-content: flex-start;
        position: relative;
    }
    .publicidad{
        left:1.4rem;margin:0
    }
}
@media (min-width: 1152px) and  (max-width: 1231px) {
    .responsive-container {
        justify-content: flex-start;
        position: relative; 
        max-width: 83%;
    }

    .publicidad{
        left:6.2rem;margin:0
    }
}
@media (min-width: 1232px) and  (max-width: 1255px) {
    .responsive-container {
        justify-content: flex-start;
        position: relative; 
        max-width: 83%;
    }

    .publicidad{
        left:7.1rem;margin:0
    }
}
@media (min-width: 1256px) and  (max-width: 1269px) {
    .responsive-container {
        justify-content: flex-start;
        position: relative; 
        max-width: 83%;
    }

    .publicidad{
        left:7.9rem;margin:0
    }
}
@media (min-width: 1109px) and  (max-width: 1137px) {
    .responsive-container {
        justify-content: flex-start;
        position: relative; 
    }
    .publicidad{
        left:3.3rem;margin:0
    }
}
@media (min-width: 1138px) and  (max-width: 1151px) {
    .responsive-container {
        justify-content: flex-start;
        position: relative; 
    }
    .publicidad{
        left:4.1rem;margin:0
    }
}
@media (min-width: 1080px) and  (max-width: 1108px) {
    .responsive-container {
        justify-content: flex-start;
        position: relative; 
        max-width: 95%;
    }
    .publicidad{
        left:2.3rem;
        margin:0;
    }
}

/***************************/
@media (min-width: 1241px)  {
    .xy,.ydos{
        display: none;
    }
    .xdos{
        display: block;
    }
}

@media (min-width: 787px) and  (max-width: 1280px) {
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
          
<div >    
    
    <div class="responsive-container grid-containe" >    
        @if ($users->count())
            @foreach ($users as $user)
            @if (imageExists($user->prof))
                    <a class="grid-link user" href="{{route('posts.index', ['user'=>$user])}}">
                        <div  class="grid-items" >
                            <div class="card bg-dark text-white">
                                <img class="rounded-3" src="{{$user->profile_cach>0?asset('img/P'.$user->username.'.png'):$user->prof}}" width="250" height="@php $im=getimagesize($user->prof); echo (250/$im[0])*$im[1];  @endphp" style="max-height: 250px;object-fit:cover;" alt="imagen del post de $user->username}}">
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
            <h2 data-section="Search" data-value="Without">
                Without results
            </h2>
            <br><br>
        @endif        
        
   
    </div>
    <div style="display: flex; justify-content: center;">
        {{$users->links('pagination::bootstrap-4')}}
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
    var elem=document.querySelector(".grid-initial");
    var msnry=new Masonry(elem, {
        itemSelector:".grid-itemsinitial",
        columnWidth: 250,
        gutter: 5,
        isFitWidth:true
    });
</script>
@endsection