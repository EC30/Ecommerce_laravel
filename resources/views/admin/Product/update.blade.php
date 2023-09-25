@extends('admin.layouts.app')
@section('content')

<form action="{{ route('products.edit', ['id' => $product->id])  }}" method="post" id="productsform" name="productsform" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <!-- Default box -->
    <div class="container-fluid">
    
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="title">Title</label>
                                    <input type="text" value="{{ $product->title }}" name="title" id="title" class="form-control @error('title') is-invalid @enderror" placeholder="Title" oninput="generateSlug()">
                                    @error('title')
                                    <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="title">Slug</label>
                                    <input type="text" readonly  value="{{ $product->slug }}"  name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" placeholder="slug">	
                                    @error('slug')
                                    <p class="invalid-feedback">{{$message}}</p>
                                @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="description">Description</label>
                                    <textarea name="description" value="{{ $product->description }}" id="description" cols="30" rows="10"
                                        class="summernote" placeholder="Description"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="h4 mb-3">Media</h2>								
                        <div id="image" class="dropzone dz-clickable">
                            <div class="dz-message needsclick">
                                <br>Drop files here or click to upload.<br><br>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="h4 mb-3">Pricing</h2>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="price">Price</label>
                                    <input type="text" name="price" value="{{ $product->price }}" id="price" class="form-control @error('price') is-invalid @enderror"
                                        placeholder="Price">
                                        	
                                        @error('price')
                                        <p class="invalid-feedback">{{$message}}</p>
                                        @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="compare_price">Compare at Price</label>
                                    <input type="text" value="{{ $product->compare_price }}" name="compare_price" id="compare_price"
                                        class="form-control" placeholder="Compare Price">
                                    <p class="text-muted mt-3">
                                        To show a reduced price, move the product’s original price into Compare at
                                        price. Enter a lower value into Price.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="h4 mb-3">Inventory</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sku">SKU (Stock Keeping Unit)</label>
                                    <input type="text" value="{{ $product->sku }}" name="sku" id="sku" class="form-control @error('sku') is-invalid @enderror"
                                        placeholder="sku">
                                        	
                                        @error('sku')
                                        <p class="invalid-feedback">{{$message}}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="barcode">Barcode</label>
                                    <input type="text" value="{{ $product->barcode }}" name="barcode" id="barcode" class="form-control"
                                        placeholder="Barcode">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <div class="custom-control custom-checkbox">
                                        <input type="hidden" name="track_quantity" value="No">
                                        <input class="custom-control-input" type="checkbox" id="track_quantity" class="form-control @error('track_quantity') is-invalid @enderror"
                                            name="track_quantity" value="Yes" checked>
                                        <label for="track_quantity" class="custom-control-label">Track Quantity</label>
                                        	
                                        @error('track_quantity')
                                        <p class="invalid-feedback">{{$message}}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <input type="number" value="{{ $product->quantity }}" min="0" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror"
                                        placeholder="Qty">
                                        @error('quantity')
                                        <p class="invalid-feedback">{{$message}}</p>
                                        @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="h4 mb-3">Product status</h2>
                        <div class="mb-3">
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                <option value="1">Active</option>
                                <option value="0">Block</option>
                            </select>
                            @error('status')
                            <p class="invalid-feedback">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h2 class="h4 mb-3">Product category</h2>
                        <div class="mb-3">
                            <label for="category">Category</label>
                            <select name="category" value="{{old('category')}}" id="category" class="form-control @error('category') is-invalid @enderror">
                                <option value="">Select Category</option>
                                    @if($categories->isNotEmpty())
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    @endif
                            </select>
                            @error('category')
                            <p class="invalid-feedback">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="category">Sub category</label>
                            <select name="sub_category"  value="{{old('subcategory')}}" id="sub_category" class="form-control">
                                <option value="">Select Subcategory</option>
                                <!-- Subcategories will be populated using AJAX -->
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="h4 mb-3">Product brand</h2>
                        <div class="mb-3">
                            <select name="brand" value="{{old('brand')}}" id="brand" class="form-control">
                                <option value="">Select Brand</option>
                                {{-- <option value="">Select Subcategory</option> --}}
                                @if($brands->isNotEmpty())
                                @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="h4 mb-3">Featured product</h2>
                        <div class="mb-3">
                            <select name="is_featured" id="is_featured" class="form-control @error('is_featured') is-invalid @enderror">
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                            </select>	
                            @error('is_featured')
                            <p class="invalid-feedback">{{$message}}</p>
                        @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pb-5 pt-3">
            <button type="submit" class="btn btn-primary">Create</button>
            <a href="{{route("products.create")}}" class="btn btn-outline-dark ml-3">Cancel</a>
        </div>
    </div>
    </form>


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>
    <script>
        function generateSlug() {
            const titleInput = document.getElementById('title');
            const slugInput = document.getElementById('slug');
    
            // Get the value of the title input
            const titleValue = titleInput.value;
    
            // Generate a slug from the title
            const slug = titleValue
                .trim() // Remove leading and trailing spaces
                .toLowerCase() // Convert to lowercase
                .replace(/\s+/g, '-') // Replace spaces with dashes
                .replace(/[^\w-]+/g, ''); // Remove special characters
    
            // Setting the generated slug as the value of the slug input
            slugInput.value = slug;
        }
    
        $("#category").change(function () {
            var category_id= $(this).val(); // Get the selected category ID
    
            // Make an AJAX request to fetch subcategories
            $.ajax({
                url: '{{route("productsubcategory.index")}}',
                type: 'get',
                data:{category_id:category_id},
                datatype:'json',
                success: function (response) {
                    $("#sub_category").find("option").not(":first").remove(); // Don't clear first options
                    $.each(response["subCategories"],function(key,item){
                        $("#sub_category").append(`<option value="${item.name}">${item.name}</option>`);
                    });
    
                },
                error: function () {
                    // Handle errors if any
                    console.log("Something went wrong");
                }
            });
        });
    
    
    
    </script>
    

@endsection
				

