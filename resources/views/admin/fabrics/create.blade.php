@extends('layouts.dashboard')

@section('page-title', 'Add New Fabric')
@section('page-title', 'Products Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Add New Fabric</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('fabrics.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="fabric_type" class="form-label">Fabric Type</label>
                            <input type="text" class="form-control @error('fabric_type') is-invalid @enderror"
                             id="fabric_type" name="fabric_type"  required>
                            @error('fabric_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('fabrics.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create Fabric</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
