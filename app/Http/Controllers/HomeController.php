<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use auth;

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

        $subscribed = auth::user()->is_subscribed;
        $limit = env('PAGE_LIMIT');
        $posts = ($subscribed ==1) ? Post::where('is_approved',1)->paginate($limit) : 
                                     Post::where(['is_approved'=>1,'user_id'=>auth::user()->id])->paginate($limit);
         dd($posts);
       // return view('post.index',compact('posts'));

    }

      
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminHome()
    {
        return view('adminHome');
    }
}
