@extends('layouts.dashboard')

@section('title', 'Add New Product')
@section('page-title')
    {{ Auth::user()->name }}
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Add New Product</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Product Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                    rows="3" required></textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" step="0.01"
                                    class="form-control @error('price') is-invalid @enderror" id="price" name="price"
                                    required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="available_quantity" class="form-label">Available Quantity</label>
                                <input type="number" class="form-control @error('available_quantity') is-invalid @enderror"
                                    id="available_quantity" name="available_quantity" required>
                                @error('available_quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="category_id" class="form-label">Category</label>
                                <select class="form-select @error('category_id') is-invalid @enderror" id="category_id"
                                    name="category_id" required>
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="color_id" class="form-label">Color</label>
                                <select class="form-select @error('color_id') is-invalid @enderror" id="color_id"
                                    name="color_id" required>
                                    <option value="">Select Color</option>
                                    @foreach ($colors as $color)
                                        <option value="{{ $color->id }}">{{ $color->name }} </option>
                                    @endforeach
                                </select>
                                @error('color_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="fabric_id" class="form-label">Fabric</label>
                                <select class="form-select @error('fabric_id') is-invalid @enderror" id="fabric_id"
                                    name="fabric_id" required>
                                    <option value="">Select Fabric</option>
                                    @foreach ($fabrics as $fabric)
                                        <option value="{{ $fabric->id }}"> {{ $fabric->fabric_type }} </option>
                                    @endforeach
                                </select>
                                @error('fabric_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="wood_id" class="form-label">Wood</label>
                                <select class="form-select @error('wood_id') is-invalid @enderror" id="wood_id"
                                    name="wood_id" required>
                                    <option value="">Select Wood</option>
                                    @foreach ($woods as $wood)
                                        <option value="{{ $wood->id }}">{{ $wood->wood_type }}</option>
                                    @endforeach
                                </select>
                                @error('wood_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- <div class="mb-3">
                                <label for="model_3d" class="form-label">3D Model URL</label>
                                <input type="text" class="form-control @error('model_3d') is-invalid @enderror"
                                    id="model_3d" name="model_3d" value="{{ old('model_3d') }}" required>
                                @error('model_3d')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> --}}

                            <div class="mb-3">
                                <label for="images" class="form-label">Product Images</label>
                                <input type="file" name="images[]" id="images" class="form-control" @error('images.*') is-invalid @enderror multiple required>
                                <small class="text-muted">You can select multiple images. Supported formats: JPEG, PNG, JPG,
                                    GIF. Max size: 2MB per image.</small>
                                @error('images.*')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Create Product</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


