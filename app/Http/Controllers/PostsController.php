<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Post;

class PostsController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',['except'=>['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate request
        $this->validate($request, [
            'title'=>'required',
            'body'=>'required',
            'cover_image'=>'image|nullable|max:1999'
        ]);

        //handle upload
        if($request->hasFile('cover_image')){
            $fileNameToBeStored = auth()->user()->id.time().'_'.$request->file('cover_image')->getClientOriginalName();
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToBeStored);
        }else{
            $fileNameToBeStored = 'noImage.png';
        }

        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileNameToBeStored;
        $post->save();
        return redirect('/posts')->with('success', 'Post created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        //checking unauthorized access
        if($post->user_id != auth()->user()->id){
            return redirect('/posts')->with('error', 'Unauthorized access');
        }

        return view('posts.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title'=>'required',
            'body'=>'required'
        ]);
        $post = Post::find($id);
        if($post->user_id != auth()->user()->id){
            return redirect('/posts')->with('error', 'Unauthorized access');
        }

        //image handling
        if($request->hasFile('cover_image')){
            if($post->cover_image != 'noImage.png'){
                Storage::delete('public/cover_images/'.$post->cover_image);
            }
            $fileNameToBeStored = auth()->user()->id.time().'_'.$request->file('cover_image')->getClientOriginalName();
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToBeStored);
            $post->cover_image = $fileNameToBeStored;
        }

        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->save();
        return redirect('/posts')->with('success', 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        if($post->user_id != auth()->user()->id){
            return redirect('/posts')->with('error', 'Unauthorized access');
        }
        if($post->cover_image != 'noImage.png'){
            Storage::delete('public/cover_images/'.$post->cover_image);
        }
        $post->delete();
        return redirect('/posts')->with('success', 'Post deleted succcesfully');
    }
}
