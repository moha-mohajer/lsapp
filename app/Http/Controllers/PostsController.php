<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Use Eloquent
use App\Post;
// Use SQL qurry by bringing DB Librely
use  DB;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // // // Use SQL qurry
        // // $posts = DB::select('SELECT * FROM posts');
        // // Order by 
        // $posts = DB::select('SELECT * FROM posts ORDER BY title DESC');


        // // // // // Use Eloquent
        // // // // $posts = Post::all();
        // // // // Order by 
        // // // $posts = Post::orderBy('title', 'desc')->get();
        // // // specified
        // // return post::where('title', 'Post Two')->get();
        // // Just take 1 
        // $posts = Post::orderBy('title', 'desc')->take(1)->get();
        // paginate (number the page)
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);

        // Load the view
        return view ('posts.index')->with('posts',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Load up the view
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
        // Validation of input data
        $this->validate($request,[
            'title' =>'required',
            'body' =>'required'
        ]);

        // Create post
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->save();

        // redirect with success message
        return redirect('/posts')->with('success', 'Post Created');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //fatche it with database "Eloquent"
        // return Post::find($id);

        // return the view
        $post = Post::find($id);
        return view ('posts.show')->with('post', $post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       // return the view
       $post = Post::find($id);
       return view ('posts.edit')->with('post', $post);
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
        // Validation of input data
        $this->validate($request,[
            'title' =>'required',
            'body' =>'required'
        ]);

        // Update post
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->save();

        // redirect with success message
        return redirect('/posts')->with('success', 'Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
