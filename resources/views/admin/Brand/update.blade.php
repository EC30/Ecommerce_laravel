@extends('admin.layouts.app')

@section('content')


<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid my-2">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Brand</h1>
            </div>
            <div class="col-sm-6 text-right">
                <a href="{{ route('brands.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- Main content -->
<section class="content">
    <!-- Default box -->
    <div class="container-fluid">
        <form action="{{route('brands.edit', ['id' => $Brand->id])  }}" method="post" id="brandform" name="brandform" >
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" value="{{ $Brand->name }}" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="Name">

                                @error('name')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="slug">Slug</label>
                                <input type="text" value="{{ $Brand->slug }}" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" placeholder="Slug">

                                @error('slug')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status">Status</label>
                                <select name="status" id="status" class="form-control" value="{{$Brand->status}}">
                                    <option value="1" {{ $Brand->status == 1 ? 'selected' : '' }}>Active</option>
                                    <option value="2" {{ $Brand->status == 2 ? 'selected' : '' }}>Block</option>
                                </select>

                                @error('status')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pb-5 pt-3">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('brands.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
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