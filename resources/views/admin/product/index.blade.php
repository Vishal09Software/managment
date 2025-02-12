@extends('admin.layouts.master')
@section('title', 'Product Management')
@section('main-container')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Product Management</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Products</li>
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
                                <h5 class="card-title">Products List</h5>
                                <div>
                                    <a href="{{ route('products.create') }}" class="btn btn-outline-primary"><i
                                            class="bi bi-plus-circle me-1"></i> Create Product</a>
                                </div>
                            </div>

                            <!-- Custom Search Filters -->
                            <form action="{{ route('products.index') }}" method="GET" class="row mb-3 justify-content-center">
                                <div class="col-md-2">
                                    <div class="form-floating">
                                        <input type="text" class="form-control shadow-sm" name="fields[name]" id="nameField" placeholder="Search by Name" value="{{ request()->input('fields.name') }}">
                                        <label for="nameField">Search by Name</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-floating">
                                        <input type="text" class="form-control shadow-sm" name="fields[hsn_code]" id="hsnField" placeholder="Search by HSN Code" value="{{ request()->input('fields.hsn_code') }}">
                                        <label for="hsnField">Search by HSN Code</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-floating">
                                        <input type="text" class="form-control shadow-sm" name="fields[grade]" id="gradeField" placeholder="Search by Grade" value="{{ request()->input('fields.grade') }}">
                                        <label for="gradeField">Search by Grade</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-floating">
                                        <select class="form-select shadow-sm" name="fields[tax_id]" id="taxField">
                                            <option value="">Select Tax</option>
                                            @foreach($taxes as $tax)
                                                <option value="{{ $tax->id }}" {{ request()->input('fields.tax_id') == $tax->id ? 'selected' : '' }}>
                                                    {{ $tax->tax_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="taxField">Search by Tax</label>
                                    </div>
                                </div>

                                <div class="col-md-3 text-center">
                                    <button type="submit" class="btn btn-outline-primary shadow-sm me-2" title="Search">
                                        <i class="bi bi-search"></i>
                                    </button>
                                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary shadow-sm" title="Reset">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </a>
                                </div>
                            </form>

                            @if ($products->isEmpty())
                                <div class="text-center">No products found</div>
                            @else
                                <!-- Table with stripped rows -->
                                <table class="table" id="productsTable">
                                    <thead>
                                        <tr>
                                            <th><b>No</b></th>
                                            <th><b>Image</b></th>
                                            <th><b>Name</b></th>
                                            <th><b>HSN Code</b></th>
                                            <th><b>Price</b></th>
                                            <th><b>Grade</b></th>
                                            <th><b>Tax</b></th>
                                            <th><b>Status</b></th>
                                            <th><b>Created At</b></th>
                                            <th><b>Actions</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            <tr>
                                                <td>{{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}</td>
                                                <td>
                                                    @if ($product->image)
                                                        <img src="{{ asset('images/product/' . $product->image) }}"
                                                            alt="{{ $product->name }}" class="img-fluid img-thumbnail"
                                                            style="width: 50px; height: 50px;">
                                                    @else
                                                        <img src="{{ Avatar::create($product->name)->toBase64() }}"
                                                            alt="{{ $product->name }}" class="img-fluid img-thumbnail"
                                                            style="width: 50px; height: 50px;">
                                                    @endif
                                                </td>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->hsn_code ?? 'N/A' }}</td>
                                                <td>{{ $product->price ?? 'N/A' }}</td>
                                                <td>{{ $product->grade ?? 'N/A' }}</td>
                                                <td>{{ $product->tax->tax_name ?? 'N/A' }}</td>
                                                <td>
                                                    @if ($product->status)
                                                        <span class="badge bg-success">Active</span>
                                                    @else
                                                        <span class="badge bg-danger">Inactive</span>
                                                    @endif
                                                </td>
                                                <td>{{ $product->created_at->format('Y-m-d') }}</td>
                                                <td>
                                                    <a href="{{ route('products.edit', $product->id) }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $product->id }}">
                                                        <i class="bi bi-trash"></i>
                                                    </button>

                                                    <!-- Delete Modal -->
                                                    <div class="modal fade" id="deleteModal{{ $product->id }}"
                                                        tabindex="-1">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Delete Product</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure you want to delete this product?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-outline-secondary"
                                                                        data-bs-dismiss="modal">Cancel</button>
                                                                    <form
                                                                        action="{{ route('products.destroy', $product->id) }}"
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
                                    {{ $products->appends(request()->query())->links() }}
                                </div>
                            @endif

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main><!-- End #main -->
@endsection
