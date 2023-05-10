@extends('layouts.app')
@section('custom-style')
<style>
    #customers {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #customers td,
    #customers th {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: center;
    }

    #customers tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #customers tr:hover {
        background-color: #ddd;
    }

    #customers th {
        padding-top: 12px;
        padding-bottom: 12px;
        background-color: #04AA6D;
        color: white;
    }

    .action {
        display: flex;
        flex-direction: row;
        justify-content: space-around;
    }

    .add-btn {
        background-color: #0099FF;
        border: none;
        text-decoration: none;
        color: white;
        padding: 5px 20px;
        float: right
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
                    <div>
                        <a class="add-btn" href="{{route('post.create')}}"> Add</a>
                    </div>
                    <table id="customers">
                        <thead>

                            <th>No.</th>
                            <th>Title</th>
                            <th>Content</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach($posts as $key=> $post)
                            <tr>
                                <td>{{$post->id}}</td>
                                <td>{{substr($post->title,0,15)}}...</td>
                                <td>{{substr($post->content,0,75)}}...</td>
                                <td>{{date('d/m/Y',strtotime($post->created_at))}}</td>
                                <td>{{date('d/m/Y',strtotime($post->updated_at))}}</td>
                                <td class="action">
                                    <span>
                                        <a href="{{route('post.edit',[$post->slug])}}">
                                            <i class='bx bx-edit'></i>
                                        </a>
                                    </span>
                                    <span>
                                        <a href="{{route('post.show',[$post->slug])}}">

                                            <i class='bx bxs-show'></i>
                                        </a>
                                    </span>
                                    <span class="delete" category="{{$post->slug}}">
                                        <i class='bx bx-x-circle'></i>
                                    </span>
                                </td>

                            </tr>
                            @endforeach

                        </tbody>

                    </table>
                    <nav>
                        <ul class="pagination justify-content-center">
                            @for($i=1; $i <= $pages; $i++) @if(array_key_exists('page',$_REQUEST)) <li
                                class="page-item {{$i==$_REQUEST['page']?'active':''}}">
                                <a class="page-link" href="{{url('post').'?page='.$i}}">{{$i}}</a>
                                </li>
                                @else
                                <li class="page-item {{$i==1?'active':''}}">
                                    <a class="page-link" href="{{url('post').'?page='.$i}}">{{$i}}</a>
                                </li>
                                @endif


                                @endfor

                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="delete_modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Post</h5>

            </div>
            <div class="modal-body">
                <p>Are you sure about that?</p>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger save">Delete</button>
                <button type="button" class="btn btn-secondary dissmiss" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<form class="d-none delete_form" method="post" action="">
    @csrf
    @method('DELETE')
    <input type="submit">
</form>
<script>
    var catID = 0;
    var urlDel = "{{url('post')}}"
    $(document).ready(function () {
        $('.delete').click(function () {
            $("#delete_modal").modal('show')
            catID = $(this).attr('category')
        })
        $('.close').click(function () {
            $('#delete_modal').modal('hide');
        })
        $('.save').click(function () {

            $('.delete_form').attr('action', urlDel + '/' + catID)
            $('.delete_form').submit()
        })

    })
</script>
@endsection