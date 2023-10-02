@extends('user.layout.app')
@section('contents')

<section class="section-1">
    <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="false">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <!-- <img src="images/carousel-1.jpg" class="d-block w-100" alt=""> -->

                <picture>
                    <source media="(max-width: 799px)" srcset="{{asset('user_assests/images/carousel-1-m.jpg')}}" />
                    <source media="(min-width: 800px)" srcset="{{asset('user_assests/images/carousel-1.jpg')}}" />
                    <img src="{{asset('user_assests/images/carousel-1.jpg')}}" alt="" />
                </picture>

                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3">
                        <h1 class="display-4 text-white mb-3">Kids Fashion</h1>
                        <p class="mx-md-5 px-5">Lorem rebum magna amet lorem magna erat diam stet. Sadips duo stet amet amet ndiam elitr ipsum diam</p>
                        <a class="btn btn-outline-light py-2 px-4 mt-3" href="#">Shop Now</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                
                <picture>
                    <source media="(max-width: 799px)" srcset="{{asset('user_assests/images/carousel-2-m.jpg')}}" />
                    <source media="(min-width: 800px)" srcset="{{asset('user_assests/images/carousel-2.jpg')}}" />
                    <img src="{{asset('user_assests/images/carousel-2.jpg')}}" alt="" />
                </picture>

                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3">
                        <h1 class="display-4 text-white mb-3">Womens Fashion</h1>
                        <p class="mx-md-5 px-5">Lorem rebum magna amet lorem magna erat diam stet. Sadips duo stet amet amet ndiam elitr ipsum diam</p>
                        <a class="btn btn-outline-light py-2 px-4 mt-3" href="#">Shop Now</a>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <!-- <img src="images/carousel-3.jpg" class="d-block w-100" alt=""> -->

                <picture>
                    <source media="(max-width: 799px)" srcset="{{asset('user_assests/images/carousel-3-m.jpg')}}" />
                    <source media="(min-width: 800px)" srcset="{{asset('user_assests/images/carousel-3.jpg')}}" />
                    <img src="{{asset('user_assests/images/carousel-2.jpg')}}" alt="" />
                </picture>

                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                    <div class="p-3">
                        <h1 class="display-4 text-white mb-3">Shop Online at Flat 70% off on Branded Clothes</h1>
                        <p class="mx-md-5 px-5">Lorem rebum magna amet lorem magna erat diam stet. Sadips duo stet amet amet ndiam elitr ipsum diam</p>
                        <a class="btn btn-outline-light py-2 px-4 mt-3" href="#">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>
<section class="section-2">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="box shadow-lg">
                    <div class="fa icon fa-check text-primary m-0 mr-3"></div>
                    <h2 class="font-weight-semi-bold m-0">Quality Product</h5>
                </div>                    
            </div>
            <div class="col-lg-3 ">
                <div class="box shadow-lg">
                    <div class="fa icon fa-shipping-fast text-primary m-0 mr-3"></div>
                    <h2 class="font-weight-semi-bold m-0">Free Shipping</h2>
                </div>                    
            </div>
            <div class="col-lg-3">
                <div class="box shadow-lg">
                    <div class="fa icon fa-exchange-alt text-primary m-0 mr-3"></div>
                    <h2 class="font-weight-semi-bold m-0">14-Day Return</h2>
                </div>                    
            </div>
            <div class="col-lg-3 ">
                <div class="box shadow-lg">
                    <div class="fa icon fa-phone-volume text-primary m-0 mr-3"></div>
                    <h2 class="font-weight-semi-bold m-0">24/7 Support</h5>
                </div>                    
            </div>
        </div>
    </div>
</section>
<section class="section-3">
    <div class="container">
        <div class="section-title">
            <h2>Categories</h2>
        </div>           
        <div class="row pb-3">
            @if(getAllCategories()->isNotEmpty())
                @foreach(getAllCategories() as $category)
                    <div class="col-lg-3">
                        <div class="cat-card">
                            <div class="left" style="width: 200px; height: 200px; background-image: url('{{ asset('images/' . $category->image) }}'); background-size: cover;"></div>
                            <div class="right">
                                <div class="cat-data">
                                    <h2>{{$category->name}}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>

