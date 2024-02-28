{{-- resources/views/admin/posts/index.blade.php --}}

@extends('adminlte::page')

@section('content')
<div class="container d-flex" style="gap: 40px; overflow: scroll;padding-top: 5em">
  <div class="card" style="height: 500px; overflow-y: auto;">
    <h5 class="card-header">With Main Image</h5>
    <div class="card-body">
      <img class="card-img" src="{{asset('storage/'.$post->image)}}"/>
      <p class="card-title">{{$post->title}}</p>
      <p class="card-text">{{$post->message}}</p>
    </div>
  </div>
  <div class="card" style="height: 500px; overflow-y: auto;">
    <h5 class="card-header">With Preview Image</h5>
    <div class="card-body">
      <img class="card-img" src="{{asset('storage/'.$post->imagePreview)}}"/>
      <p class="card-title">{{$post->title}}</p>
      <p class="card-text">{{$post->message}}</p>
    </div>
  </div>
</div>
@stop

<style>
/* Your existing styles here */
</style>
