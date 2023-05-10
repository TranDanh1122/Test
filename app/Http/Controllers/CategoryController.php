<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::paginate(10);
        $numberOfPosts = Category::all()->count();
        
        if($numberOfPosts < 10){
            $pages = 1;
           
        }else{  
            $pages = ceil($numberOfPosts / 10);
        }
       
        return view('pages.category.index',compact('categories','pages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = new Category;
        $method="post";
        $action = route("category.store");
        return view('pages.category.form', compact('category','action','method'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required',
            'description' => 'required',
           
        ]);

     
        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('category_name')) {
                return redirect()->back()->withErrors($errors->first('category_name'));
            }

            if ($errors->first('description')) {
                return redirect()->back()->withErrors($errors->first('description'));
            }
        }
        $category = new Category;
        $inputData = $request->except('_token');
        $inputData['slug'] = Str::slug($inputData['category_name']);
        $category->create($inputData);
        return redirect(route('category.index'));
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
        
        $category = Category::where('slug', $slug)->firstOrFail();
        return view('pages.category.show',compact('category'));
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
        
        $category = Category::where('slug', $slug)->firstOrFail();
        $action = route('category.update',[$category->id]);
        $method="put";
        return view('pages.category.form',compact('category','action','method'));
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
            'category_name' => 'required',
            'description' => 'required',
           
        ]);

     
        if ($validator->fails()) {

            $errors = $validator->errors();

            if ($errors->first('category_name')) {
                return redirect()->back()->withErrors($errors->first('category_name'));
            }

            if ($errors->first('description')) {
                return redirect()->back()->withErrors($errors->first('description'));
            }
        }
        $category = Category::findOrFail($id);
        $inputData = $request->except('_token');
        $inputData['slug'] = Str::slug($inputData['category_name']);
        $category->update($inputData);
        return redirect(route('category.show',[$category->slug]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $category->post()->detach();
        $category->delete();
        return redirect()->back();

    }
}
