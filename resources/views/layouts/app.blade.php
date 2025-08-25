<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="google" content="notranslate">

    <title>FansRoad @yield('titulo')</title>
    @stack('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="icon" href="{{asset('img/FR.ico')}}" type="image/x-icon">
    
    <meta name="juicyads-site-verification" content="f0ce0cb7e5e6586b15e0e77906b566c5">
    @vite('resources/css/man.css')
    @vite('resources/css/tag.css')
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <link rel="stylesheet" href="style.css">
    <script src=""></script>
    @stack('styles')
</head>
<body class="bcolor">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    

    <header>
      <div id="ageVerificationModal" class="modal-age-verification" style="display: none;">
        <div class="modal-content">
        <h2 data-section="navbar" data-value="Confirm"></h2>
        <p data-section="navbar" data-value="Age"></p>

      <button class="tag" onclick="confirmAge()" data-section="navbar" data-value="Than"></button>
      <button class="tag" onclick="denyAccess()" data-section="navbar" data-value="Less"></button>
  </div>
</div>
<script>
  window.onload = function() {
      if (!localStorage.getItem('ageVerified')) {
          document.getElementById('ageVerificationModal').style.display = 'block';
      }
  };

  function confirmAge() {
      localStorage.setItem('ageVerified', 'true');
      document.getElementById('ageVerificationModal').style.display = 'none';
  }

  function denyAccess() {
      alert('Lo sentimos, no puedes acceder al contenido.');
      window.location.href = 'https://google.com';
  }
</script>



<style>
                .flot {left: 25rem;}
                .intam{width: 17rem;}
              
                @media (min-width: 300px) and (max-width: 365px) {
                  .flot {
                    left: 15rem;
                  }
                  .intam{width: 11rem;}
                }

                @media (min-width: 366px) and (max-width: 416px) {
                  .flot {
                    left: 18rem;
                  }
                  .intam{width: 13rem;}
                }

                @media (min-width: 417px) and (max-width: 467px) {
                  .flot {
                    left: 21rem;
                  }
                  .intam{width: 16rem;}
                }
                
                @media (min-width: 468px) and (max-width: 516px) {
                  .flot {
                    left: 24rem;
                  }
                  .intam{width: 18rem;}
                }
                @media (min-width: 517px) and (max-width: 534px) {
                  .flot {
                    left: 27rem;
                  }
                  .intam{width: 22rem;}
                }
                @media (min-width: 535px) and (max-width: 555px) {
                  .flot {
                    left: 28rem;
                  }
                  .intam{width: 22rem;}
                }
                @media (min-width: 556px) and (max-width: 581px) {
                  .flot {
                    left: 28rem;
                  }
                  .intam{width: 23.5rem;}
                }
                @media (min-width: 582px) and (max-width: 602px) {
                 
                  .intam{width: 25.5rem;}
                }
                @media (min-width: 603px) and (max-width: 625px) {
                  
                  .intam{width: 28rem;}
                }
                @media (min-width: 626px) and (max-width: 763px) {
                  
                  .intam{width: 28rem;}
                }
              .search-form {
                  display: flex;
              }
              .nosearch-form {
                  display: none;
              }
              @media screen and (max-width: 760px) {
                  .search-form {
                      display: none;
                  }
                  .nosearch-form {
                      display: flex;
                  }
              }
             
                  .color{
                    color:aliceblue;
                  }
</style>
        <div class="tag-container container" style="max-width:1350px;">
          <nav class="navbar navbar-expand-sm navbar-dark bcolor" style="border:1rem; display:flex;justify-content:space-between;">
            <div class="container" >
              <a class="navbar-brand" href="{{route('posts.principal')}}" translate="no" style="margin-top:0.62rem;">FansRoad</a>
              <button class="navbar-toggler flot" style="position: absolute;" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="margin-top:0.7rem;">
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{route('navbar.navtag')}}" data-section="navbar" data-value="Etiqueta">Tags</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{route('perfil.show')}}" data-section="navbar" data-value="Modelo">Models</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="{{route('store.all')}}" data-section="navbar" data-value="Plataforma">Plataforms</a>
                  </li>
                </ul>
                  <div class="tag-container container" style="margin-top: 0.2rem;">
                    <div class="tags-wrapper input-group">
                      <form action="{{ route('search.buscar') }}" method="GET" class="search-form"style="margin-bottom:-0.5rem;">
                        <input type="text" name="q" id="q" class="form-control tag buscar"  
                          style="outline:none;margin-right: 5px; background-color: #1b1b1b; color: #fff; border: none;width:14rem;margin-top:" 
                          data-placeholder="SearchPlace" placeholder="">
                        <button class="tag" data-section="navbar" data-value="Buscar">Search</button>
                      </form>
                    </div>
                  </div>
                <style>
                  .flags{
                    width: 75px;
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                  }
                  .flags-items{
                    width: 30px;
                  }
                  .flags-img{
                    display: block;
                    cursor: pointer;
                  }
                  .language-button {
                    padding: 5px 10px;
                    border: none;
                    color: white;
                    background-color: #141212;
                    cursor: pointer;
                    border-radius: 10px 1px 1px 10px;
                    transition: background-color 0.3s, color 0.3s;
                  }
                  .es{
                    border-radius: 10px 1px 1px 10px;
                  }
                  .en{
                    border-radius: 1px 10px 10px 1px;
                  }
                  .language-button.selected {
                      color: #141212;
                      background-color: grey;
                      
                  }
                </style>
                <div id="flags" class="flags ">
                  <div class="flags_items" data-language="es">
                    <button id="lang-es" class="language-button es">Es</button>
                  </div>
                  <div class="flags_items" data-language="en">
                    <button id="lang-en" class="language-button selected en">En</button>
                  </div>
                </div>
              </div>
              <div style="display: flex;">
                @auth
                  <a class="tag"  href="{{route('posts.create')}}">
                    New
                  </a>
                  <p  class="loginReg"> 
                      Hola: 
                    <a href="{{route('posts.index',auth()->user()->username)}}" style="text-decoration: none; color:gray; ">
                      <span> 
                        {{auth()->user()->username}}
                      </span>
                    </a>
                    </p>
                    <form method="POST" action="{{route('logout')}}">
                      @csrf
                      <button type="submit" class="tag" > 
                        Cerrar sesion
                      </button>
                    </form>
                @endauth
              </div>
            </div>
          </div>
        </div>
      </nav>

        


        @php
          $tags = app('App\Http\Controllers\TagController')->navshowAllTags()->sortBy('name');
          $onlistore = app('App\Http\Controllers\OnlinestoreController')->navShowOs()->sortBy('nombre');
        @endphp
        <style>

        </style>
        <div class="tag-container container" style="max-width:90%;">
          <div class="tags-wrapper" style="margin:0 auto;">


            <div class="tag-container container" >
              <div class="tags-wrapper input-group ad-container">
                  <form action="{{ route('search.buscar') }}" method="GET" class="nosearch-form">
                      <input type="text" name="q" id="q" class="form-control tag intam buscar" placeholder="Search..." style="outline:none; background-color: #1b1b1b; color: #fff; border: none;">
                      <button class="tag">Search</button>
                  </form>
              </div>
              
          </div>
          
          


            @foreach ($onlistore as $os)

            <a href="{{ route('store.show', $os->nombre) }}" class="tag"><img src="{{asset('img/'.$os->logourl)}}" width="25" height="25" alt="{{$os->nombre }}" style="border-radius:2%;">{{" ". $os->nombre }}</a>
              
              
            @endforeach 
            <style>
          .ocultar .uno .dos .tres .cuatro .cinco .seis .siete{
            display: block;
          }
          .oculto{
            display: none;
          }
         @media (max-width: 374px) {
          .uno{display: none;}}
          @media (max-width: 351px) {
          .dos{display: none;}}
          @media (max-width: 417px) { 
          .tres{display: none;}}
          @media (max-width: 456px) {
          .cuatro{display: none;}}
          @media (max-width: 819px) { 
          .cinco{display: none;} }
          @media (max-width: 1060px) {
          .seis{display: none;}}
          @media (max-width: 1090px) {  
          .siete{display: none;}}
          @media (max-width: 1140px) {
          .ocho{display: none;}}
          @media (max-width: 1119px) {
          .nueve{display: none;}}
        </style>

