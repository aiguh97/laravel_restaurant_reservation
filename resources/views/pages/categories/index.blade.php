@extends('layouts.app')

@section('title', 'Categories')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Categories</h1>
                <div class="section-header-button">
                    <a href="{{ route('categories.create') }}" class="btn btn-primary">Add New</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Category</a></div>
                    <div class="breadcrumb-item">All Category</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>



                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-body">

                                <div class="float-right">
                                    <form method="GET" action="{{ route('categories.index') }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search" name="name">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="clearfix mb-3"></div>

                                <div class="table-responsive">
                                    @php
                                        use Illuminate\Support\Str;
                                    @endphp

                                    <table class="table-striped table">
                                        <tr>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach ($categories as $category)
                                            <tr>
                                                {{-- <!-- Thumbnail image kecil -->
                                                <td>
                                                    @if ($category->image)
                                                        @php
                                                            $ext = pathinfo($category->image, PATHINFO_EXTENSION);
                                                        @endphp

                                                        @if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif']))
                                                            <img src="{{ asset('storage/categories/' . $category->image) }}"
                                                                alt="{{ $category->name }}"
                                                                style="width:50px; height:50px; object-fit:cover; border-radius:4px;">
                                                        @elseif(strtolower($ext) === 'svg')
                                                            <object type="image/svg+xml"
                                                                data="{{ asset('storage/categories/' . $category->image) }}"
                                                                style="width:50px; height:50px;">
                                                                SVG
                                                            </object>
                                                        @endif
                                                    @else
                                                        <span class="text-muted">No image</span>
                                                    @endif
                                                </td> --}}
                                                <td>
                                        @if ($category->image)
                                            <img
                                                src="{{ Storage::disk('minio')->url('categories/'.$category->image) }}"
                                                alt="{{ $category->name }}"
                                                style="width:50px; height:50px; object-fit:contain; border-radius:4px;"
                                            >
                                        @else
                                            <span class="text-muted">No image</span>
                                        @endif
                                    </td>



                                                <!-- Name limited 33 characters -->
                                                <td>{{ Str::limit($category->name, 33) }}</td>
                                                <td>{{ Str::limit($category->image) }}</td>

                                                <!-- Description limited 33 characters -->
                                                <td>{{ Str::limit($category->description ?? '', 33) }}</td>

                                                <td>{{ $category->created_at->format('d M Y') }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <a href='{{ route('categories.edit', $category->id) }}'
                                                            class="btn btn-sm btn-info btn-icon">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>

                                                        <form action="{{ route('categories.destroy', $category->id) }}"
                                                            method="POST" class="ml-2">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button class="btn btn-sm btn-danger btn-icon confirm-delete">
                                                                <i class="fas fa-times"></i> Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $categories->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
