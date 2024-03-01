{{-- resources/views/admin/posts/index.blade.php --}}

@extends('adminlte::page')

@section('content_header')
    <h1 class="text-center mb-5">Users</h1>
@stop

@section('content')
    <div class="container">
        <table class="table">
            <thead class="mb-5">
                <tr>
                    <th class="border-bottom-0">ID</th>
                    <th class="border-bottom-0">Email</th>
                    <th class="border-bottom-0">Name</th>
                    <th class="border-bottom-0">Role</th>
                    <th class="text-center border-bottom-0 pl-0">Actions</th>
                    <th></th>

                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->name }}</td>
                        <td>
                            <div class="mr-1 rounded-lg {{$user->role ? 'bg-primary' : 'bg-danger'}} p-1 text-center">
                                <h5>{{ App\Models\User::getRoles()[$user->role] }}</h5>
                            </div>
                        </td>
                        
                        <td class="d-flex justify-content-around align-items-center" style="min-height: 65px"> 
                            <a href="{{route('admin.users.show',$user->id)}}"><i class="far text-primary fa-eye"></i></a>

                            <a href="{{route('admin.users.edit',$user->id)}}"><i class="fas cursor-pointer text-warning fa-edit"></i></a>


                            <form method="post" action="{{route('admin.users.destroy',$user->id)}}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-transparent text-center border-0"><i class="fas text-danger fa-trash mr-2"></i></button>
                            </form>
                        </td>
                        <td>
                            
                        </td>
                    </tr>
                   
                @endforeach
            </tbody>
        </table>

        {{ $users->links() }}
    </div>
@stop
