{{-- resources/views/admin/posts/index.blade.php --}}

@extends('adminlte::page')

@section('content_header')
    <h1 class="text-center">{{$user->name}}</h1>
@stop

@section('content')
<div class="container">

        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle" src="../../dist/img/user4-128x128.jpg" alt="User profile picture">
                </div>
                <h3 class="profile-username text-center">{{$user->name}}</h3>
                <p class="text-muted text-center">{{$user->email}}</p>
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item"><b>Created: </b> <a class="float-right">{{ $user->created_at->format('j M Y, g:i a') }}
                        @unless ($user->created_at->eq($user->updated_at))
                            <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>
                        @endunless
                    </a></li>
                  
                </ul>
                </div>
        </div>

</div>
@stop
