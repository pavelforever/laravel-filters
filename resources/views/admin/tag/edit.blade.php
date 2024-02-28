@extends('adminlte::page')
@section('content')
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="login-dark">
    <form method="POST" action="{{route('admin.tags.update',$tag->id)}}">
        @csrf
        @method('PATCH')
        <h3 class="text-center">Editing {{$tag->title }} Tag</h3>
        <div class="form-group">
            <div class="illustration"><i class="icon ion-ios-locked-outline"></i></div>
            <input type="text" class="form-control" value="{{old('title',$tag->title)}}" name="title"/>
        </div>
        <div class="form-group"><button class="btn btn-primary btn-block" type="submit">Edit</button></div>
    </form>
</div>
@stop

<style>

    .login-dark form {
        max-width:320px;
        width:90%;
        background-color:#1e2833;
        padding:40px;
        border-radius:4px;
        transform:translate(-50%, -50%);
        position:absolute;
        top:50%;
        left:50%;
        color:#fff;
        box-shadow:3px 3px 4px rgba(0,0,0,0.2);
    }
    .login-dark .illustration {
      text-align:center;
      padding:15px 0 20px;
      font-size:100px;
      color:#2980ef;
    }
    
    .login-dark form .form-control {
      background:none;
      border:none;
      border-bottom:1px solid #434a52;
      border-radius:0;
      box-shadow:none;
      outline:none;
      color:inherit;
    }
    .login-dark form select {
        width: 100%;
        background: transparent;
        border: 0;
        border-bottom: 1px solid #434a52;
        color: #fff;
        padding-left: 14px;
    }

    .login-dark form .btn-primary {
      background:#214a80;
      border:none;
      border-radius:4px;
      padding:11px;
      box-shadow:none;
      margin-top:26px;
      text-shadow:none;
      outline:none;
    }
    
    .login-dark form .btn-primary:hover, .login-dark form .btn-primary:active {
      background:#214a80;
      outline:none;
    }
    


    .login-dark form .btn-primary:active {
      transform:translateY(1px);
    }
    
    
    
    </style>