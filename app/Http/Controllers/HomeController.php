<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $imagenes = Image::orderBy('id', 'desc')->paginate(4);
        return view('home', compact('imagenes'));
    }



}
