<link rel="stylesheet" href="{{ asset('user_assests/css/ion.rangeSlider.min.css') }}">
@extends('user.layout.app')
@section('contents')
<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                <li class="breadcrumb-item active">Shop</li>
            </ol>
        </div>
    </div>
</section>

<section class="section-6 pt-5">
    <div class="container">
        <div class="row">            
            <div class="col-md-3 sidebar">
                <div class="sub-title">
                    <h2>Categories</h3>
                </div>
                
                <div class="card">
                    <div class="card-body">
                    @if(getAllCategories()->isNotEmpty())
                    @foreach(getAllCategories() as $category)
                        <div class="accordion accordion-flush" id="accordionExample">
                            <div class="accordion-item">
                                @if($category->sub_category->isNotEmpty())
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                        {{$category->name}}
                                    </button>
                                </h2>
                                @else
                                <a href="{{route("front.shop",$category->name)}}" class="nav-item nav-link">{{$category->name}}</a>
                                @endif
                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample" style="">
                                    <div class="accordion-body">
                                        <div class="navbar-nav">
                                            @foreach($category->sub_category as $subCategory)
                                            <a href="{{route("front.shop",[$category->name,$subCategory->name])}}" class="nav-item nav-link">{{$subCategory->name}}</a>
                                            @endforeach                                           
                                        </div>
                                    </div>
                                </div>
                            </div>  
                                                
                        </div>
                   
                    @endforeach
                    @endif
                </div>
                </div>

                <div class="sub-title mt-5">
                    <h2>Brand</h3>
                </div>
                
                <div class="card">
                    <div class="card-body">
                        @if($brands->isNotEmpty())
                        @foreach($brands as $brand)
                        <div class="form-check mb-2">
                            <input {{(in_array($brand->id, $brandsArray)) ? 'checked' : ''}} class="form-check-input brand-label" type="checkbox" name="brand[]" value="{{$brand->id}}" id="brand-{{ $brand->id }}">
                            <label class="form-check-label" for="brand-{{$brand->id}}">
                                {{$brand->name}}
                            </label>
                        </div>
                        @endforeach
                        @endif
                                       
                    </div>
                </div>
              
                    {{-- <div class="card">
                        <div class="card-body">
                            <h2>Filter by Brand</h2>
                            @if($brands->isNotEmpty())
                            @foreach($brands as $brand)
                            <form method="GET" action="{{ route('front.brand',[$brand->name]) }}">
                                @csrf
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="brand[]" value="{{ $brand->id }}" id="brand-{{ $brand->id }}">
                                <label class="form-check-label" for="brand-{{ $brand->id }}">
                                    {{ $brand->name }}
                                </label>
                            </div>
                            <button type="submit">Apply Filters</button>
                            </form>
                            @endforeach
                            @endif
                        </div>
                    </div> --}}

               

                <div class="sub-title mt-5">
                    <h2>Price</h3>
                </div>
                
                <div class="card">
                    <div class="card-body">
                        <input type="text" class="js-range-slider" name="my_range" value="" />               
                    </div>
                </div>
            </div>
            <div class="col-md-9">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-end mb-4">
                            <div class="ml-2">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown">Sorting
                                        
                                    </button>
                                    {{-- <a href="{{ route('front.shop', ['sort' => 'price_low_high']) }}">Price Low to High</a>
                                    <a href="{{ route('front.shop', ['sort' => 'price_high_low']) }}">Price High to Low</a> --}}
                                    <select name="sort" id="sort" class="sort">
                                        <option value="latest" {{($sort == 'latest') ? 'selected' : '' }}>Latest</option>
                                        <option value="price_high_low" {{($sort == 'price_high_low') ? 'selected' : ''}}>Price High to Low</option>
                                        <option value="price_low_high" {{ ($sort == 'price_low_high') ? 'selected' : '' }}>Price Low to High</option>
                                    </select>
                                </div>                                    
                              
                            </div>
                        </div>
                    </div>

                    @if($products->isNotEmpty())
                    @foreach($products as $product)
                    <div class="col-md-4">
                            <div class="card product-card" style="width:300px;height:400px;">
                                <div class="product-image position-relative ">
                                    @if($product->product_image->isNotEmpty())
                                    @foreach($product->product_image as $pimages)
                                    <a href="{{route('front.product',$product->title)}}" class="product-img" style="width: 300px; height: 300px; background-image: url('{{ asset('temp/' . $pimages->image) }}'); background-size: cover;background-position: center center;"></a>
                                    @endforeach
                                    @else
                                    <a href="{{route('front.product',$product->title)}}" class="product-img"><div class="left" style="width: 300px; height: 300px; background-image: url('{{asset('user_assests/images/carousel-3-m.jpg')}}'); background-size: cover;background-position: center center;"></div></a>
                                    {{-- <a href="" class="product-img"><img class="card-img-top" src="{{asset('user_assests/images/carousel-3-m.jpg')}}" alt=""></a> --}}
                                    @endif
                                   
                                    <a class="whishlist" href="222"><i class="far fa-heart"></i></a>                            
            
                                    <div class="product-action">
                                        <a class="btn btn-dark" href="}">
                                            <i class="fa fa-shopping-cart"></i> Add To Cart
                                        </a>                            
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
                    @else
                    <div class="col-md-8">
                  
                                                   
                                <h1> No product to show </h1>
                                   
                                                                  
                </div>  
                    @endif  
                     

                    <div class="col-md-12 pt-5">
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end">
                                <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                                </li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{asset('user_assests/js/ion.rangeSlider.min.js')}}"></script>
@section('customjs')
<script>
    var slider = $(".js-range-slider").data("ionRangeSlider");
    $(".js-range-slider").ionRangeSlider({
        type: "double",
        min: 100,     
        max: 7000, 
        from: {{($priceMin)}},  
        step: 10,   
        to: {{($priceMax)}},
        skin:"round",
        max_postfix:"+",
        prefix:"$",
        onChange:function(data){
            apply_filters(data.from, data.to);
            console.log(data.to);
        }
        
    });

  

    $(".brand-label").change(function(){
        apply_filters();
    });
    $(".sort").change(function(){
        apply_filters();
    });


    function apply_filters(pricemin={{($priceMin)}}, pricemax={{($priceMax)}}){
        // var pricemin=
        // var pricemax=
        var brands=[];
        $(".brand-label").each(function(){
            if($(this).is(":checked")==true){
                brands.push($(this).val());
            }
        });
        //console.log(brands);
        var url ='{{url()->current()}}?';

        if(brands.length>0){
            url+='&brand='+brands.toString();
        }
        url += '&price_min=' + pricemin + '&price_max=' + pricemax;

        url += '&sort=' + $("#sort").val();
        window.location.href=url;
    }
    
</script>


@endsection