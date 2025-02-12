@extends('admin.layouts.master')
@section('title', 'User Management')
@section('main-container')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>User Management</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Users</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                @include('admin.layouts.flashmsg')
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title">Users List</h5>
                                <div>
                                    <a href="{{ route('users.create') }}" class="btn btn-outline-primary"><i
                                            class="bi bi-plus-circle me-1"></i> Create User</a>
                                </div>
                            </div>

                            <!-- Custom Search Filters -->
                            <form action="{{ route('users.index') }}" method="GET" class="row mb-3 justify-content-center">
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control shadow-sm" name="fields[name]" id="nameField" placeholder="Search by Name" value="{{ request()->input('fields.name') }}">
                                        <label for="nameField">Search by Name</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control shadow-sm" name="fields[email]" id="emailField" placeholder="Search by Email" value="{{ request()->input('fields.email') }}">
                                        <label for="emailField">Search by Email</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control shadow-sm" name="fields[mobile]" id="mobileField" placeholder="Search by Mobile" value="{{ request()->input('fields.mobile') }}">
                                        <label for="mobileField">Search by Mobile</label>
                                    </div>
                                </div>

                                <div class="col-md-3 text-center">
                                    <button type="submit" class="btn btn-outline-primary shadow-sm me-2" title="Search">
                                        <i class="bi bi-search"></i>
                                    </button>
                                    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary shadow-sm" title="Reset">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </a>
                                </div>
                            </form>

                            @if ($users->isEmpty())
                            <td colspan="10" class="text-center">No users found</td>
                            @else
                                <!-- Table with stripped rows -->
                                <table class="table" id="usersTable">
                                    <thead>
                                        <tr>
                                            <th><b>No</b></th>
                                            <th><b>Name</b></th>
                                            <th><b>Email</b></th>
                                            <th><b>Mobile</b></th>
                                            <th><b>Created At</b></th>
                                            <th><b>Actions</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->mobile ?? 'N/A' }}</td>
                                                <td>{{ $user->created_at->format('Y-m-d') }}</td>
                                                <td>
                                                    <a href="{{ route('users.edit', $user->id) }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $user->id }}">
                                                        <i class="bi bi-trash"></i>
                                                    </button>

                                                    <!-- Delete Modal -->
                                                    <div class="modal fade" id="deleteModal{{ $user->id }}"
                                                        tabindex="-1">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Delete User</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure you want to delete this user?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-outline-secondary"
                                                                        data-bs-dismiss="modal">Cancel</button>
                                                                    <form action="{{ route('users.destroy', $user->id) }}"
                                                                        method="POST" class="d-inline">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="btn btn-outline-danger">Delete</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <!-- End Table with stripped rows -->

                                <!-- Pagination -->
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $users->appends(request()->query())->links() }}
                                </div>
                            @endif

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main><!-- End #main -->
@endsection
