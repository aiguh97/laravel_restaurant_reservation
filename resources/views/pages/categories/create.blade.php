@extends('layouts.app')

@section('title', 'Add Category')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">

@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Add Category</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        <!-- Image Upload -->
                   <x-image-upload name="image" label="Category Image" id="categoryImage" />

                        <!-- Name -->
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
<!-- Description -->
<div class="form-group">
    <label>Description</label>
    <textarea name="description"
              class="form-control @error('description') is-invalid @enderror"
              rows="4">{{ old('description') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


                    <div class="card-footer text-right">
                        <button class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection

