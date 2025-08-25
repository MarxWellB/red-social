@extends('layouts.app')

@section('titulo')
  - {{$post->titulo}}
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
  <div class="container" style="margin-top: 1rem;">
    <div class="row">
      <div class=" col-md-6 col-sm-12">
        <div style="display:flex; margin:0 auto;">
          <div class="thumbnail">
                    <div class="bcolor text-white " >
                     @php $imm=getimagesize($post->url);  $imm=getimagesize($post->url); @endphp
                      <img class="rounded-3" src="{{$post->cache_active>0? asset('img/' . $post->id . '.png'):$post->url;}}"  style="@if (($imm[1])>670) 
                      width:75%; position:relative;right:-10%;
                      @else
                      width:100%
                      @endif ;margin-bottom: 0.5rem;" >    
                    </div>
                    <div style="margin-bottom: 0.2rem; display: grid;grid-template-columns: 5fr 1fr 1fr;">
                      <div style="color: rgb(143, 143, 151); align-self:center;">
                        {{$post->titulo}}
                      </div>
                      <a style="color: rgb(143, 143, 151); align-self:center;z-index:2000;">
                        <button id="btn-denuncia" class="tag reportar" data-section="Report" data-value="Report">Report</button>
                                
                          <div id="denuncia-modal" class="modal">
                            <div class="modal-content">
                              <span class="close">&times;</span>
                              <h2 style="margin: 0 auto;" data-section="Report" data-value="dContent">Report Content</h2>
                              <form action="{{ route("denuncia.post", $post) }}" method="POST">
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

                      @auth
                        @if ($post->user_id===auth()->user()->id)           
                          <div>          
                            <form action="{{route('posts.destroy',$post)}}" method="POST">
                              @method('DELETE')
                              @csrf
                              <input type="submit" value="Eliminar" style="background: red;color:antiquewhite;">
                            </form>
                          </div>
                        @endif
                          
                      @endauth
                      
                    </div>
   
              
                
                    <hr style="color: rgba(190, 183, 183, 0.39);width: 100%;">
                    @php
                        $usu=\App\Models\User::where('id',$post->user_id)->first();

                    @endphp
                                    
       
                    <div class="container" style="margin-bottom: 1.6rem;">
                      <div class="row" style="display: flex;flex-wrap:wrap;">  
                        
                        <div class="col-3 col-sm-4"style="margin-top:1rem;max-width:110px;margin-bottom:1rem;justify-content: space-between;">
                          <a href="{{route('posts.index', ['user'=>$post->user])}}">
                            <div style="margin: 0 auto; height: 0;  padding-bottom: 100%; 
                            background-repeat: no-repeat; background-position: 50%; 
                            border-radius: 50%; background-size: cover; background-image: url('{{$usu->profile_cach>0?asset('img/P' . $usu->username . '.png'): $usu->prof }}');"></div>

                          </a>
                          <style>
                            @media (max-width: 425px) {
                              
                             
                            }
                          </style>
                        </div>
                        <div class="col-9 col-sm-8" >
                          <div style="display: flex;flex-wrap: wrap;gap:3px;">
                            <div class="col-auto" style="margin-left: 1rem; margin-right:1rem;">
                              <div style="display: grid;grid-template-columns: 1fr;height: 100%; ">
                                
                                <div style=" margin: auto 0;display: flex; justify-content: space-between;
                                height: 35%; margin-bottom:0;padding-bottom:0;">
                                  <a href="{{route('posts.index', ['user'=>$post->user])}}"> 
                                    <h4 style="height: 0.6rem;color: rgb(143, 143, 151);margin-bottom: 2rem;">
                                      {{$post->user->name}}
                                    </h4>
                                  </a>
                                </div>                    
                                <div style="margin: auto 0;margin-top:1rem;"> 
                                  <a href="{{route('posts.index', ['user'=>$post->user])}}">
                                    <h6 style="height: 0.6rem;color: rgb(143, 143, 151);">
                                      &commat;{{$post->user->username}}
                                    </h6>
                                  </a>
                                </div>                              
                              </div>
                            </div>  
                            <div style="margin-left:-5rem; margin: auto 0;">
                              <div class="end">
                                @php
                                  $tiendas= $usu->onlinestores;
                                  $conx= \App\Models\cxsturs::all()->where('user_id');
                                @endphp
                                @foreach($tiendas as $onlinestore)
                                  <a href="{{ $conx->where('onlinestore_id', $onlinestore->id)->where('user_id', $user->id)->first()->enlace}}" target="_blank">
                                    <img src="{{ asset('img/'.$onlinestore->logourl )}}" alt="{{ $onlinestore->nombre }}" width="25" height="25" style="margin-right: 0.9rem;">
                                  </a>
                                @endforeach
                                  
                                 
                              </div>
                            </div>
                          </div>
                            
                      </div>
                    </div>
                  </div>
                  <div class="collapse" id="sm">
                    <div style="display: flex; flex-wrap: wrap;justify-content: flex-start;margin-bottom: 1rem;">
                     
                        @foreach ($tags as $tag)
                          <a href="{{ route('tag.show', $tag) }}" class="tag">{{ $tag->name }}</a>
                        @endforeach
                    
                    
                    
                    </div>
                  </div>
                <div class="centrar">
                    <hr style="width: 100%;">
                    <button class="buttonsm butcolor" id="toggleBtn" type="button" data-bs-toggle="collapse" data-bs-target="#sm" aria-expanded="false" aria-controls="collapseWidthExample">
                      See more 
                  </button>
                              
                </div>
            </div>
        </div>
            <script>
              var toggleBtn = document.getElementById('toggleBtn');
              toggleBtn.addEventListener('click', function() {
                  if (toggleBtn.innerHTML.trim() === 'See more') {
                      toggleBtn.innerHTML = 'See less';
                  } else {
                      toggleBtn.innerHTML = 'See more';
                  }
              });
            </script>
      </div>
        <div class=" col-md-6 col-sm-12" >
