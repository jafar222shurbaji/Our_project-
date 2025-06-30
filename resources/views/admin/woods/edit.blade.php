@extends('layouts.dashboard')

@section('page-title', 'Edit Wood')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Edit Wood</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('woods.update', $wood) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="wood_type" class="form-label">Wood Type</label>
                            <input type="text" class="form-control @error('wood_type') is-invalid @enderror" id="wood_type" name="wood_type" value="{{ old('wood_type', $wood->wood_type) }}" required>
                            @error('wood_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('woods.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Wood</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
