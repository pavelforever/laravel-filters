{{-- resources/views/admin/posts/index.blade.php --}}

@extends('adminlte::page')

@section('content_header')
<div>
    <h1 class="mb-2 mr-3">Tags</h1>
</div>
@stop

@section('content')
    <div class="container">
        <table class="table">
            <thead class="mb-5">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Posts</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($tags as $tag)
                    <tr>
                        <td>{{ $tag->id }}</td>
                        <td>{{ $tag->title }}</td>
                        <td>{{ $tag->posts_count}}</td>
                        <div class="d-flex">
                            <td class="justify-content-around align-items-center" style="min-height: 65px"> 
                                <a href="{{route('admin.tags.show',$tag->id)}}"><i class="far text-primary fa-eye"></i></a>
                            </td>
                            <td class="align-items-center" style="min-height: 65px">
                                <a href="{{route('admin.tags.edit',$tag->id)}}"><i class="fas cursor-pointer text-warning fa-edit"></i></a>
                            </td>
                            <td class="justify-content-around align-items-center" style="min-height: 65px">
                                <form method="post" action="{{route('admin.tags.destroy',$tag->id)}}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-transparent text-center border-0"><i class="fas text-danger fa-trash mr-2"></i></button>
                                </form>
                            </td>
                        </div>
                    </tr> 
                @endforeach
            </tbody>
        </table>
    </div>
@stop