@foreach ($tags as $tag)
@if ($tag->level === 1)
    @switch($loop->iteration)
        @case(1)
            <a href="{{ route('tag.show', $tag->name) }}" class="tag">{{ $tag->name }}</a>
            @break
        @case(2)
            <a href="{{ route('tag.show', $tag->name) }}" class="tag uno">{{ $tag->name }}</a>
            @break
        @case(3)
            <a href="{{ route('tag.show', $tag->name) }}" class="tag dos">{{ $tag->name }}</a>
            @break
        @case(4)
            <a href="{{ route('tag.show', $tag->name) }}" class="tag tres">{{ $tag->name }}</a>
            @break
        @case(5)
            <a href="{{ route('tag.show', $tag->name) }}" class="tag cuatro">{{ $tag->name }}</a>
            @break
        @case(6)
            <a href="{{ route('tag.show', $tag->name) }}" class="tag cinco">{{ $tag->name }}</a>
            @break
        @case(7)
            <a href="{{ route('tag.show', $tag->name) }}" class="tag seis">{{ $tag->name }}</a>
            @break
        @case(8)
            <a href="{{ route('tag.show', $tag->name) }}" class="tag siete">{{ $tag->name }}</a>
            @break
        @case(9)
            <a href="{{ route('tag.show', $tag->name) }}" class="tag ocho">{{ $tag->name }}</a>
            @break
        @case(10)
            <a href="{{ route('tag.show', $tag->name) }}" class="tag nueve">{{ $tag->name }}</a>
            @break
            @default
            <a href="{{ route('tag.show', $tag->name) }}" class="tag oculto">{{ $tag->name }}</a>
  
    @endswitch
