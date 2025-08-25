@extends('layouts.app')

@section('titulo')
    
@endsection


@section('contenido')
<h1>

  
 

</h1>
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
                     @php $imm=getimagesize($post->url); echo $imm[0]; @endphp" height="@php $imm=getimagesize($post->url); echo $imm[1]; @endphp
                      <img class="rounded-3" src="{{$post->url}}"  style="@if (($imm[1])>670) 
                      width:75%; position:relative;right:-10%;
                      @else
                      width:100%
                      @endif ;margin-bottom: 0.5rem;" >                
                    
                    </div>

                    <div style="margin-bottom: 0.2rem; display: grid;grid-template-columns: 5fr 1fr 1fr;">

                      <div style="color: rgb(143, 143, 151); align-self:center;">
                        {{$post->titulo}}

                        
                      </div>

                      <a style="color: rgb(143, 143, 151);align-self:center;">

                      </a>

                     
                      
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
                            border-radius: 50%; background-size: cover; background-image: url('{{ $usu->prof }}');"></div>

                          </a>
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




        
      
    </div>
  </div>

</div>
</div>

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