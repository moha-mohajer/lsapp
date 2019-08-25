<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// image usage libraly
use Illuminate\Support\Facades\Storage;
// Use Eloquent
use App\Post;
// Use SQL qurry by bringing DB Librely
use  DB;

class PostsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',['except' => ['index', 'show']]);
    }
    
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
            'body' =>'required',
            'cover_image' =>'image|nullable|max:1999'
        ]);

        //Handel file upload
        if($request->hasFile('cover_image')){

            // et filename with the extension
            $fileNameToExt = $request->file('cover_image')->getClientOriginalName();

            // Get just file name
            $fileName = pathinfo($fileNameToExt, PATHINFO_FILENAME);
        
            // Get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();

            // Filename to store
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;

            //Upload imagen
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);

        }else{
            $fileNameToStore = 'noimage.jpg';
        }

        // Create post
        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        // Add loged in user id to the tabale
        $post->user_id = auth()->user()->id;
        $post->cover_image = $fileNameToStore;
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

       // Check for correct user
       if(auth()->user()->id !== $post->user->id){
            return redirect('/posts')->with('error', 'Unauthorized Page');
       }

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


        //Handel file upload
        if($request->hasFile('cover_image')){

            // et filename with the extension
            $fileNameToExt = $request->file('cover_image')->getClientOriginalName();

            // Get just file name
            $fileName = pathinfo($fileNameToExt, PATHINFO_FILENAME);
        
            // Get just ext
            $extension = $request->file('cover_image')->getClientOriginalExtension();

            // Filename to store
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;

            //Upload imagen
            $path = $request->file('cover_image')->storeAs('public/cover_images', $fileNameToStore);

        }

        // Update post
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        if($request->hasFile('cover_image')){
            $post->cover_image = $fileNameToStore;
        }
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
        // Update delete
        $post = Post::find($id);

        // Check for correct user
       if(auth()->user()->id !== $post->user->id){
        return redirect('/posts')->with('error', 'Unauthorized Page');
        }
        if($post->cover_image !== 'noimage.jpg'){
            Storage::delete('public/cover_images/'.$post->cover_image);
        }

        $post->delete();

        // redirect with success message
        return redirect('/posts')->with('success', 'Post Updated');
    }
}