@endif

@if ($loop->iteration > 20)
    @break
@endif
@endforeach

<button class="tag" id="show-more">Ver más</button>
</div>

<script>
  var showMoreButton = document.getElementById("show-more");
  var extraTags = document.querySelectorAll(".oculto");
  var showMore = false;

  for (var i = 0; i < extraTags.length; i++) {
      extraTags[i].style.display = "none";
  }

  showMoreButton.addEventListener("click", function () {
      showMore = !showMore; 

      for (var i = 0; i < extraTags.length; i++) {
          extraTags[i].style.display = showMore ? "inline" : "none"; 
      }

      showMoreButton.innerHTML = showMore ? "Ver menos" : "Ver más"; 
  });

  function checkResponsiveLayout() {
      if (window.innerWidth <= 1000) {
          for (var i = 0; i < extraTags.length; i++) {
              extraTags[i].style.display = showMore ? "inline" : "none";
          }

          showMoreButton.style.display = extraTags.length > 0 ? "inline" : "none";
          showMoreButton.innerHTML = showMore ? "Ver menos" : "Ver más";
      } else {
          for (var i = 0; i < extraTags.length; i++) {
              extraTags[i].style.display = "none";
          }

          showMoreButton.style.display = "none";
          showMore = false;
      }
  }

  window.addEventListener("DOMContentLoaded", checkResponsiveLayout);
  window.addEventListener("resize", checkResponsiveLayout);
