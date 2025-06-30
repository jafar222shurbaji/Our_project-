@extends('layouts.dashboard')

@section('title', 'Fabrics')
@section('page-title', 'Fabrics Management')

@section('content')
    <div class="page-header">
        <h2 class="page-title">Fabric List</h2>
        <a href="{{ route('fabrics.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Fabric
        </a>
    </div>

    <div class="table-container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fabric Type</th>
                    <th>Created Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($fabrics as $fabric)
                    <tr>
                        <td>{{ $fabric->id }}</td>
                        <td>{{ $fabric->fabric_type }}</td>
                        <td>{{ $fabric->created_at ? $fabric->created_at->format('d-m-Y') : 'No Date' }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('fabrics.edit', $fabric) }}" class="btn btn-sm btn-edit"><i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('fabrics.destroy', $fabric) }}" method="POST"
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
                        <td colspan="4" class="text-center">No fabrics found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
