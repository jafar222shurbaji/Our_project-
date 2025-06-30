@extends('layouts.dashboard')

@section('title', 'Woods')
@section('page-title', 'Woods Management')

@section('content')
<div class="page-header">
    <h2 class="page-title">Wood List</h2>
    <a href="{{ route('woods.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Add Wood
    </a>
</div>

<div class="table-container">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Wood Type</th>
                <th>Created Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($woods as $wood)
            <tr>
                <td>{{ $wood->id }}</td>
                <td>{{ $wood->wood_type }}</td>
                <td>{{ $wood->created_at->format('d-M-Y') }}</td>
                <td>
                    <div class="action-buttons">
                        <a href="{{ route('woods.edit', $wood) }}" class="btn btn-sm btn-edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="btn btn-sm btn-delete"
                                onclick="deleteWood({{ $wood->id }}, '{{ $wood->wood_type }}')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">No woods found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center">
    {{ $woods->links() }}
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteWoodModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the wood "<span id="woodName"></span>"?</p>
                <p class="text-danger">This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteWoodForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function deleteWood(id, name) {
    const modal = document.getElementById('deleteWoodModal');
    const form = document.getElementById('deleteWoodForm');
    const nameSpan = document.getElementById('woodName');

    form.action = `/admin/woods/${id}`;
    nameSpan.textContent = name;

    new bootstrap.Modal(modal).show();
}
</script>
@endsection
