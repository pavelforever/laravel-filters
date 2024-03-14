@extends('layout')

@section('header')
<div  class="p-5  text-center bg-light">
  <h1 class="mb-3 h2">Shop</h1>
</div>
@endsection

@if (session('paymentError'))
<div class="alert alert-danger">
   {{session('PaymentError')}}
</div>
@endif

@section('content')
<div class="container">
    <div class="row">
      <div class="row">
          @foreach ($products as $product )
          <div class="col-lg-4 col-md-12 mb-4">
            
            <div class="card">
              <div class="bg-image hover-zoom ripple ripple-surface ripple-surface-light"
                data-mdb-ripple-color="light">
                <img src="{{(isset($product->image) && !empty($product->image) ? asset('storage/'.$product->image ): 'https://gdr.one/simg/400?text='.$product->name.'')}}"
                  class="w-100" />
                <a href="#!">
                  <div class="mask">
                    <div class="d-flex justify-content-start align-items-end h-100">
                      {{-- <h5><span class="badge bg-primary ms-2">New</span></h5> --}}
                    </div>
                  </div>
                  <div class="hover-overlay">
                    <div class="mask" style="background-color: rgba(251, 251, 251, 0.15);"></div>
                  </div>
                </a>
              </div>
              <div class="card-body">
                <a href="" class="text-reset">
                  <h5 class="card-title mb-3">{{$product->name}}</h5>
                </a>
                <a href="" class="text-reset">
                  <p>
                  @foreach ($product->categories as $i => $cat )
                    {{ $i > 0  ? ' / ' : ''}}{{ $cat->title }}
                  @endforeach   
                  </p>
                </a>
                <h6 class="mb-3">{{$product->price}} UAH</h6>
              </div>
              <a href="javascript:void(0);" data-product-id="{{ $product->id }}" id="add-cart-btn-{{ $product->id }}" 
                class="btn btn-warning btn-block text-center add-cart-btn add-to-cart-button">Add to cart</a>
              <span
                id="adding-cart-{{ $product->id }}"
                class="btn btn-warning btn-block text-center added-msg"
                style="display: none"
                >Added.</span>
            </div>
          </div>
          @endforeach
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    $('.add-to-cart-button').on('click', function () {
        var productId = $(this).data('product-id');

        $.ajax({
            type: 'POST',
            url: '/cart/add/' + productId,
            success: function (data) {
                $("#adding-cart-" + productId).show();
                $("#add-cart-btn-" + productId).hide();
            },
            data: {
                _token: '{{ csrf_token() }}',
            },
            error: function (error) {
                console.error('Error adding to cart:', error);
            }
        });
    });
});

</script>
@show