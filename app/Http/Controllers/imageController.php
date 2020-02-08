<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use App\Comment;
use App\Like;

class imageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listado_imagenes()
    {
        return view('imagenes_publicadas.index');
    }

    public function save(Request $solicitud)
    {
        $usuario = \Auth::user();
        $id =  $usuario->id;

        $validator = $this->validate($solicitud, [
            'description' => ['required', 'string', 'max:255'],
            'image_path' => ['required', 'image']
        ]);
    
     
        $imagen = $solicitud->file('image_path');

        $imagen_nueva = new Image();
        $imagen_nueva->user_id= $id;
   
        $imagen_nueva->description= $solicitud->input('description');

        if ($imagen) {
            $nombre_imagen =time().$imagen->getClientOriginalName();
            Storage::disk('imagenes')->put($nombre_imagen, File::get($imagen));
            $imagen_nueva->image_path= $nombre_imagen;
        }
        $imagen_nueva->save();
        return redirect()->route('home')
      ->with(['mensaje'=> 'Foto subida sin problemas']);
    }

    public function get_image($imagen){

        $archivo = Storage::disk('imagenes')->get($imagen);
        return new Response($archivo, 200);
    }

    public function detail($id){
        $image = Image::find($id);
        return view ('imagen.detalle', ['item'=>$image]);
    }


    public function delete($id){
        $usuario = \Auth::user();
        $id_usu =  $usuario->id;
        $imagen = Image::find($id);
        $comentarios = Comment::where('image_id', $id)->get();
        $likes = Like::where('image_id', $id)->get();

        if($usuario && $imagen &&$imagen->user->id == $id_usu){

            /*Borrar comentarios */
            if($comentarios && count($comentarios)>=1){
                foreach ($comentarios as $comment) {
                    $comment->delete();
                }
            } 

            /*Borrar likes */
            if($likes && count($likes)>=1){
                foreach ($likes as $like) {
                    $like->delete();
                }
            } 

            /*Eliminar archivo */
            Storage::disk('imagenes')->delete($imagen->image_path);

            /*Eliminar registro */
            $imagen->delete();
            $mensaje = array('mensaje'=>'La Imagen Se ha borrado');

           

        }else{
            $mensaje = array('mensaje'=>'La Imagen no Se ha borrado');
        }
        return redirect()->route('home')->with($mensaje);
    }

    public function edit($id){
        $usuario = \Auth::user();
        $id_usu =  $usuario->id;
        $imagen = Image::find($id);

        if($usuario && $imagen && $imagen->user->id == $id_usu){

            return view('imagen.Editar',['imagen'=>$imagen]); 
        }else{
            return redirect()->route('home'); 
        }
    }

    public function update(Request $solicitud){
        $usuario = \Auth::user();
        $id =  $usuario->id;

        $validator = $this->validate($solicitud, [
            'description' => ['required', 'string', 'max:255'],
            'image_path' => [ 'image']
        ]);

        $image_id = $solicitud->input('image_id');
        $imagen = $solicitud->file('image_path');

        $imagen_nueva = Image::find($image_id);
        $imagen_nueva->user_id= $id;
   
        $imagen_nueva->description= $solicitud->input('description');

        if ($imagen) {
            $nombre_imagen =time().$imagen->getClientOriginalName();
            Storage::disk('imagenes')->put($nombre_imagen, File::get($imagen));
            $imagen_nueva->image_path= $nombre_imagen;
        }
        $imagen_nueva->update();

        return redirect()->route('Detalle_imagen', ['item'=>$image_id])
                        ->with(['mensaje'=>'Imagen Actualizada con Exito']);
       
    }
}
