<?php

namespace App\Http\Controllers;
use Modules\Gallary\Entities\AlbumType;
use Modules\Gallary\Entities\AlbumContentType;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth()->User();
        
        if($user->profile != null && $user->profile->systemAdmin != null){
            return redirect('/dashboard');
        }else{
            $profile = null;
            if($user->profile != null && $user->profile->child != null && $user->profile->husband == null && $user->profile->wife == null){
                $profile = $user->profile->child->birth->father->husband->profile;
            }else{
                $profile = $user->profile;
            }
            session()->put(['album_contents'=>AlbumContentType::all(),'album_types'=>AlbumType::all()]);
            return view('home',['profile'=>$profile,]);
        }
    }
}
