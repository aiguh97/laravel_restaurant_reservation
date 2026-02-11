@extends('layouts.app')

@section('title', 'Edit Category')

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
            <h1>Edit Category</h1>
        </div>

        <div class="section-body">
            <div class="card">
                <form action="{{ route('categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">

                        <!-- Image Upload -->
                        <x-image-upload
                            name="image"
                            label="Category Image"
                            id="categoryImage"
                            {{-- :oldImage="$category->image ? asset('storage/categories/' . $category->image) : null" --}}
                            {{-- :oldImage="$category->image_path ? Storage::disk('s3')->url($category->image_path) : null" --}}
                            :oldImage="$category->image ? Storage::disk('minio')->url('categories/' . $category->image) : null"

                        />

                        <!-- Name -->
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $category->name) }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="card-footer text-right">
                        <button class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<!-- x-image-upload sudah handle JS preview & remove -->
@endpush
