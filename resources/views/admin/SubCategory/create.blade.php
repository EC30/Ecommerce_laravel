
@extends('admin.layouts.app')
@section('content')

<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Sub Category</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{route('subcategory.index')}}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
    <form action="{{route('subcategory.store')}}" method="post" id="subcategoryform" name="subcategoryform">
    @csrf
        <div class="card">
            <div class="card-body">								
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="name">Category</label>
                            <select name="category" id="category" class="form-control">
                                @if($categories->isNotEmpty())
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="1">Active</option>
                                <option value="2">Block</option>
                            </select>      
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="show">Show on home</label>
                            <select name="show" id="show" class="form-control">
                                <option value="No" >No</option>
                                <option value="Yes">Yes</option>
                            </select>
                            
                            @error('show')
                                <p class="invalid-feedback">{{$message}}</p>
                            @enderror        
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name">Name</label>
                            <input type="text" name="name" value ="{{old('name')}}" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name" oninput="generateSlug()">
                            @error('name')
                                <p class="invalid-feedback">{{$message}}</p>
                            @enderror	
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email">Slug</label>
                            <input type="text" readonly name="slug" value ="{{old('slug')}}" id="slug" class="form-control @error('name') is-invalid @enderror" placeholder="Slug">	
                            @error('slug')
                                <p class="invalid-feedback">{{$message}}</p>
                            @enderror
                        </div>
                    </div>									
                </div>
            </div>							
        </div>
        <div class="pb-5 pt-3">
            <button type="submit"  class="btn btn-primary">Add</button>
            <a href="{{route('subcategory.create')}}" class="btn btn-outline-dark ml-3">Cancel</a>
        </div>
    </form>
    </div>
    <!-- /.card -->
</section>

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



			<!-- /.content-wrapper -->
@endsection



