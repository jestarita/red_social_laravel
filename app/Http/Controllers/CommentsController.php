<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function guardar_comentario(Request $solicitud){
        $usuario = \Auth::user();
        $id =  $usuario->id;

     	$validate = $this->validate($solicitud, [
			'image_id' => 'integer|required',
			'content' => 'string|required'
		]);
      $comentarios = new Comment();
      $comentarios->user_id= $id;

      $comentarios->image_id= $solicitud->input('image_id');
      $comentarios->content =$solicitud->input('content');

      $comentarios->save();

      return redirect()->route('Detalle_imagen', ['item'=> $solicitud->input('image_id')])
                        ->with(['mensaje'=> 'Comentario agregado Exitosamente']);

    }


    public function delete($id){
        $usuario = \Auth::user();
        $id =  $usuario->id;

        $comment = Comment::find($id);
        if($usuario && ($comment->user_id == $id  || $comment->image->user_id == $id)){
            $comment->delete();
            return redirect()->route('Detalle_imagen', ['item'=> $comment->image->id])
            ->with(['mensaje'=> 'Comentario eliminado Exitosamente']);
        }else{
            return redirect()->route('Detalle_imagen', ['item'=> $comment->image->id])
            ->with(['mensaje'=> 'No se puede eliminar el comentario']);
        }

    }

}
