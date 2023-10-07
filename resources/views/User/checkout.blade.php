@extends('User.layout.app')
@section('contents')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="#">Shop</a></li>
                    <li class="breadcrumb-item">Checkout</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-9 pt-4">
        <div class="container">
        <form action="{{route('orders.store')}}" method="post" name="Orderform" id="Orderform">
                @csrf
            <div class="row">
                <div class="col-md-8">
                    <div class="sub-title">
                        <h2>Shipping Address</h2>
                    </div>
                    <div class="card shadow-lg border-0">
                        <div class="card-body checkout-form">
                            <div class="row">
                                
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" value="{{old('first_name')}}" name="first_name" id="first_name" class="form-control @error('first_name') is-invalid @enderror" placeholder="First Name">
                                        @error('first_name')
                                        <p class="invalid-feedback">{{$message}}</p>
                                        @enderror
                                    </div>            
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" value="{{old('last_name')}}" name="last_name" id="last_name" class="form-control @error('last_name') is-invalid @enderror" placeholder="Last Name">
                                        @error('last_name')
                                        <p class="invalid-feedback">{{$message}}</p>
                                        @enderror
                                    </div>            
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" value="{{old('email')}}" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email">
                                         @error('email')
                                        <p class="invalid-feedback">{{$message}}</p>
                                        @enderror
                                    </div>            
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <select name="country" value="{{old('country')}}" id="country" class="form-control @error('country') is-invalid @enderror">
                                            <option value="">Select a Country</option>
                                            <option value="1">India</option>
                                            <option value="2">Nepal</option>
                                        </select>
                                        @error('country')
                                        <p class="invalid-feedback">{{$message}}</p>
                                        @enderror
                                    </div>            
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <textarea name="address" value="{{old('address')}}" id="address" cols="30" rows="3" placeholder="Address" class="form-control @error('address') is-invalid @enderror"></textarea>
                                    </div>  
                                    @error('address')
                                    <p class="invalid-feedback">{{$message}}</p>
                                    @enderror          
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="text" value="{{old('apartment')}}" name="appartment" id="appartment" class="form-control" placeholder="Apartment, suite, unit, etc. (optional)">
                                    </div>  
                
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" value="{{old('city')}}" name="city" id="city" class="form-control @error('city') is-invalid @enderror" placeholder="City">
                                    </div> 
                                    @error('city')
                                    <p class="invalid-feedback">{{$message}}</p>
                                    @enderror           
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" value="{{old('state')}}" name="state" id="state" class="form-control @error('state') is-invalid @enderror" placeholder="State">
                                    </div> 
                                    @error('state')
                                    <p class="invalid-feedback">{{$message}}</p>
                                    @enderror           
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <input type="text" value="{{old('zip')}}" name="zip" id="zip" class="form-control @error('zip') is-invalid @enderror" placeholder="Zip">
                                    </div> 
                                    @error('zip')
                                    <p class="invalid-feedback">{{$message}}</p>
                                    @enderror           
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <input type="tel" value="{{old('mobile')}}" name="mobile" id="mobile" class="form-control @error('mobile') is-invalid @enderror" placeholder="Mobile No.">
                                    </div> 
                                    @error('mobile')
                                    <p class="invalid-feedback">{{$message}}</p>
                                    @enderror           
                                </div>
                                

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <textarea name="order_notes" value="{{old('order_note')}}" id="order_notes" cols="30" rows="2" placeholder="Order Notes (optional)" class="form-control"></textarea>
                                    </div>          
                                </div>

                            </div>
                        </div>
                    </div>    
                </div>
                <div class="col-md-4">
                    <div class="sub-title">
                        <h2>Order Summery</h3>
                    </div> 
                    @php
                    $subtotal = 0;
                    @endphp                   
                    <div class="card cart-summery">
                        <div class="card-body">
                            @foreach( $cartContent as $items)
                            <div class="d-flex justify-content-between pb-2">
                                <div class="h6">{{$items->name}} X {{$items->qty}}</div>
                                <div class="h6"> {{$items->price*$items->qty}}</div>
                            </div>
                            @php
                            $subtotal += ($items->price * $items->qty);;
                            @endphp
                            @endforeach    
                           
                            <div class="d-flex justify-content-between summery-end">
                                <div class="h6"><strong>Subtotal</strong></div>
                                <div class="h6" id="subtotal"><strong>{{$subtotal}}</strong></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <div class="h6"><strong>Shipping</strong></div>
                                <div class="h6" id="shipping"><strong>$0</strong></div>
                            </div>
                            <div class="d-flex justify-content-between mt-2 summery-end">
                                <div class="h5"><strong>Total</strong></div>
                                <div class="h5" id="total"><strong>{{$subtotal}}</strong></div>
                            </div>                            
                        </div>
                         
                    </div>   
                    
                    <div class="card payment-form ">                        
                        <h3 class="card-title h5 mb-3">Payment Details</h3>
                        <div class="card-body p-0">
                            <div class="mb-3">
                                <label for="payment_method" class="mb-2">Payment Method</label>
                                <select id="payment_method" name="payment_method" onchange="toggleCardFields()">
                                    <option value="cash" id='cod' name='cod'>Cash on Delivery</option>
                                    <option value="card">Card Payment</option>
                                </select>
                            </div>
                            <div class="mb-3" id="card_fields" style="display: none;">
                                <label for="card_number" class="mb-2">Card Number</label>
                                <input type="text" name="card_number" id="card_number" placeholder="Valid Card Number" class="form-control @error('category') is-invalid @enderror">
                                <div class="col-md-6">
                                    <label for="expiry_date" class="mb-2">Expiry Date</label>
                                    <input type="text" name="expiry_date" id="expiry_date" placeholder="MM/YYYY" class="form-control @error('category') is-invalid @enderror">
                                </div>
                                <div class="col-md-6">
                                    <label for="cvv_code" class="mb-2">CVV Code</label>
                                    <input type="text" name="cvv_code" id="cvv_code" placeholder="123" class="form-control @error('category') is-invalid @enderror">
                                </div>
                            </div>
                            
                               
                                
                            </div>
                            <div class="pt-4">
                                <button type="submit" class="btn-dark btn btn-block w-100">Pay Now</a>
                            </div>
                        </div>                        
                    </div>         
                    <!-- CREDIT CARD FORM ENDS HERE -->
                    
                </div>
            </div>
        </form>
        </div>
    </section>
</main>
@endsection

<script>
    function toggleCardFields() {
        var paymentMethod = document.getElementById("payment_method").value;
        var cardFields = document.getElementById("card_fields");

        if (paymentMethod === "card") {
            cardFields.style.display = "block";
        } else {
            cardFields.style.display = "none";
        }
    }
</script>