<script type="text/javascript" data-cfasync="false" async src="https://poweredby.jads.co/js/jads.js"></script>
<ins id="1044207" data-width="308" data-height="528"></ins>
<script type="text/javascript" data-cfasync="false" async>(adsbyjuicy = window.adsbyjuicy || []).push({'adzone':1044207});</script>
        </div>
    </div>
  </div>
</div>
</div>
@php 
  $conx= \App\Models\cxsturs::all();
@endphp
  @if($all->count())
  <div class="grid-contain" style="margin: 0 auto">
      @foreach($all as $al)
          @if (imageExists($al->url))
          <a href="{{route('posts.show',['post'=>$al,'user'=>$user])}}">
            <div  class="grid-items" >
                <div class="card bg-dark text-white">
                    <img class="rounded-3" src="{{$al->cache_active>0? asset('img/' . $al->id . '.png'):$al->url;}}" 
                    width="250" height="@php if($al->cache_active>0 && $al->width>0 && $al->image_height>0){$im=$al->width>0?$al->width:250; echo 250/($im)*$al->image_height;} else{$im=getimagesize($al->url); echo (250/$im[0])*$im[1]; } @endphp"
                    alt="imagen del post de "{{$user->username}}>
                    <div class="card-img-overlay cs" style="pointer-events: none;">
                        <div class="crds">
                        </div>
                    </div>
                </div>
                <div style="display: flex;">
                     <a href="{{route('posts.index', ['user'=>$al->user])}}" style="position: absolute;margin-top:-1.7rem;text-decoration:none;" class="card-title ns">
                    {{$al->user->username}}
                </a>
                <a href="{{$conx->where('onlinestore_id',$al->onlinestore->id)->where('user_id',$al->user_id)->first()->enlace}}" style="position:absolute;margin-top: -10%;right:-2%;" target="_blank">
                    <img src="{{ asset('img/'.$al->onlinestore->logourl )}}" alt="{{ $post->nombre }}" width="25" height="25" style="border-radius:2%;margin-right: 0.6rem; margin-top:-0.8rem;">
                </a>
                </div>
            </div>
        </a>  
          @endif  
      @endforeach
  </div>
@endif
@php
foreach($all as $al){
  app('App\Http\Controllers\PostController')->descargarcache($al);
}
@endphp
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

  <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.js"></script>
  <script>
      var elem=document.querySelector(".grid-containn");
      var msnry=new Masonry(elem, {
          itemSelector:".grid-itemss",
          columnWidth:260,
          gutter: 2,
          isFitWidth:true
      });
  </script>

@endsection