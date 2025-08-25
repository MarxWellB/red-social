@extends('layouts.app')

@section('titulo')
- '{{$q}}'
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
    
    .encabez {
        display: flex; 
        flex-wrap:wrap;
        margin: 0 auto;
        margin-left: 2.5rem;
    }

    @media screen and (max-width: 500px) {
        .encabez {
            display: flex; 
            flex-wrap:wrap; 
            justify-content: center; 
            align-items: center; 
            margin: 0 auto;
        }
    }
</style>
<div style="display: flex;">
    <h2 style="margin-left: 2rem; ">
            {{$q}} {{" - ". (count($posts)+count($tags)+count($cuentas))}} &nbsp;
        </h2> 
        <h2 data-section="Search" data-value="Result">
            Results
        </h2>
</div>
        <br>
        <div class="encabez" >
            <h4 data-section="Search" data-value="Tag">
                Tags:
            </h4>
            <div >
                <div class="tag-container container" style="max-width:90%;">
                    <div class="tags-wrapper">
                        @if ($tags->count()>20)
                            <a href="{{route('search.buscarTags',$q)}}" class="tag" data-section="Search" data-value="More">More results</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
        @if (count($tags)>0)
            <div class="tag-container container" style="max-width:90%;">
                <div class="tags-wrapper">
                    @foreach ($tags as $tag)
                        @if($loop->iteration < 20)
                            <a href="{{ route('tag.show', $tag) }}" class="tag">
                                {{ $tag->name }}
                            </a>
                        @else
                            <a href="{{ route('tag.show', $tag) }}" class="tag extra-tag">
                                {{ $tag->name }}
                            </a>
                        @endif
                    @endforeach
                </div>
            </div>
        @else
            <h5 data-section="Search" data-value="Without">Without results</h5>
        @endif        
        <br>
    </div>
    <hr>
    
<div class="encabez" >
        <h4 data-section="Search" data-value="Account">
            Accounts:
        </h4>
        <div >
            <div class="tag-container container" style="max-width:90%;">
                <div class="tags-wrapper">
                    @if ($cuentas->count()>10)
                    <a href="{{route('search.buscarAccounts',$q)}}" class="tag"data-section="Search" data-value="More">More results</a>
                @endif
                </div>
            </div>
        </div>
    </div>  
    <style>
        .responsive-container {
            margin: auto;
            padding: 5px;
        }
        @media (max-width: 768px) {
            .responsive-container {
                justify-content: center;
            }
        }
        @media (min-width: 769px) {
            .responsive-container {
                justify-content: flex-start;
            }
        }
        @media (min-width: 1024px) {
            .responsive-container {
                justify-content: flex-start;
                margin-left: 0.8%;
                
            }
        }
    </style>
<div class="responsive-container encabez" style="display: flex; flex-wrap: wrap; ">
    @if (count($cuentas)>0)        
            @foreach ($cuentas as $item)
                    @if (imageExists($item->prof))
                        <a class="grid-link user" href="{{route('posts.index', ['user'=>$item])}}">
                            <div  class="grid-items" width="250">
                                <div class="card bg-dark text-white">
                                    <img class="rounded-3" src="{{$item->profilecache>0?asset('img/P' . $item->username . '.png'):$item->prof}}" width="250" style="max-height: 250px;object-fit:cover;" height="@php $im=getimagesize($item->prof); echo (250/$im[0])*$im[1]; @endphp" alt="imagen del post de $user->username}}">
                                    <div class="card-img-overlay cs" style="pointer-events: none;">
                                        <div class="crds">
                                            <a style="position: absolute;margin-top:-1.7rem;text-decoration:none;" class="card-title ns">{{$item->username}}</a>
                                                                                </div>
                                    </div>
                                </div>
                            </div>
                        </a>  
                    @endif  
                    
                @endforeach              
    @else
            <h5 data-section="Search" data-value="Without">Without results</h5>
    @endif
</div> 
    <br>
    <hr>
    <div class="encabez" >
        <h4 data-section="Search" data-value="Result">
            Posts:
        </h4>
        <div >
            <div class="tag-container container" style="max-width:90%;">
                <div class="tags-wrapper">
                    @if ($posts->count()>40)
                    <a href="{{route('search.buscarPosts',$q)}}" class="tag" data-section="Search" data-value="More">More results</a>
                @endif
                </div>
            </div>
        </div>
    </div>
    
<div class="responsive-container encabez grid-contain" style="display: flex; flex-wrap: wrap; ">
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
                      <img src="{{ asset('img/'.$al->onlinestore->logourl )}}" alt="{{ $al->nombre }}" width="25" height="25" style="border-radius:2%;margin-right: 0.5rem;margin-top:-0.5rem;">
                  </a>
                  </div>                 
              </div>
          </a>               
            @endif  
        @endforeach
    </div>    
    @else
            <h5 data-section="Search" data-value="Without">Without results</h5>

    
    @endif
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