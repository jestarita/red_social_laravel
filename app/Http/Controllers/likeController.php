<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Like;
class likeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function likes(){
        $user = \Auth::user();
		$likes = Like::where('user_id', $user->id)->orderBy('id', 'desc')->paginate(5);
        return view('likes.index',[
			'likes' => $likes
		]);
    }

    public function like($imagen_id){
        $usuario = \Auth::user();
        $id =  $usuario->id;
        
        $check_like= Like::where('user_id', $id)
                        ->where('image_id', $imagen_id);
        if($check_like->count()==0){
            $like = new Like();
            $like->user_id= $id;
            $like->image_id= (int)$imagen_id;
    
            $like->save();
            return Response()->json([
                'like'=> $like
            ]);
        }else{
            return Response()->json([
                'Mensaje'=> 'Ya Existe el like'
            ]);
        }
       
    }

    public function dislike($imagen_id){
        $usuario = \Auth::user();
        $id =  $usuario->id;
        
        $like= Like::where('user_id', $id)
                        ->where('image_id', $imagen_id)
                        ->first();
        if($like){
          
    
            $like->delete();
            return Response()->json([
                'like'=> $like,
                'Mensaje'=> 'Has Dado Dislike'
            ]);
        }else{
            return Response()->json([
                'Mensaje'=> 'No Existe el Like'
            ]);
        }

    }
}
