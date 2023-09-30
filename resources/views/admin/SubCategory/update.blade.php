
@extends('admin.layouts.app')
@section('content')

<section class="content-header">					
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Update Sub Category</h1>
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
    <form action="{{route('subcategory.edit',  ['id' => $subcategory->id])}}" method="post" id="subcategoryform" name="subcategoryform">
    @csrf
    @method('PUT')
        <div class="card">
            <div class="card-body">								
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="name">Category</label>
                            <select name="category" id="category" class="form-control">
                                @if($categories->isNotEmpty())
                                @foreach($categories as $category)
                                <option value="{{$category->id}}" {{ $subcategory->category_id == $category->id ? 'selected' : '' }}>
                                    {{$category->name}}
                                </option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="1" {{ $subcategory->status == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $subcategory->status == 0 ? 'selected' : '' }}>Block</option>
                            </select>      
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="show">Show on home</label>
                            <select name="show" id="show" class="form-control">
                                <option value="No" {{ $subcategory->show == 'No' ? 'selected' : '' }}>No</option>
                                <option value="Yes" {{ $subcategory->show == 'Yes' ? 'selected' : '' }}>Yes</option>
                            </select>
                            @error('show')
                                <p class="invalid-feedback">{{$message}}</p>
                            @enderror        
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name">Name</label>
                            <input type="text" name="name" value="{{ $subcategory->name }}" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name">
                            @error('name')
                                <p class="invalid-feedback">{{$message}}</p>
                            @enderror	
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="email">Slug</label>
                            <input type="text" name="slug" value="{{ $subcategory->slug }}" id="slug" class="form-control @error('name') is-invalid @enderror" placeholder="Slug">	
                            @error('slug')
                                <p class="invalid-feedback">{{$message}}</p>
                            @enderror
                        </div>
                    </div>									
                </div>
            </div>							
        </div>
        <div class="pb-5 pt-3">
            <button type="submit"  class="btn btn-primary">Update</button>
            <a href="{{route('subcategory.create')}}" class="btn btn-outline-dark ml-3">Cancel</a>
        </div>
    </form>
    </div>
    <!-- /.card -->
</section>



			<!-- /.content-wrapper -->
@endsection



