@extends('layouts.app')
@section('custom-style')
<style>
    input[type=text],
    select,
    textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        resize: vertical;
    }

    label {
        padding: 12px 12px 12px 0;
        display: inline-block;
    }

    input[type=submit] {
        background-color: #04AA6D;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        float: right;
    }

    input[type=submit]:hover {
        background-color: #45a049;
    }

    .container {
        border-radius: 5px;
        background-color: #f2f2f2;
        padding: 20px;
    }

    /* Clear floats after the columns */
    .row:after {
        content: "";
        display: table;
        clear: both;
    }

    h4 {
        background-color: red;
        padding: 10px;
        color: white;
    }
</style>
@endsection
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Post') }}</div>

                <div class="card-body">
                    @if($errors->any())
                    <h4>{{$errors->first()}}</h4>
                    @endif
                    <div class="container">
                        <form action="{{$action}}" method="post" enctype="multipart/form-data">
                            @method($method)
                            @csrf


                            <div class="row">
                                <div class="col-25">
                                    <label for="title">Post Title</label>
                                </div>
                                <div class="col-75">
                                    <input type="text" id="title" name="title" placeholder="Post Title"
                                        value="{{$post->title}}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-25">
                                    <label for="content">Post Content</label>
                                </div>
                                <div class="col-75">
                                    <textarea id="content" name="content" placeholder="Write something.."
                                        value="{{$post->content}}" style="height:200px"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-25">
                                    <label for="categories">Post Content</label>
                                </div>
                                <div class="col-75">
                                    <select id="categories" name="categories[]" multiple>
                                        @foreach($categories as $category)
                                        <option value="{{$category->id}}" {{in_array($category->
                                            id,$post->categoriesID())?'selected':''}}>{{$category->category_name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <input type="submit" value="Submit">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection