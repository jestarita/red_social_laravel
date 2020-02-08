<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\User;
class userController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($search= null){
        if(!empty($search)){
            $usuarios = User::orderBy('id', 'desc')
                            ->where('nick', 'LIKE', '%'.$search.'%') 
                            ->orwhere('name', 'LIKE', '%'.$search.'%') 
                            ->orwhere('surname', 'LIKE', '%'.$search.'%') 
                            ->paginate(5);
        }else{
            $usuarios = User::orderBy('id', 'desc')->paginate(5);
        }
        
        return view ('user.index',['usuarios'=>$usuarios]);
    }

    public function config(){
        return view('user.config');
    }

    public function actualizar_perfil(Request $solicitud){
        $usuario = \Auth::user();
        $id =  $usuario->id;
        $validator = $this->validate($solicitud,[
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'nick' => ['required', 'string', 'max:255', 'unique:users,nick,'.$id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id]
        ]);

        $usuario->name = $solicitud->input('name');
        $usuario->surname = $solicitud->input('surname');
        $usuario->nick = $solicitud->input('nick');
        $usuario->email = $solicitud->input('email');

        /*Subir imagenes */
        $image_path= $solicitud->file('image_path');

        if($image_path){
            $imagen = time().$image_path->getClientOriginalName();
            Storage::disk('users')->put($imagen,File::get($image_path));

            $usuario->image=$imagen;
        }

        $usuario->update();
        
        return redirect()->route('config')
                         ->with(['mensaje'=>'Usuario Actualizado']);
     
    }

    public function getImage($filename){
        $file = Storage::disk('users')->get($filename);
        return new Response($file, 200);
    }


    public function profile($id){

        $user = User::find($id);
        return view('profile.index', compact('user'));

    }

   
}
