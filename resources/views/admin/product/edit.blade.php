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
<div class="login-dark pt-5 px-auto pb-5">
    <div class="container">

    
    <form method="POST" action="{{route('admin.products.update',$product->id)}}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <h3 class="text-center">New Product</h3>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Product Name" value="{{old('name',$product->name)}}"  name="name"/>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Product Description"  value="{{old('name',$product->description)}}"  name="description"/>
        </div>
        <div class="form-group">
            <input type="number" class="form-control" placeholder="Product Price"  value="{{old('name',$product->price)}}"  name="price"/>
        </div>
        <div class="form-group">
          <label for="status_select">Select Publish Status:</label>
          <select class="form-control" id="status_select" name="published">
            <option value="1" {{ old('published', $product->published) == true ? 'selected' : '' }}>Published</option>
            <option value="0" {{ old('published', $product->published) == false ? 'selected ' : '' }}>Published Privatly</option>
          </select>
      </div>
      
      <div class="form-group">
        <label for="image">Add Product Image</label>
        <div class="input-group">
           <div class="custom-file">
              <input type="file" class="custom-file-input" style="cursor: pointer;" name="image" value="{{old('image')}}" id="image">
              <label class="custom-file-label" style="cursor: pointer;" for="image">Choose Image</label>
           </div>
        </div>
     </div>
     
        <div class="form-group">
          <label for="fileName">Add Product File</label>
          <div class="input-group">
              <div class="custom-file">
                <input type="file" class="custom-file-input" style="cursor: pointer;" name="fileName" value="{{old('fileName',$product->fileName)}}" id="fileName">
                <label class="custom-file-label" style="cursor: pointer;" for="fileName">Choose File</label>
              </div>
          </div>
        </div>
        
        <div class="form-group">
          <label for="products_category">Select Categories</label>
          <select class="select2" id="products_category" multiple="multiple" name="category_ids[]" style="width:100%">
              @foreach($category as $cat)
                <option value="{{$cat->id}}" {{is_array('category_ids') && in_array($cat->id,old('category_ids')) ? 'selected' : ''}}>{{$cat->title}}</option>
              @endforeach
          </select>
        </div>
        <div class="form-group"><button class="btn btn-primary btn-block" type="submit">Edit</button></div>
    
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