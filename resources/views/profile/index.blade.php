@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

           
         
           <div class="profile-user">
         
                @if($user->image)
                <div class="guardar-avatar">
                <img  src="{{ route('avatar',['filename'=>$user->image]) }}"    class="avatar_profile" alt="">
        
                </div>
                @endif
              
               <div class="user-info">
               
                <h1>{{'@'.$user->nick}}</h1>
                <h2>{{$user->name}} {{$user->surname}}</h2>
                <p>
                    {{'Se Unio '.\FormatTime::LongTimeFilter($user->created_at)}}
                </p>
               </div>
               <div class="clearfix"></div>
              
           </div>
           <div class="clearfix"></div>
           @foreach ($user->images as $item)
           @include('includes.imagenes', ['item'=>$item])
           @endforeach

       
       
         
        </div>
    </div>
</div>
@endsection