<section class="section-4 pt-5">
    <div class="container">
        <div class="section-title">
            <h2>Featured Products</h2>
        </div> 
        <div class="row pb-3">
        @if(getProduct()->isNotEmpty())
        @foreach(getProduct() as $product)      
            <div class="col-md-3">
                <div class="card product-card" style="width:300px;height:400px;">
                    <a href="" class="product-image position-relative">
                        @if($product->product_image->isNotEmpty())
                           @foreach($product->product_image as $pimages)
                           <a href="{{route('front.product',$product->title)}}" class="product-img"><div class="left" style="width: 300px; height: 200px; background-image: url('{{ asset('temp/' . $pimages->image) }}'); background-size: cover;"></div></a>
                           @endforeach
                       @endif
                        <a class="whishlist" href="222"><i class="far fa-heart"></i></a>                            

                        <div class="product-action">
                          
                                <button onclick="addToCart({{ $product->id }})" data-add-to-cart-url="{{ route('user.addtocart') }}" class="btn btn-dark"><i class="fas fa-shopping-cart"></i>>Add to cart</button>
                                                  
                        </div>
                    </a>                        
                    <div class="card-body text-center mt-3">
                        <a class="h6 link" href="product.php">{{$product->title}}</a>
                        <div class="price mt-2">
                            <span class="h5"><strong>{{$product->price}}</strong></span>
                            @if($product->compare_price>0)
                            <span class="h6 text-underline"><del>{{$product->compare_price}}</del></span>
                            @endif
                        </div>
                    </div>                        
                </div>                                               
            </div>  
  
        @endforeach
        @endif
        </div>

    </div>
</section>

<section class="section-4 pt-5">
    <div class="container">
        <div class="section-title">
            <h2>Latest Products</h2>
        </div>    
        <div class="row pb-3">
            @if(getAllProduct()->isNotEmpty())
            @foreach(getAllProduct() as $product)
            <div class="col-md-3">
                <div class="card product-card" style="width:300px;height:400px;">
                    <div class="product-image ">
                        @if($product->product_image->isNotEmpty())
                        @foreach($product->product_image as $pimages)
                        <a href="{{route('front.product',$product->title)}}" class="product-img" style="width: 300px; height: 200px; background-image: url('{{ asset('temp/' . $pimages->image) }}'); background-size: cover;background-position: center center;"></a>
                        @endforeach
                        @else
                        <a href="{{route('front.product',$product->title)}}" class="product-img"><div class="left" style="width: 200px; height: 200px; background-image: url('{{asset('user_assests/images/carousel-3-m.jpg')}}'); background-size: cover;background-position: center center;"></div></a>
                        {{-- <a href="" class="product-img"><img class="card-img-top" src="{{asset('user_assests/images/carousel-3-m.jpg')}}" alt=""></a> --}}
                        @endif
                       
                        <a class="whishlist" href="222"><i class="far fa-heart"></i></a>                            

                        <div class="product-action">
                            <button onclick="addToCart({{ $product->id }})" data-add-to-cart-url="{{ route('user.addtocart') }}" class="btn btn-dark"><i class="fas fa-shopping-cart"></i>>Add to cart</button>                           
                        </div>
                    </div>                        
                    <div class="card-body text-center mt-3">
                        <a class="h6 link" href="product.php">{{$product->title}}</a>
                        <div class="price mt-2">
                            <span class="h5"><strong>{{$product->price}}</strong></span>
                            @if($product->compare_price>0)
                            <span class="h6 text-underline"><del>{{$product->compare_price}}</del></span>
                            @endif
                        </div>
                    </div>                        
                </div>                                               
            </div> 
            @endforeach
            @endif 
           
        </div>
    </div>
</section>
@endsection