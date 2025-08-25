@extends('layouts.app')
@section('titulo')
   - {{$user->username}}
@endsection
@section('contenido')
<div class="container">
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
    
<div class="row border rounded border-white border-success border-2 border-opacity-10 marg" >
   
    <div class="col-auto col-sm-6 midline">
    <div class="vr d-none d-sm-block vline"></div>
        <div class="prof">
            <div >
                <img class="rounded-2 bg-size"  src="
                @php
                    if(imageExists($user->biograph)){
                      echo  $user->biograph;
                    }else{
                       echo "https://picsum.photos/1024/550.jpg";
                    }

                @endphp
                
                " style="max-height: 250px;object-fit:cover;"> 
            </div>

           
            <div class="border pf-circle" style="background-image: url(
                @php

                    if($user->profile_cach>0){
                        echo asset('img/P' . $user->username . '.png');
                    }
                    else if(imageExists($user->prof)){
                        echo  $user->prof;
                    }else{
                        echo "https://picsum.photos/450/450.jpg";
                    }

                @endphp
                
                );"></div>
            
        </div>
        <div class="info-usr">
            <div class="grid">
                <div class="icons">                        
                    <h5>
                       {{$user->name}} 
                    </h5>                     
                    <h6>
                        &commat;{{$user->username}} 
                    </h6>
                    <div style="display: flex; flex-wrap: wrap;justify-content: flex-start;margin:0;padding-bottom:0;">
                         <p>
                        {{$user->id_country}}
                        </p>          
                        @auth
                            @if ($user->id===auth()->user()->id)
                            <div class="tag-container container" >
                                <div class="tags-wrapper input-group ad-container">
                                <a href="{{route('perfil.index')}}" class="tag">
                                informacion de perfil
                                </a>
                                <a href="{{route('store.indexstore')}}" class="tag">
                                    añadir tiendas
                                    </a>
                                </div>
                            </div>
                            @endif      
                        @endauth  
                    </div>
                    <div style="margin-bottom: 1rem; top:1rem; display:flex;gap:1rem;">
                        
                    @foreach($onlinestores as $onlinestore)
                        @if ($onlinestore!=null)
                            <a href="{{ $conx->where('onlinestore_id', $onlinestore->id)->where('user_id', $user->id)->first()->enlace}}" target="_blank">
                                <img src="{{ asset('img/'.$onlinestore->logourl )}}" alt="{{ $onlinestore->nombre }}" width="25" height="25" >
                            </a>
                        @endif
                    @endforeach
                    </div>
                </div>
                <div style="display: flex;justify-content:flex-end;gap: 1rem;margin-right:1rem;margin-top:1rem;">
                    
                    <a style="color: rgb(143, 143, 151);z-index:2000;">
                        <button id="btn-denuncia" class="tag reportar" data-section="Report" data-value="Report">Report</button>
                            <div id="denuncia-modal" class="modal">
                            <div class="modal-content">
                              <span class="close">&times;</span>
                              <h2 style="margin: 0 auto;" data-section="Report" data-value="dContent">Report Content</h2>
                              <form action="{{ route("denuncia.user", $user) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row" style="display: flex;">
                                  <div class="col" style="min-width:200px">
                                    <label for="motivo" data-section="Report" data-value="Reason">Reasons:</label><br>
                                            <input type="checkbox" id="motivo1" name="opciones[]" value="spam">
                                            <label for="motivo1"data-section="Report" data-value="Spam">Spam</label><br>
                                            <input type="checkbox" id="motivo2" name="opciones[]" value="acoso">
                                            <label for="motivo2" data-section="Report" data-value="Harassment">Harassment</label><br>
                                            <input type="checkbox" id="motivo3" name="opciones[]" value="contenido_ofensivo">
                                            <label for="motivo3" data-section="Report" data-value="Offensive">Offensive Content</label><br>
                                            <input type="checkbox" id="motivo4" name="opciones[]" value="contenido_inapropiado">
                                            <label for="motivo4" data-section="Report" data-value="Inapropiated">Inappropriate Content</label><br>
                                            <input type="checkbox" id="motivo5" name="opciones[]" value="violacion_de_derechos">
                                            <label for="motivo5" data-section="Report" data-value="Copy">Rights Violation</label><br>
                                            <input type="checkbox" id="motivo6" name="opciones[]" value="otras_razones">
                                            <label for="motivo6" data-section="Report" data-value="Another">Other Reasons</label><br>
                                        </div>
                                        <div class="col" style="min-width:200px">
                                        <label for="email" data-section="Report" data-value="Email">Email:</label><br>
                                        <input type="email" id="email" name="email" class="mwith"><br>
                                        <br>
                                        <label for="detalles" data-section="Report" data-value="Details">Details:</label><br>
                                        <textarea id="detalles" name="detalles" class="mwith"></textarea><br>
                                        <br>
                                        <button type="submit" class="mwith tag" data-section="Report" data-value="Send">Send</button>
                                    </div>
                                </div>
                              </form>
                            </div>
                          </div>
    
                        <script>
                            var btnDenuncia = document.getElementById("btn-denuncia");
                            var modal = document.getElementById("denuncia-modal");
                            var span = document.getElementsByClassName("close")[0];
                            btnDenuncia.onclick = function() {
                              modal.style.display = "block";
                            }
                            span.onclick = function() {
                              modal.style.display = "none";
                            }
                            window.onclick = function(event) {
                              if (event.target == modal) {
                                modal.style.display = "none";
                              }
                            }
    
                        </script>                         
                      </a>
                    
                </div>                                         
            </div>
        


        <div class="collapse" id="sm">
            <p data-section="Dashboard" data-value="Description">Description: </p> <p>
                {{$user->description}}</p>
            
          </div>
        <div class="centrar">
            <hr>
            <button class="buttonsm acordeonb-color" id="toggleBtn" type="button" 
        data-bs-toggle="collapse" data-bs-target="#sm" 
        aria-expanded="false" aria-controls="collapseWidthExample"
        data-section="Toggle" data-value="more">See more</button>

                         
        </div>
    </div>
    <script>
        var toggleBtn = document.getElementById('toggleBtn');
        toggleBtn.addEventListener('click', function() {
    const userLanguage = localStorage.getItem('userLanguage') || 'en';
    const isMore = toggleBtn.dataset.value === 'more';
    toggleBtn.dataset.value = isMore ? 'less' : 'more';
    changeLanguage(userLanguage);
});
    </script>
    </div>
    <div class="col-auto col-sm-6" style="height: 100%;">
        
        
        <style>
            .tag {
                display: none; 
            }
        
            @media (max-width: 600px) {
                .tag:nth-child(-n+5) {
                    display: inline-block;
                }
            }
            @media (min-width: 601px) and (max-width: 994px) {
                .tag:nth-child(-n+18) {
                    display: inline-block;
                }
            }
            @media (min-width: 995px) {
                .tag:nth-child(-n+28) {
                    display: inline-block;
                }
            }
        
            .show-all .tag {
                display: inline-block; 
            }
        </style>
        
        <div id="tags-container" style="display: flex; flex-wrap: wrap; max-width: 600px; justify-content: flex-start; margin: 0 auto; margin-top: 1rem;">
            @foreach ($tags->sortBy('name') as $tag)
                <a href="{{ route('tag.show', $tag) }}" class="tag">{{ $tag->name }}</a>
            @endforeach
            <button id="toggle-tags" class="toggle-button tag tago" onclick="toggleTags()">Ver más</button>
        </div>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const container = document.getElementById('tags-container');
                const tags = container.getElementsByClassName('tag');
                const toggleButton = document.getElementById('toggle-tags');
                let maxTagsToShowButton;
                function checkWindowSize() {
                    let screenWidth = window.innerWidth;
                    if (screenWidth <= 600) {
                        maxTagsToShowButton = 5;
                    } else if (screenWidth <= 1024) {
                        maxTagsToShowButton = 18;
                    } else {
                        maxTagsToShowButton = 28;
                    }
                    if (tags.length <= maxTagsToShowButton) {
                        toggleButton.style.display = 'none';
                    } else {
                        toggleButton.style.display = 'block';
                    }
                }
        
                checkWindowSize();
                window.addEventListener('resize', checkWindowSize);
        
                window.toggleTags = function() {
                    if (container.classList.contains('show-all')) {
                        container.classList.remove('show-all');
                        toggleButton.textContent = 'Ver más';
                    } else {
                        container.classList.add('show-all');
                        toggleButton.textContent = 'Ver menos';
                    }
                }
            });
        </script>
        

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
    @media (min-width: 1400px) {
        .responsive-container {
            justify-content: flex-start;
            margin-left: -4px;
            
        }
    }
</style>
@if($posts->count())   
        <div class="responsive-container grid-containe" >
            @foreach($posts as $post)
                @if (imageExists($post->url))
                    <a href="{{route('posts.show',['post'=>$post,'user'=>$user])}}">
                        <div  class="grid-items" >
                            <div class="card bg-dark text-white" >
                                <img class="rounded-3 myImage" src="{{$post->cache_active>0? asset('img/' . $post->id . '.png'):$post->url}}" 
                                width="250" 
                                height="@php if($post->cache_active>0 && $post->width>0 && $post->image_height>0){$im=$post->width>0?$post->width:250; echo 250/($im)*$post->image_height;} else{$im=getimagesize($post->url); echo (250/$im[0])*$im[1]; } @endphp" 
                                alt="imagen del post de "{{$user->username}}>
                            </div>
                        </div>
                    </a>
                @endif
                @php
                    app('App\Http\Controllers\PostController')->descargarcache($post);
                @endphp                
            @endforeach
        </div>
        <div >
            {{$posts->links('pagination::bootstrap-5') }}
        </div>
            
@else
    <p class="text-center">Without results</p>
@endif



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