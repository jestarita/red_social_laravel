@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @include('includes.mensaje')
          
                
        
            <div class="card pub_image pub_image_details">
                <div class="card-header">
                    @if($item->user->image)
                    <div class="container-avatar">
                    <img src="{{url('avatar/'.Auth::user()->image)}}" class="avatar" alt="">
                    </div>
                    @endif
                    <div class="datos_usuario">
                        {{$item->user->name.' '.$item->user->surname}}
                        <span class="nickname">
                            {{' | @'.$item->user->nick}}
                        </span>
                    </div>
                  
                
                </div>
                    
                <div class="card-body">
                    <div class="imagen-conteiner imagen-detalle">
                        <img src="{{route('Obtener_imagenes', ['imagen'=>$item->image_path])}}" />
                    </div>
                
                    <div class="descripcion">
                        <span class="nickname">{{'@'.$item->user->nick}}</span>
                        <span class="nickname">{{' | '.\FormatTime::LongTimeFilter($item->created_at)}}</span>
                        <p> {{$item->description}}</p>
                    </div>
                    <div class="likes">
                        <?php $user_like = false;?>
                        @foreach ($item->likes as $like)
                            @if ($like->user->id == Auth::user()->id)
                            <?php $user_like = true;?>
                            @endif
                          
                        @endforeach
                        @if($user_like)
                    <img src="{{asset('imagenes/rojo.png')}}" data-id="{{$item->id}}" class="btn_like"/>
                        @else 
                        <img src="{{asset('imagenes/gris.png')}}" data-id="{{$item->id}}" class="btn_dislike"/>
                        @endif
                        <span class="number_likes">{{count($item->likes)}}</span>
                        </div>
                        @if (Auth::user() && Auth::user()->id == $item->user->id)
                        <div class="actions">
                            <a href="{{route('editar_imagen', ['id'=>$item->id])}}" class="btn btn-primary btn-sm">Editar</a>
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#myModal">Borrar</button>
                            <div id="myModal" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                              
                                  <!-- Modal content-->
                                  <div class="modal-content">
                                    <div class="modal-header">
                                     
                                      <h4 class="modal-title">Seguro que deseas eliminar Esta Imagen</h4>
                                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Si haces esto no podras recuperar la imagen.
                                            Deseas hacerlo?
                                        </p>
                                      </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-success btn-sm" data-dismiss="modal">Cerrar</button>
                                      <a href="{{route('Delete_imagen',['item'=>$item->id ])}}" class="btn btn-danger btn-sm">Eliminar Definitivamente</a>
                                    </div>
                                  </div>
                              
                                </div>
                              </div>
                            
                        </div> 
                        @endif
                       
            
                       
                        <div class="clearfix"></div>
                    <div class="comments">
                        <h2>Comentarios ({{count($item->comments)}})</h2>
                        <hr>
                        <form method="POST" action="{{ route('comentario.add') }}">
							@csrf

							<input type="hidden" name="image_id" value="{{$item->id}}" />
							<p>
								<textarea class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}" name="content"></textarea>
								@if($errors->has('content'))
								<span class="invalid-feedback" role="alert">
									<strong>{{ $errors->first('content') }}</strong>
								</span>
								@endif
							</p>
							<button type="submit" class="btn btn-success">
								Enviar
							</button>
                        </form>
                        <hr>
                        @foreach ($item->comments as $comentario)
                            <div class="comment">
                                <div class="descripcion">
                                    <span class="nickname">{{'@'.$comentario->user->nick}}</span>
                                    <span class="nickname">{{' | '.\FormatTime::LongTimeFilter($comentario->created_at)}}</span>
                                    <p> {{$comentario->content}}
                                        <br>
                                    @if(Auth::check() && ($comentario->user_id == Auth::user()->id  || $comentario->image->user_id == Auth::user()->id ))
                                <a href="{{route('eliminar_comentario', ['id'=>$comentario->id])}}" class="btn btn-danger btn-sm">
                                    Eliminar</a>
                                    @endif
                                </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
    
         
        </div>
     
    </div>
</div>
@endsection
