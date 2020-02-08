@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2>Publicaciones Favoritas</h2>
            <hr>
            @foreach ($likes as $item)
            <div class="card pub_image">
                <div class="card-header">
                    @if($item->user->image)
                    <div class="container-avatar">
                    <img  src="{{ route('avatar',['filename'=>$item->user->image]) }}"    class="avatar" alt="">
            
                    </div>
                    @endif
                    <div class="datos_usuario">
                    <a href="{{route('perfil', ['id'=> $item->user->id])}}">
                        {{$item->user->name.' '.$item->user->surname}}
                        <span class="nickname">
                            {{' | @'.$item->user->nick}}
                        </span>
                    </a>
                    </div>
                  
                
                </div>
                    
                <div class="card-body">
                    <div class="imagen-conteiner">
                        <img src="{{route('Obtener_imagenes', ['imagen'=>$item->image->image_path])}}" />
                    </div>
                
                    <div class="descripcion">
                      
                        <span class="nickname">{{'@'.$item->user->nick}}</span>
                        <span class="nickname">{{' | '.\FormatTime::LongTimeFilter($item->created_at)}}</span>
                        <p> {{$item->description}}</p>
                    </div>

                    <div class="likes">
                        <?php $user_like = false;?>
                        @foreach ($likes as $like)
                            @if ($like->user->id == Auth::user()->id)
                            <?php $user_like = true;?>
                            @endif
                          
                        @endforeach
                        @if($user_like)
                    <img src="{{asset('imagenes/rojo.png')}}" data-id="{{$item->image->id}}" class="btn_like"/>
                        @else 
                        <img src="{{asset('imagenes/gris.png')}}" data-id="{{$item->image->id}}" class="btn_dislike"/>
                        @endif
                        <span class="number_likes">{{count($likes)}}</span>
                        </div>
        
                    <div class="comments">
                        <a class="btn btn-warning btn-sm btn-comentario" href="{{route('Detalle_imagen', ['item'=> $item->id])}}">
                            Comentarios ({{count($item->image->comments)}})
                        </a>
                    </div>              
                
                
                </div>
            </div>


            @endforeach
            <div class="clearfix"></div>
            {{$likes->links()}}
        </div>
     
    </div>
</div>
@endsection