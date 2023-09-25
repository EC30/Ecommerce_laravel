
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
								<h1>Create Category</h1>
							</div>
							<div class="col-sm-6 text-right">
								<a href="{{route('categories.index')}}" class="btn btn-primary">Back</a>
							</div>
						</div>
					</div>
					<!-- /.container-fluid -->
	</section>
				<!-- Main content -->
			<section class="content">
					<!-- Default box -->
				<div class="container-fluid">
                    <form action="{{route('categories.store')}}" method="post" id="categoryform" name="categoryform" enctype="multipart/form-data">
                    @csrf
						<div class="card">
							<div class="card-body">								
								<div class="row">
									<div class="col-md-6">
										<div class="mb-3">
											<label for="name">Name</label>
											<input type="text" value="{{old('name')}}" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" oninput="generateSlug()">	
										
                                            @error('name')
                                                <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label for="slug">Slug</label>
											<input type="text" readonly value="{{old('slug')}}" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" placeholder="Slug">	
                                            
                                            @error('slug')
                                                <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
									</div>
                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="status">Status</label>
											<select name="status" id="status" class="form-control">
                                                <option value="1">Active</option>
                                                <option value="2">Block</option>
                                            </select>
                                            
                                            @error('status')
                                                <p class="invalid-feedback">{{$message}}</p>
                                            @enderror        
										</div>
									</div>
                                    <div class="col-md-6">
										<div class="mb-3">
											<label for="show">Show on home</label>
											<select name="show" id="show" class="form-control">
                                                <option value="No">No</option>
                                                <option value="Yes">Yes</option>
                                            </select>
                                            
                                            @error('show')
                                                <p class="invalid-feedback">{{$message}}</p>
                                            @enderror        
										</div>
									</div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="image-upload">Image</label>
                                            <input type="file" value="{{old('image-upload')}}" class="form-control @error('image-upload') is-invalid @enderror" id="image-upload" name="image-upload" onchange="showImagePreview(this)">
                                            <div id="image-container"></div>
                                            <p id="image-name">No Image Selected</p>
                                
                                            @error('image-upload')
                                                <p class="invalid-feedback">{{$message}}</p>
                                            @enderror
                                        </div>
                                    </div>								
								</div>
							</div>							
						</div>
						<div class="pb-5 pt-3">
							<button type="submit" class="btn btn-primary">Create</button>
							<a href="{{route('categories.index')}}" class="btn btn-outline-dark ml-3">Cancel</a>
						</div>
                    </form>
				</div>
					<!-- /.card -->
			</section>
				<!-- /.content -->

			<!-- /.content-wrapper -->
@endsection

<script>
    function generateSlug() {
        const titleInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');

        // Get the value of the title input
        const titleValue = titleInput.value;

        // Generate a slug from the title
        const slug = titleValue
            .trim() // Remove leading and trailing spaces
            .toLowerCase() // Convert to lowercase
            .replace(/\s+/g, '-') // Replace spaces with dashes
            .replace(/[^\w-]+/g, ''); // Remove special characters

        // Set the generated slug as the value of the slug input
        slugInput.value = slug;
    }
</script>

@section('customjs')
@endsection

