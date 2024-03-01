{{-- resources/views/admin/posts/index.blade.php --}}

@extends('adminlte::page')

@section('content_header')
<div>
    <h1 class="mb-2 mr-3">Posts</h1>
</div>
@stop

@section('content')
    <div class="container">
        <table class="table">
            <thead class="mb-5">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Tags</th>
                   <th></th>
                   <th></th>
                   <th></th>

                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->category->title}}</td>
                        <td>
                            @foreach ($post->tags as $i => $tag )
                                {{ $i > 0  ? ' / ' : ''}}{{ $tag->title }}
                            @endforeach    
                        </td>
                        
                        <div class="d-flex">
                            <td class="justify-content-around align-items-center" style="min-height: 65px"> 
                                <a href="{{route('admin.posts.show',$post->id)}}"><i class="far text-primary fa-eye"></i></a>
                            </td>
                            <td class="align-items-center" style="min-height: 65px">
                                <a href="{{route('admin.posts.edit',$post->id)}}"><i class="fas cursor-pointer text-warning fa-edit"></i></a>
                            </td>
                            <td class="justify-content-around align-items-center" style="min-height: 65px">
                                <form method="post" action="{{route('admin.posts.destroy',$post->id)}}">
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

        {{ $posts->links() }}
    </div>
@stop
