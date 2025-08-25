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


<style>
    .opcion{
        flex-wrap: nowrap;
    }
    .foma {
width: 30rem;        
}
    @media screen and (max-width: 450px) {
        .por{
        width: 100%;
    }
        .opcion {
            flex-wrap: wrap
        }
        .form-select.tag {
display: inline-block;
width: 48.7%;     
}
    }
    @media (min-width: 339px) and (max-width: 410px) {
  
        .form-select.tag {

width: 48.5%;       
}
    }
    @media screen and (max-width: 338px) {
        .por{
        width: 100%;
    }
        .form-select.tag {
            display: inline-block; 
width:100%;      
}
    }
</style>
    <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div style="display: flex;gap:1rem;">
                <h3 data-section="Platform" data-value="Plataforma">Plataform:</h3>
                <h3> {{$onlineStore->nombre}}</h3>
            </div>
            <form action="{{ route('store.show', ['onlineStore' => $onlineStore]) }}" method="get">
                <div class="mb-3">
                    <div class="opcion" style="display: flex; align-items: center; padding: 0.5rem;">
                        <h6 for="filter" class="form-label por" style="margin-right: 1rem;" data-section="Platform" data-value="Filter">Filter by:</h6>
                        <select name="filter" id="filter" class="form-select tag foma" >
                            <option value="all"{{ request()->get('filter') == 'all' ? ' selected' : '' }} data-section="Platform" data-value="All">All</option>
                            <option value="posts"{{ request()->get('filter') == 'posts' ? ' selected' : '' }} data-section="Platform" data-value="Post">Posts</option>
                            <option value="users"{{ request()->get('filter') == 'users' ? ' selected' : '' }} data-section="Platform" data-value="Account">Accounts</option>
                        </select>
                        <select name="viewType" id="viewType" class="form-select tag foma" >
                            <option value="random"{{ request()->get('viewType') == 'random' ? ' selected' : '' }} data-section="Platform" data-value="Random">Random</option>
                            <option value="latest"{{ request()->get('viewType') == 'latest' ? ' selected' : '' }} data-section="Platform" data-value="Last">Last 40</option>
                        </select>                                
                        <button type="submit" class="tag por" data-section="Platform" data-value="Apply">Aplicar filtro</button>
                    </div>
                </div>
            </form>
          </div>
        </div>
    </div>
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
           <div class="responsive-container publicidad grid-initial" style="display: flex;flex-wrap:wrap;">  
            @foreach ($initial as $item)
                            <a class=" grid-link user" href="{{route('posts.index', ['user'=>$item])}}">
                                <div  class="grid-itemsinitial" width="250">
                                    <div class="card bg-dark text-white">
                                        <img class="rounded-3" src="{{$item->profile_cach>0?asset('img/P'.$item->username.'.png'):$item->prof}}" width="250" height="@php $im=getimagesize($item->prof); echo (250/$im[0])*$im[1]; @endphp" alt="imagen del post de $user->username}}">
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
    <div class="container-fluid">

        <div class="grid-contain responsive-container" >
            @if ($combined!=0)
        @foreach($combined as $data)
            @php
                $post=$data['data'];
            @endphp
            @if ($data['type'] === 'post')
                    @if (imageExists($post->url))
                        <a class="grid-link post" href="{{route('posts.show',['post'=>$post,'user'=>$post->user])}}">
                            <div  class="grid-items" >
                                <div class="card bg-dark text-white">
                                    <img class="rounded-3" src="{{$post->cache_active>0?asset('img/'.$post->id.'.png'):$post->url}}" 
                                    width="250" height="@php $im=getimagesize($post->url); echo (250/$im[0])*$im[1];  @endphp"
                                    alt="imagen del post de $user->username}}">
                                    <div class="card-img-overlay cs" style="pointer-events: none;">
                                        <div class="crds">
                                            
                                                
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $conx= \App\Models\cxsturs::all();
                                @endphp
                                <div style="display: flex;">
                                    <a href="{{route('posts.index', ['user'=>$post->user])}}" style="position: absolute;margin-top:-1.5rem;text-decoration:none;" class="card-title ns">
                                    {{$post->user->username}}
                                </a>
                                <a href="{{$conx->where('onlinestore_id',$post->onlinestore->id)->where('user_id',$post->user_id)->first()->enlace}}" style="position:absolute;margin-top: -10%;right:-2%;" target="_blank">
                                    <img src="{{ asset('img/'.$post->onlinestore->logourl )}}" alt="{{ $post->nombre }}" width="25" height="25" style="border-radius:2%;margin-right: 0.6rem; margin-top:-0.8rem;">
                                </a>
                                </div>
                            </div>
                        </a>  
                    @endif  
            @else
                @if ($filterType=='users' || $filterType=='all' )
                    @if (imageExists($data['data']->prof))
                    <a class="grid-link user" href="{{route('posts.index', ['user'=>$data['data']])}}">
                        <div  class="grid-items" >
                            <div class="card bg-dark text-white">
                                <img class="rounded-3" src="{{$data['data']->profil_cach>0?asset('img/P'.$data['data']->username.'.png'):$data['data']->prof}}" 
                                width="250" height="@php $im=getimagesize($data['data']->prof); echo (250/$im[0])*$im[1];  @endphp"
                                alt="imagen del post de $user->username}}">
                                <div class="card-img-overlay cs" style="pointer-events: none;">
                                    <div class="crds">
                                        <a style="position: absolute;margin-top:-1.5rem;text-decoration:none;" class="card-title ns">{{$data['data']->name}} </a>
                                            
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>  
                @endif  
                @endif
                
            @endif
            
        @endforeach
    </div>
@else
<br>
<h5 data-section="Search" data-value="Without">Without results</h5>
<br>
@endif
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