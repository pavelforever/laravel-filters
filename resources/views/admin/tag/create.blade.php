
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
  <div class="container" style="display: flex;width: 100%;height: 100%;justify-content: center;align-items: center;min-width: 400px !important;min-height: 400px !important;">
    <div class="login-dark">
        <form method="POST" action="{{route('admin.tags.store')}}">
            @csrf
            @method('POST')
            <h3 class="text-center">New Tag</h3>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Tag Title"  name="title"/>
            </div>
            <div class="form-group"><button class="btn btn-primary btn-block" type="submit">Create</button></div>
        </form>
    </div>
  </div>

@stop

<style>

    .login-dark form {
        width:90%;
        background-color:#fff;
        padding:40px;
        border-radius:4px;
        color:#1e2833;
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