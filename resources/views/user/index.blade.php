@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('includes.mensaje')
            <h1>Listado de usuarios</h1>
        <form class="" action="{{route('listado_usuarios')}}" id="buscardor">
            <div class="row">
                <div class=" form-group col">
                    <input type="text" id="search" name="search" class="form-control"> 
                </div>
                <div class=" form-group col btn-search">
                 <input type="submit" value="buscar"  class="btn btn-success"/>
                </div>
            </div>
        
            </form>
            @foreach ($usuarios as $item)
            <div class="profile-user">
         
                @if($item->image)
                <div class="guardar-avatar">
                <img  src="{{ route('avatar',['filename'=>$item->image]) }}"    class="avatar_profile" alt="">
        
                </div>
                @endif
              
               <div class="user-info">
               
                <h2>{{'@'.$item->nick}}</h2>
                <h3>{{$item->name}} {{$item->surname}}</h3>
                <p>
                    {{'Se Unio '.\FormatTime::LongTimeFilter($item->created_at)}}
                </p>
                <a href="{{route('perfil', ['id'=> $item->id])}}" class="btn btn-primary btn-sm">Ver Perfil</a>
               </div>
               <div class="clearfix"></div>
              
           </div>
           <div class="clearfix"></div>
           
                
            @endforeach
            <div class="clearfix"></div>
            {{$usuarios->links()}}
        </div>
     
    </div>
</div>
@endsection