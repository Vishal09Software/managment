@extends('admin.layouts.master')
@section('title', 'Customer Management')
@section('main-container')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Customer Management</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Customers</li>
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
                                <h5 class="card-title">Customers List</h5>
                                <div>
                                    <a href="{{ route('customers.create') }}" class="btn btn-outline-primary"><i
                                            class="bi bi-plus-circle me-1"></i> Create Customer</a>
                                </div>
                            </div>

                            <!-- Custom Search Filters -->
                            <form action="{{ route('customers.index') }}" method="GET"
                                class="row mb-3 justify-content-center">
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control shadow-sm" name="fields[name]"
                                            id="nameField" placeholder="Search by Name"
                                            value="{{ request()->input('fields.name') }}">
                                        <label for="nameField">Search by Name</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control shadow-sm" name="fields[email]"
                                            id="emailField" placeholder="Search by Email"
                                            value="{{ request()->input('fields.email') }}">
                                        <label for="emailField">Search by Email</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control shadow-sm" name="fields[mobile]"
                                            id="mobileField" placeholder="Search by Mobile"
                                            value="{{ request()->input('fields.mobile') }}">
                                        <label for="mobileField">Search by Mobile</label>
                                    </div>
                                </div>

                                <div class="col-md-3 text-center">
                                    <button type="submit" class="btn btn-outline-primary shadow-sm me-2" title="Search">
                                        <i class="bi bi-search"></i>
                                    </button>
                                    <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary shadow-sm"
                                        title="Reset">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </a>
                                </div>
                            </form>

                            <!-- Table with stripped rows -->
                            @if ($customers->isEmpty())
                                <div class="text-center">No customers found</div>
                            @else
                                <table class="table" id="customersTable">
                                    <thead>
                                        <tr>
                                            <th><b>No</b></th>
                                            <th><b>Image</b></th>
                                            <th><b>Name</b></th>
                                            <th><b>Email</b></th>
                                            <th><b>Mobile</b></th>
                                            <th><b>Gender</b></th>
                                            <th><b>Status</b></th>
                                            <th><b>Created At</b></th>
                                            <th><b>Actions</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customers as $customer)
                                            <tr>
                                                <td>{{ ($customers->currentPage() - 1) * $customers->perPage() + $loop->iteration }}
                                                </td>
                                                <td>
                                                    @if ($customer->image)
                                                        <img src="{{ asset('images/customer/' . $customer->image) }}"
                                                            alt="{{ $customer->name }}" class="img-fluid img-thumbnail"
                                                            style="width: 50px; height: 50px;">
                                                    @else
                                                        <img src="{{ Avatar::create($customer->name)->toBase64() }}"
                                                            alt="{{ $customer->name }}" class="img-fluid img-thumbnail"
                                                            style="width: 50px; height: 50px;">
                                                    @endif
                                                </td>
                                                <td>{{ $customer->name }}</td>
                                                <td>{{ $customer->email }}</td>
                                                <td>{{ $customer->mobile ?? 'N/A' }}</td>
                                                <td>{{ ucwords($customer->gender) }}</td>
                                                <td>
                                                    @if ($customer->status)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>{{ $customer->created_at->format('Y-m-d') }}</td>
                                                <td>
                                                    <a href="{{ route('customers.edit', $customer->id) }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $customer->id }}">
                                                        <i class="bi bi-trash"></i>
                                                    </button>

                                                    <!-- Delete Modal -->
                                                    <div class="modal fade" id="deleteModal{{ $customer->id }}"
                                                        tabindex="-1">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Delete Customer</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure you want to delete this customer?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-outline-secondary"
                                                                        data-bs-dismiss="modal">Cancel</button>
                                                                    <form
                                                                        action="{{ route('customers.destroy', $customer->id) }}"
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
                            @endif
                            <!-- End Table with stripped rows -->

                            <!-- Pagination -->
                            <div class="d-flex justify-content-center mt-3">
                                {{ $customers->appends(request()->query())->links() }}
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main><!-- End #main -->
@endsection
