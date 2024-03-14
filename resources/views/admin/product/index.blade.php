{{-- resources/views/admin/posts/index.blade.php --}}

@extends('adminlte::page')

@section('content_header')
<div>
    <h1 class="mb-2 mr-3">Products</h1>
</div>
@stop

@section('content')
    <div class="container">
        <table class="table">
            <thead class="mb-5">
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Categories</th>
                    <th>Price</th>
                    <th>Published</th>
                    <th colspan="3" class="text-center mr-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td> <img width="100px"  src="{{(isset($product->image) && !empty($product->image) ? asset('storage/'.$product->image ): 'https://gdr.one/simg/400?text='.$product->name.'')}}" />
                        </td>
                        <td>{{ $product->name}}</td>
                        <td>{{ $product->slug}}</td>
                        <td>
                            @foreach ($product->categories as $i => $cat )
                                {{ $i > 0  ? ' / ' : ''}}{{ $cat->title }}
                            @endforeach    
                        </td>
                        <td>{{ $product->price}}</td>
                        <td>{{ $product->published ==  1 ? 'Published' : 'Private Visible' }}</td>
                        

                        <div class="d-flex">
                            <td class="justify-content-around align-items-center" style="min-height: 65px"> 
                                <a href="{{route('admin.products.show',$product->id)}}"><i class="far text-primary fa-eye"></i></a>
                            </td>
                            <td class="align-items-center" style="min-height: 65px">
                                <a href="{{route('admin.products.edit',$product->id)}}"><i class="fas cursor-pointer text-warning fa-edit"></i></a>
                            </td>
                            <td class="justify-content-around align-items-center" style="min-height: 65px">
                                <form method="post" action="{{route('admin.products.destroy',$product->id)}}">
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

        {{ $products->links() }}
    </div>
@stop
