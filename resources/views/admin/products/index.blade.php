@extends('layouts.dashboard')

@section('title', 'Products')
@section('page-title')
    {{ Auth::user()->name }}
@endsection

@section('content')

    <div class="page-header">
        <h2 class="page-title">Product List</h2>
        <a href="{{ route('products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Product
        </a>
    </div>
    <div class="table-container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Created Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>
                            @if ($product->photos->isNotEmpty())
                                <img src="{{ asset('storage/' . $product->photos->first()->photo) }}"
                                    alt="{{ $product->name }}" height="30">
                            @else
                                <span class="text-muted">No image</span>
                            @endif
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->available_quantity }}</td>
                        <td>{{ $product->category->name ?? 'No category' }}</td>
                        <td>{{ Str::limit($product->description, 20) }}</td>
                        <td>{{ $product->created_at->format('d-M-Y') }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-edit">
                                    <i class="fas fa-edit"></i></a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-delete"
                                        onclick="return confirm('هل أنت متأكد؟')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">No products found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
