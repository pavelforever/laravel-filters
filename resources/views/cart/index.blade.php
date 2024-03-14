@extends('layout')

@section('content')
<div class="container">
    <h1>Shopping Cart</h1>
    <table id="cart" class="table table-bordered table-hover table-condensed mt-3">
        <thead>
            <tr>
                <th style="width:50%">Product</th>
                <th style="width:8%">Quantity</th>
                <th style="width:22%" class="text-center">Subtotal</th>
            </tr>
        </thead>
        <tbody>
    
            <?php $total = 0 ?>
    
            @if(session('cart'))
            @foreach(session('cart') as $id => $details)
    
            <?php $total += $details['price'] * $details['quantity'] ?>
    
            <tr>
                <td data-th="Product">
                    <div class="row">
                        <div class="col-sm-3 hidden-xs"> <img width="100px" src="{{(isset($details['image']) && !empty($details['image']) ? asset('storage/'.$details['image'] ): 'https://gdr.one/simg/400?text='.$details['name'].'')}}" />

    
                        </div>

                        <div class="col-sm-9">
                            <p class="nomargin">{{ $details['name'] }}</p>
                            <form action="{{route('cart.remove',$id)}}" method="POST">
                                @csrf

                                <button href="{{route('cart.remove',$id)}}" class="remove-from-cart cart-delete btn btn-danger" title="Delete">Remove</button>
                            </form>
                        </div>
                    </div>
                </td>
                <td data-th="Quantity">
                    <input type="number" value="{{ $details['quantity'] }}" class="form-control quantity" />
                </td>
                <td data-th="Subtotal" class="text-center">${{ $details['price'] * $details['quantity'] }}</td>
            </tr>
    
            @endforeach
            @endif
    
        </tbody>
        <tfoot>
            @if(!empty($details))
            <tr class="visible-xs">
                <td class="text-right" colspan="2"><strong>Total</strong></td>
                <td class="text-center"> ${{ $total }}</td>
            </tr>
            @else
            <tr>
                <td class="text-center" colspan="3">Your Cart is Empty.....</td>
            <tr>
                @endif
        </tfoot>
    </table>
    <div class="d-flex">

        <form method="POST" action="{{route('cart.clear')}}">
            @csrf
            <button class="btn btn-danger">Clear Cart</button>
        </form>
        <a href="{{ route('main') }}" class="btn shopping-btn">Continue Shopping</a>
        <a href="{{route('checkout')}}" class="btn btn-warning check-btn">Proceed Checkout</a>
    </div>
    
</div>
@endsection