</script>
    </header>

    <style>
      .tam {
          width: 88.5%;
              max-width: 1110px;
      }
      @media (max-width: 560px) {
          .tam {
              width: 88.5%;
          }
      }
  
      @media (min-width: 561px) and (max-width: 1060px) {
          .tam {
              width: calc(85.7% + 46.5 * ((100vw - 560px) / 500));
          }
      }
  
      @media (min-width: 1061px) and (max-width: 1140px) {
          .tam {
              width: 82%;
          }
      }
  
      @media (min-width: 1141px) and (max-width: 1319px) {
          .tam {
              width: 86%;
              max-width: 1110px;
          }
      }
  
    .ad-container {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
@media (min-width: 470px) {
    .bannerpub{
      display: block; 
    }
    .nobannerpub {
        display: none; 
    }
}

@media (max-width: 469px) {
    .bannerpub {
        display: none; 
    }
    .nobannerpub {
        display: block; 
    }
}
    </style>
      <hr class="tam">
      @if (auth()->user()==false)
        <div class="ad-container ">
          <div class="bannerpub">
            <script type="text/javascript" data-cfasync="false" async src="https://poweredby.jads.co/js/jads.js"></script>
            <ins id="1046007" data-width="468" data-height="72"></ins>
            <script type="text/javascript" data-cfasync="false" async>(adsbyjuicy = window.adsbyjuicy || []).push({'adzone':1046007});</script>
          </div>
        </div>
        <div class="ad-container ">
          <div class="nobannerpub" style="position: relative; right: -1rem;margin:0; padding:0;">
            <script type="text/javascript" data-cfasync="false" async src="https://poweredby.jads.co/js/jads.js"></script>
            <ins id="1046006" data-width="308" data-height="298"></ins>
            <script type="text/javascript" data-cfasync="false" async>(adsbyjuicy = window.adsbyjuicy || []).push({'adzone':1046006});</script>
          </div>
        </div>
      @endif
   
    



    <main style="max-width:1300px; margin: 0 auto;" >    
      

      @yield('contenido')
    </main>

    
    
    <footer class="text-center p-5" style="background-color: rgb(31, 30, 30);margin-top:3rem;">
      <div class="container" style="max-width: 1300px;">
          <div class="row">
              <div class="col-md-4 mb-4">
                  <ul style="color: gray; list-style: none; text-align: left;">
                      <li data-section="Footer" data-value="Info">
                        Information
                      </li>
                      <li>
                          <a href="{{route('info.tyc')}}" style="text-decoration: none; color: gainsboro;" data-section="Footer" data-value="TyC">Terms and Conditions</a>
                      </li>
                      <li>
                          <a href="{{route('info.pol')}}" style="text-decoration: none; color: gainsboro;" data-section="Footer" data-value="Policy">Privacy Policy</a>
                      </li>
                  </ul>
              </div>
  
              <div class="col-md-4 mb-4">
                  <ul style="color: gray; list-style: none; text-align: left;">
                      <li data-section="Footer" data-value="Content">
                        Content
                      </li>
                      <li>
                          <a href="{{route('info.prom')}}" style="text-decoration: none; color: gainsboro;" data-section="Footer" data-value="Promote">Promote</a>
                      </li>
                      <li>
                          <a href="{{route('info.addac')}}" style="text-decoration: none; color: gainsboro;" data-section="Footer" data-value="Include">Include Accounts</a>
                      </li>
                      <li>
                          <a href="{{route('info.remac')}}" style="text-decoration: none; color: gainsboro;" data-section="Footer" data-value="Delete">I Want to Delete an Account</a>
                      </li>
                  </ul>
              </div>
  
              <div class="col-md-4 mb-4">
                  <ul style="color: gray; list-style: none; text-align: left;">
                      <li data-section="Footer" data-value="Support">
                        Support
                      </li>
                      <li>
                          <a href="{{route('info.suport')}}" style="text-decoration: none; color: gainsboro;" data-section="Footer" data-value="Contact">Contact Support</a>
                      </li>
                      <li>
                          <a href="{{route('info.fq&a')}}" style="text-decoration: none; color: gainsboro;" data-section="Footer" data-value="FQ&A">Frequently Asked Questions</a>
                      </li>
                  </ul>
              </div>
          </div>
      </div>
  </footer>
  

    
      <script>
      
        const esButton = document.getElementById('lang-es');
    const enButton = document.getElementById('lang-en');

        const changeLanguage = async (language) => {
          if (language === 'en') {
            enButton.classList.add('selected');
            esButton.classList.remove('selected');
        } else {
            esButton.classList.add('selected');
            enButton.classList.remove('selected');
        }
          const bu = document.querySelectorAll(".buscar");     
          
          const requestJason = await fetch(`/languages/${language}.json`);
          const texts = await requestJason.json();
          const textsToChange = document.querySelectorAll("[data-section]"); 
          const FormToChange = document.querySelectorAll("[data-place]"); 
          for(const form of FormToChange){            
            const section = form.dataset.place;
            const value = form.dataset.val;
            form.placeholder= texts[section][value];
          }  
          localStorage.setItem('userLanguage', language);
          for(const busca of bu){
              if(language==='en'){
                busca.placeholder="Search...";
              }else{
                busca.placeholder="Buscar...";
              }
            }
          for (const textToChange of textsToChange) {
            const section = textToChange.dataset.section;
            const value = textToChange.dataset.value;
            textToChange.innerHTML = texts[section][value];
          }
        }       
        document.addEventListener('DOMContentLoaded', async () => {
          const userLanguage = localStorage.getItem('userLanguage') || 'en';
          await changeLanguage(userLanguage);       
          const flagsElement = document.getElementById('flags');
          if (flagsElement) {
            flagsElement.addEventListener('click', (e) => {
              
              changeLanguage(e.target.parentElement.dataset.language);
            });
          }
        });
      </script> 
</body> 
</html>