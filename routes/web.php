<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Image;

// Route::get('/', function () {

//     // $imagenes = Image::all();

//     // foreach($imagenes as $imagen){
//     //     echo $imagen->image_path."<br/>";
//     //     echo $imagen->description."<br/>";
//     //     echo $imagen->user->name.' '.$imagen->user->surname."<br/>";

//     //     if(count($imagen->comments) >=1){
//     //         echo "<h4>Comentarios</h4>";
//     //         foreach($imagen->comments as $comment){
//     //             echo $comment->user->name.' '.$comment->user->surname.": ";
//     //             echo $comment->content."<br>";
//     //         }

//     //     }
//     //     echo "Likes: ".count($imagen->likes)."<br/>";
//     //     echo "<hr>";
//     // }
//     return view('welcome');
// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/*Metodo para hacer acceder perfil y actualizar imagen */
Route::get('/perfil', 'userController@config')->name('config');
Route::post('/update_perfil', 'userController@actualizar_perfil')->name('Actualizar_perfil');
Route::get('/avatar/{filename}', 'userController@getImage')->name('avatar');
Route::get('/listado_usuarios/{search?}', 'userController@index')->name('listado_usuarios');


/*Controlador imagenes */
Route::get('/subir_imagenes', 'imageController@listado_imagenes')->name('subir.imagen');
Route::post('/agregar_imagen', 'imageController@save')->name('agregar_imagen');
Route::post('/Actualizar_imagen', 'imageController@update')->name('Actualizar_imagen');
Route::get('/editar_imagen/{id}', 'imageController@edit')->name('editar_imagen');
Route::get('/Detalle_imagen/{item}', 'imageController@detail')->name('Detalle_imagen');
Route::get('/Delete_imagen/{item}', 'imageController@delete')->name('Delete_imagen');
Route::get('/Obtener_imagenes/{imagen}', 'imageController@get_image')->name('Obtener_imagenes');

/*Controlador Comentarios */

Route::post('agregar_comentario', 'CommentsController@guardar_comentario')->name('comentario.add');
Route::get('/eliminar_comentario/{id}', 'CommentsController@delete')->name('eliminar_comentario');

/*Controlador Likes */
Route::get('Publicaciones_favoritas', 'likeController@likes')->name('Publicaciones_favoritas');
Route::get('Dar_like/{image_id}', 'likeController@like')->name('Dar_like');
Route::get('Dar_dislike/{image_id}', 'likeController@dislike')->name('Dar_dislike');

/* Perfil */

Route::get('perfil/{id}', 'userController@profile')->name('perfil');