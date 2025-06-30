@extends('layouts.dashboard')

@section('title', 'Categories')
@section('page-title', 'Category Management')

@section('content')
    <div class="page-header">
        <h2 class="page-title">Category List</h2>
        <a href="{{ route('categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Category
        </a>
    </div>

    <div class="table-container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Icon</th>
                    <th>Name</th>
                    <th>Created Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>
                            @if($category->icon)
                                <img src="{{ $category->icon_url }}" alt="{{ $category->name }} icon" 
                                     class="img-thumbnail" style="max-width: 50px; max-height: 50px;">
                            @else
                                <span class="text-muted">No icon</span>
                            @endif
                        </td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->created_at ? $category->created_at->format("d-m-Y") : 'No Date' }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-edit"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST"
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
                        <td colspan="5" class="text-center">No categories found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>


@endsection
