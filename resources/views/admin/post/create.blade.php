
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
        <form method="POST" action="{{route('admin.posts.store')}}" enctype="multipart/form-data">
            @csrf

            <h3 class="text-center">New Post</h3>
            <div class="form-group">
              <input type="text" class="form-control" placeholder="Post Title" value="{{old('title')}}"  name="title"/>
            </div>
            <div class="form-group">
              <textarea  class="form-control" placeholder="Post Content" value="{{old('message')}}"  name="message"></textarea>  
            </div>
            <div class="form-group">
              <label for="mainImage">Add Main Image</label>
              
              <div class="input-group">
                 <div class="custom-file">
                    <input type="file" class="custom-file-input" style="cursor: pointer;" name="image" id="mainImage">
                    <label class="custom-file-label" style="cursor: pointer;" for="mainImage">Choose Image</label>
                 </div>
              </div>
           </div>
            <div class="form-group">
              <label for="imagePreview">Add Preview Image</label>
              <div class="input-group">
                 <div class="custom-file">
                    <input type="file" class="custom-file-input" style="cursor: pointer;" name="imagePreview" value="{{old('imagePreview')}}" id="imagePreview">
                    <label class="custom-file-label" style="cursor: pointer;" for="imagePreview">Choose Image</label>
                 </div>
              </div>
           </div>
           <div class="form-group">
              <label for="category_select" >Select Category</label>
              <select  class="form-control" name="category_id" id="category_select">
                <option value=''>None</option>
                @foreach($category as $cat)
                    <option class="form-control" value="{{$cat->id}}" {{$cat->id == old('category_id') ? 'selected' : ''}} >{{$cat->title}}</option>
                @endforeach
              </select>
           </div>
            <div class="form-group">
                <select class="select2" multiple="multiple" name="tag_ids[]" style="width:100%">
                    @foreach($tags as $tag)
                      <option value="{{$tag->id}}" {{is_array('tag_ids') && in_array($tag->id,old('tag_ids')) ? 'selected' : ''}}>{{$tag->title}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group"><button class="btn btn-primary btn-block" type="submit">Create</button></div>
        </form>
    </div>
  </div>

@stop
@push('scripts')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> 
  <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
  <script>
    jQuery(document).ready(function($) {
        // Initialize Select2
        $('.select2').select2({
          width: 'resolve'
        });

        // Initialize bsCustomFileInput after Select2
        bsCustomFileInput.init()
    });
  </script>
@show
<style>
  .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
    background: transparent
  }
  .select2-container--default .select2-selection--multiple .select2-selection__choice__display{
    padding-left: 20px;
  }
.select2-container--default .select2-search--inline .select2-search__field {
  border: 0 !important;
}
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
    
@section('image-upload')
  
@show 