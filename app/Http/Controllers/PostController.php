<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Auth;
use Cache;
use App\Jobs\SendEmailJob;

class PostController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscribed = auth::user()->is_subscribed;
        $limit = env('PAGE_LIMIT');
        $posts = ($subscribed ==1) ? Post::where('is_approved',1)->paginate($limit) : 
                                     Post::where(['is_approved'=>1,'user_id'=>auth::user()->id])->paginate($limit);
        return view('post.index',compact('posts'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:posts,title|max:255',
            'user_id'=>'nullable|exists:users,id',
            'description' => 'required'
        ]);
        
        Post::create(['title'=> $request->title,
                      'description'=> $request->description,
                      'user_id' =>Auth::user()->id]);
   
        return redirect()->route('posts.index')
                        ->with('success','Blog created successfully.');
         
    }

    /**
     * Show the Admin dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminHome()
    {
        $limit = env('PAGE_LIMIT');
        $posts = Post::paginate($limit);
        return view('adminHome',compact('posts'));
    }

    /**
     * Blog Approve module 
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function postApprove($id)
    {
        $users = Cache::get('user_data') ?? [];
        $post = Post::find($id);
        $data = ['title'=>$post->title,'description'=>$post->description];
        
        foreach($users as $user)
        {
            $data['email'] = $user['email'];
            $data['user_name'] = $user['name'];
            SendEmailJob::dispatch($data);
        }

        $post->is_approved =1;
        $post->save();
        
        return redirect()->route('admin.home')
        ->with('success','Blog Approved successfully');
    }

}
