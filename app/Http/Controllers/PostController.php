<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\Models\Category;
use DB;
use Illuminate\Support\Str;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $posts = Post::paginate(10);
        $numberOfPosts = Post::all()->count();
        
        if($numberOfPosts < 10){
            $pages = 1;
           
        }else{  
            $pages = ceil($numberOfPosts / 10);
        }
        return view('pages.post.index',compact('posts','pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $post = new Post;
        $method="post";
        $categories = Category::all();
        $action = route("post.store");
        return view('pages.post.form', compact('post','action','method','categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
           
        ]);

     
        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('title')) {
                return redirect()->back()->withErrors($errors->first('title'));
            }

            if ($errors->first('content')) {
                return redirect()->back()->withErrors($errors->first('content'));
            }
        }
       
        $post = new Post;
        $post->title = $request->title;
        $post->content = $request->content;
        $post->user_id = Auth::user()->id;
        $post->slug = Str::slug($post->title);
        $post->save();
        if($request->categories){
            $post->category()->attach($request->categories);

        }
        return redirect(route('post.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        //
        $post = Post::where('slug', $slug)->firstOrFail();
        return view('pages.post.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        //
        $post = Post::where('slug', $slug)->firstOrFail();
        $method="put";
        $categories = Category::all();
        $action = route("post.update",[$post->id]);
        return view('pages.post.form', compact('post','action','method','categories'));
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
        //
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
           
        ]);
        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('title')) {
                return redirect()->back()->withErrors($errors->first('title'));
            }

            if ($errors->first('content')) {
                return redirect()->back()->withErrors($errors->first('content'));
            }
        }
        $post = Post::findOrFail($id);
        $post->title = $request->title;
        $post->content = $request->content;
        $post->user_id = Auth::user()->id;
        $post->slug = Str::slug($post->title);
        $post->save();
        if($request->categories){
            $post->category()->detach();
            $post->category()->attach($request->categories);
        }
        return redirect(route('post.show',[$post->slug]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        //
        $post = Post::where('slug', $slug)->firstOrFail();
        $post->category()->detach();
        $post->delete();
        return redirect()->back();
    }
}
