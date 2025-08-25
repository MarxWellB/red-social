@extends('layouts.app')
@section('publicidad')
<style>
    .responsive-container {
        margin: auto;
        padding: 5px;
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-start; 
    }


    @media (min-width: 770px) {
        .responsive-container {
            justify-content: flex-start;
            margin-bottom: 10px; 
        }    
    }
   
@media (min-width: 1278px) {
    .responsive-container {
        justify-content: flex-start;
        margin-left: 0.8%;
    }

    .hidedPublicy {
        display: none;
    }

    .hidePublicy {
        display: block; 
    }
}

@media (max-width: 1278px) {
    .hidedPublicy {
        display: block; 
    }

    .hidePublicy {
        display: none; 
    }
    

}.hidedoPublicy {
        display: none;
    }
@media (max-width: 756px) {
    .hidedoPublicy {
        display: block;
    }

}
</style>
    <div class="responsive-container grid-initial" style="margin-bottom: 0px;">  
       
            
        
            <div style="display: flex;flex-wrap:wrap;">
                @foreach ($initial as $item)
                                <a class=" grid-link user" href="{{route('posts.index', ['user'=>$item])}}">
                                    <div  class="grid-itemsinitial" width="250">
                                        <div class="card bg-dark text-white">
                                            <img class="rounded-3" src="{{$item->prof}}" width="250" height="@php $im=getimagesize($item->prof); echo (250/$im[0])*$im[1]; @endphp" alt="imagen del post de $user->username}}">
                                            <div class="card-img-overlay cs" style="pointer-events: none;">
                                                <div class="crds">
                                                    <a style="position: absolute;margin-top:-1.5rem;text-decoration:none;" class="card-title ns">{{$item->username}}</a>                                
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>  
                        @endforeach
            </div>
                <div style="display: flex;flex-wrap:wrap;" height="262">
                        <div class="grid-itemsinitial hidedPublicy"> 
                        <script type="text/javascript" data-cfasync="false" async src="https://poweredby.jads.co/js/jads.js"></script>
                        <ins id="1044484" data-width="250" data-height="262"></ins>
                        <script type="text/javascript" data-cfasync="false" async>(adsbyjuicy = window.adsbyjuicy || []).push({'adzone':1044484});</script>
                    </div>
                    <div class="grid-itemsinitial hidedoPublicy" height="262"> 
                        <script type="text/javascript" data-cfasync="false" async src="https://poweredby.jads.co/js/jads.js"></script>
                        <ins id="1044484" data-width="250" data-height="262"></ins>
                        <script type="text/javascript" data-cfasync="false" async>(adsbyjuicy = window.adsbyjuicy || []).push({'adzone':1044484});</script>
                    </div>
                </div>
            <div  class=" grid-itemsinitial" >
                <div class=" hidePublicy" height="262">
                    <script type="text/javascript" data-cfasync="false" async src="https://poweredby.jads.co/js/jads.js"></script>
                    <ins id="1044485" data-width="516" data-height="270"></ins>
                    <script type="text/javascript" data-cfasync="false" async>(adsbyjuicy = window.adsbyjuicy || []).push({'adzone':1044485});</script>
                </div> 
            </div>
    </div>

@endsection