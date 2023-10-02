<meta name="csrf-token" content="{{csrf_token()}}">
@extends('user.layout.app')
@section('contents')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="{{route('front.index')}}">Home</a></li>
                <li class="breadcrumb-item"><a class="white-text" href="{{route('front.shop')}}">Shop</a></li>
                <li class="breadcrumb-item">{{$product->title}}</li>
            </ol>
        </div>
    </div>
</section>

<section class="section-7 pt-3 mb-3">
    <div class="container">
        <div class="row ">
            <div class="col-md-5">
                <div id="product-carousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner bg-light">
                        @if($product->product_image->isNotEmpty())
                        @foreach($product->product_image as $key=> $pimages)
                        <div class="carousel-item {{($key==0) ? 'active' : ''}}">
                            <a href="" class="product-img"><div class="left" style="width: 400px; height: 400px; background-image: url('{{ asset('temp/' . $pimages->image) }}'); background-size: cover;"></div></a>
                        </div>
                       
                        @endforeach
                    @endif
                    </div>
                    <a class="carousel-control-prev" href="#product-carousel" data-bs-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" data-bs-slide="next">
                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-7">
                <div class="bg-light right">
                    <h1>{{$product->title}}</h1>
                    <div class="d-flex mb-3">
                        <div class="text-primary mr-2">
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star"></small>
                            <small class="fas fa-star-half-alt"></small>
                            <small class="far fa-star"></small>
                        </div>
                        <small class="pt-1">(99 Reviews)</small>
                    </div>
                    @if($product->compare_price >0)
                        <h2 class="price text-secondary"><del>{{$product->compare_price}}</del></h2>
                    @endif
                        <h2 class="price ">{{$product->price}}</h2>

                    <p>{{ $product->description }}</p>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Perferendis officiis dolor aut nihil iste porro ullam repellendus inventore voluptatem nam veritatis exercitationem doloribus voluptates dolorem nobis voluptatum qui, minus facere.</p>
                    {{-- <a href="javascript:void(0);" onclick="addToCart({{$product->id}});" class="btn btn-dark"><i class="fas fa-shopping-cart"></i> &nbsp;ADD TO CART</a> --}}
                    {{-- <a href="javascript:void(0);" onclick="addToCart({{ $product->id }});" class="btn btn-dark"><i class="fas fa-shopping-cart"></i> &nbsp;ADD TO CART</a> --}}
                    
                    <button onclick="addToCart({{ $product->id }})" data-add-to-cart-url="{{ route('user.addtocart') }}" class="btn btn-dark"><i class="fas fa-shopping-cart"></i>>Add to cart</button>
                </div>
            </div>

            <div class="col-md-12 mt-5">
                <div class="bg-light">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">Description</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="shipping-tab" data-bs-toggle="tab" data-bs-target="#shipping" type="button" role="tab" aria-controls="shipping" aria-selected="false">Shipping & Returns</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">Reviews</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                            <p>
                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sit, incidunt blanditiis suscipit quidem magnam doloribus earum hic exercitationem. Distinctio dicta veritatis alias delectus quaerat, quam sint ab nulla aperiam commodi. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sit, incidunt blanditiis suscipit quidem magnam doloribus earum hic exercitationem. Distinctio dicta veritatis alias delectus quaerat, quam sint ab nulla aperiam commodi. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sit, incidunt blanditiis suscipit quidem magnam doloribus earum hic exercitationem. Distinctio dicta veritatis alias delectus quaerat, quam sint ab nulla aperiam commodi.
                            </p>
                        </div>
                        <div class="tab-pane fade" id="shipping" role="tabpanel" aria-labelledby="shipping-tab">
                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sit, incidunt blanditiis suscipit quidem magnam doloribus earum hic exercitationem. Distinctio dicta veritatis alias delectus quaerat, quam sint ab nulla aperiam commodi. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sit, incidunt blanditiis suscipit quidem magnam doloribus earum hic exercitationem. Distinctio dicta veritatis alias delectus quaerat, quam sint ab nulla aperiam commodi. Lorem, ipsum dolor sit amet consectetur adipisicing elit. Sit, incidunt blanditiis suscipit quidem magnam doloribus earum hic exercitationem. Distinctio dicta veritatis alias delectus quaerat, quam sint ab nulla aperiam commodi.</p>
                        </div>
                        <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        
                        </div>
                    </div>
                </div>
            </div> 
        </div>           
    </div>
</section>


@endsection
@section('customjs')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
$.ajaxSetup({
    headers: {
    "X-CSRF-Token": $('meta[name="csrf-token"]').attr('content')
  }
});
  function addToCart(id) {
    var addToCartUrl = $('button[onclick*="addToCart("]').data('add-to-cart-url');

    $.ajax({
        url: addToCartUrl,
        type: 'post',
        data: { id: id },
        dataType: 'json',
        success: function(response) {
            if (response.status === true) {
                window.location.href = "{{ route('user.cart') }}";
                alert('Product added to cart successfully');
            } else {
                alert('Product could not be added to cart. ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            alert('An error occurred while adding the product to the cart.');
        }
    });
}

</script>
@endsection