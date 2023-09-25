@extends('admin.layouts.app')

@section('content')
<style>
    #image-container img {
        max-width: 50px; /* Set the maximum width for the image */
        max-height: 50px; /* Set the maximum height for the image */
    }
</style>
<script>
    function showImagePreview(input) {
        var fileInput = input.files[0];
        var imageContainer = document.getElementById("image-container");
        var imageName = document.getElementById("image-name");

        if (fileInput) {
            var reader = new FileReader();

            reader.onload = function (e) {
                var image = document.createElement("img");
                image.src = e.target.result;
                imageContainer.innerHTML = ""; // Clear previous image, if any
                imageContainer.appendChild(image);
                imageName.innerText = "Image Name: " + fileInput.name;
            };

            reader.readAsDataURL(fileInput);
        } else {
            imageContainer.innerHTML = ""; // Clear image container
            imageName.innerText = "No Image Selected";
        }
    }
</script>

<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit ProductImage</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('Productsimage.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <form action="{{route('Productsimage.edit', ['id' => $ProductImage->id])  }}" method="post" id="categoryform" name="categoryform" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="name">Product</label>
                                <select name="product" id="product" class="form-control">
                                    @if($products->isNotEmpty())
                                    @foreach($products as $productId => $productTitle)
                                        <option value="{{ $productId }}">{{ $productTitle }}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="image-upload">Image</label>
                                <input type="file" value="{{$ProductImage->image}}" class="form-control @error('image-upload') is-invalid @enderror" id="image-upload" name="image-upload" onchange="showImagePreview(this)">
                                <div id="image-container">
                                    @if ($ProductImage->image)
                                        <img src="{{ asset('public/temp/' . $ProductImage->image) }}" alt="{{ $ProductImage->name }}">
                                    @endif
                                </div>
                                <p id="image-name">No Image Selected</p>

                                @error('image-upload')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('Productsimage.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
            </div>
        </form>
    </div>
    <!-- /.card -->
</section>
<!-- /.content -->
@endsection

@section('customjs')
<script>
    function updateSlug() {
        var name = document.getElementById("name").value;
        var slug = name.toLowerCase().replace(/ /g, "-");
        document.getElementById("slug").value = slug;
    }
</script>
@endsection