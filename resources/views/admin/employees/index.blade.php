@extends('layouts.dashboard')

@section('title', 'Employees')
@section('page-title')
    {{ Auth::user()->name }}
@endsection

@section('content')
    <div class="page-header">
        <h2 class="page-title">Employee List</h2>
        <a href="{{ route('employees.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Employee
        </a>
    </div>

    <div class="table-container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Created Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $employee)
                    <tr>
                        <td>{{ $employee->id }}</td>
                        <td>{{ $employee->name }}</td>
                        <td>{{ $employee->email }}</td>
                        <td>{{ $employee->role->role_name }}</td>
                        <td>{{ $employee->created_at->format('d-M-Y') }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-sm btn-edit"><i
                                        class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('employees.destroy', $employee->id) }}" method="post"
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
                        <td colspan="6" class="text-center">No employees found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>


    {{ $employees->withQueryString()->appends(['search' => 1])->links() }}

@endsection
