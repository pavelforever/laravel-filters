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
                    <th class="border-right text-center border-left">Email</th>
                    <th class="border-right text-center">ID</th>
                    <th class="border-right text-center">Name</th>
                    <th class="border-right text-center">Role</th>
                    <th class="border-right text-center">Deleted At</th>
                    <th class="border-right text-center">Actions</th>

                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td class="text-center">{{ $user->id }}</td>
                        <td class="text-center">{{ $user->email }}</td>
                        <td class="text-center">{{ $user->name }}</td>
                        <td class="text-center">
                            <div class="mr-1 rounded-lg {{$user->role ? 'bg-primary' : 'bg-danger'}} p-1 text-center">
                                <h5>{{ App\Models\User::getRoles()[$user->role] }}</h5>
                            </div>
                        </td>
                        <td class="text-center">{{ $user->deleted_at }}</td>
                        
                        <td class="d-flex justify-content-around align-items-center text-center" style="min-height: 65px"> 
                            <form action="{{route('admin.users.restore.restore',$user->id)}}" method="POST">
                                @csrf
                                <button type="submit" class="bg-transparent border-0">Restore&nbsp;&nbsp;<i class="fa text-primary fa-undo"></i></button>
                            </form>
                        </td>
                    </tr>
                   
                @endforeach
            </tbody>
        </table>
    </div>
@stop
