<link rel="stylesheet" href="{{ asset('user_assests/css/ion.rangeSlider.min.css') }}">
@extends('user.layout.app')
@section('contents')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                <li class="breadcrumb-item"><a class="white-text" href="#">Shop</a></li>
                <li class="breadcrumb-item">Cart</li>
            </ol>
        </div>
    </div>
</section>

<section class=" section-9 pt-4">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="table-responsive">
                    <table class="table" id="cart">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $subtotal = 0;
                            @endphp
                            @if(!empty($cartContent))
                            @foreach($cartContent as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if(!empty($item->options->productImage->image->isNotEmpty))
                                
                                        <a href="" class="product-img" style="width: 80px; height: 80px; background-image: url('{{ asset('temp/' . $item->options->productImage->image) }}'); background-size: cover;background-position: center center;"></a>
                                        
                                        {{-- @else
                                        <a href="" class="product-img"><div class="left" style="width: 80px; height: 80px; background-image: url('{{asset('user_assests/images/carousel-3-m.jpg')}}'); background-size: cover;background-position: center center;"></div></a> --}}
                                        {{-- <a href="" class="product-img"><img class="card-img-top" src="{{asset('user_assests/images/carousel-3-m.jpg')}}" alt=""></a> --}}
                                        @endif


                                        <h2>{{$item->name}}</h2>
                                    </div>
                                </td>
                                <td>{{$item->price}}</td>
                                <td>
                                    <div class="input-group quantity mx-auto" style="width: 100px;">
                                        <div class="quantity">
                                            <button class="btn btn-sm btn-dark btn-minus p-2 pt-1 pb-1 sub" data-id="{{$item->rowId}}">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" class="form-control form-control-sm border-0 text-center quantity-input" value="{{$item->qty}}">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-dark btn-plus p-2 pt-1 pb-1 add" data-id="{{$item->rowId}}">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    {{$item->price*$item->qty}}
                                </td>
                                @php
                                
                                $subtotal += ($item->price * $item->qty);;
                                @endphp
                                <td>
                                    {{-- <button class="btn btn-sm btn-danger" onclick="deleteCart('{{$item->rowId}}'');"><i class="fa fa-times"></i></button> --}}
                                    <button class="btn btn-sm btn-danger" onclick="deleteCart('{{$item->rowId}}');"><i class="fa fa-times"></i></button>

                                </td>
                            </tr>
                            @endforeach
                            @else
                            <div class="d-flex align-items-center">
                                <tr>
                                    <td>
                                        <h1> Nothing on cart </h1>
                                    </td>
                                </tr>
                            </div>
                            @endif
                                
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-4">            
                <div class="card cart-summery">
                    <div class="sub-title">
                        <h2 class="bg-white">Cart Summery</h3>
                    </div> 
                    <div class="card-body">
                        <div class="d-flex justify-content-between pb-2">
                            <div>Subtotal</div>

                            <div>{{ $subtotal }}</div>
                            
                        </div>
                        <div class="d-flex justify-content-between pb-2">
                            <div>Shipping</div>
                            <div>$0</div>
                        </div>
                        <div class="d-flex justify-content-between summery-end">
                            <div>Total</div>
                            <div>{{$subtotal}}</div>
                        </div>
                        <div class="pt-5">
                            <a href="login.php" class="btn-dark btn btn-block w-100">Proceed to Checkout</a>
                        </div>
                    </div>
                </div>     
                <div class="input-group apply-coupan mt-4">
                    <input type="text" placeholder="Coupon Code" class="form-control">
                    <button class="btn btn-dark" type="button" id="button-addon2">Apply Coupon</button>
                </div> 
            </div>
        </div>
    </div>
</section>
@endsection
@section('customjs')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$.ajaxSetup({
    headers: {
    "X-CSRF-Token": $('meta[name="csrf-token"]').attr('content')
  }
});
function updateCart(rowId, qty) {
    $.ajax({
        url:  "{{ route('user.updatecart') }}",
        type: 'post',
        data: { rowId:rowId, qty:qty},
        dataType: 'json',
        success: function(response) {
            if (response.status === true) {
                window.location.href = "{{ route('user.cart') }}";
                // alert(' Cart updated successfully');
            } else {
                alert(response.message);
                window.location.href = "{{ route('user.cart') }}";
            }
        },
        error: function(xhr, status, error) {
            alert('An error occurred while adding the product to the cart.');
        }
    });
}

function deleteCart(rowId) {
    if(confirm("Are you sure want to delete ?")){
        $.ajax({
        url:  "{{ route('user.deletecart') }}",
        type: 'post',
        data: { rowId:rowId},
        dataType: 'json',
        success: function(response) {
            if (response.status === true) {
                window.location.href = "{{ route('user.cart') }}";
            } else {
                alert(response.message);
                window.location.href = "{{ route('user.cart') }}";
            }
        },
    });
    }
}


    $(document).on('click', '.add', function () {
    var quantity = $(this).parent().prev();
    var qtyValue = parseInt(quantity.val());
    if (qtyValue < 10) {
        var rowId=$(this).data('id');
        quantity.val(qtyValue + 1);
        var newQty=quantity.val();
        updateCart(rowId, newQty)
    }
    });

    $(document).on('click', '.sub', function () {
    var quantity = $(this).parent().next();
    var qtyValue = parseInt(quantity.val());
    if (qtyValue > 1) {
        var rowId=$(this).data('id');
        quantity.val(qtyValue - 1);
        var newQty=quantity.val();
        updateCart(rowId, newQty)
    }
    });

</script>
@endsection