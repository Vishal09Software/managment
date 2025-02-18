@extends('admin.layouts.master')
@section('title', 'Sales Management')
@section('main-container')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Sales Management</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Sales</li>
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
                                <h5 class="card-title">Sales List</h5>
                                <div>
                                    <a href="{{ route('sales.create') }}" class="btn btn-outline-primary"><i
                                            class="bi bi-plus-circle me-1"></i> Create Sale</a>
                                </div>
                            </div>

                            <form action="{{ route('sales.index') }}" method="GET"
                                class="row mb-3 justify-content-center">
                                <div class="col-md-2">
                                    <div class="form-floating">
                                        <input type="text" class="form-control shadow-sm" name="fields[vendor_name]"
                                            id="vendorField" placeholder="Search  Vendor"
                                            value="{{ request()->input('fields.vendor_name') }}">
                                        <label for="vendorField">Search  Vendor</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-floating">
                                        <input type="text" class="form-control shadow-sm" name="fields[customer_name]"
                                            id="customerField" placeholder="Search  Customer"
                                            value="{{ request()->input('fields.customer_name') }}">
                                        <label for="customerField">Search  Customer</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-floating">
                                        <input type="text" class="form-control shadow-sm" name="fields[driver_name]"
                                            id="vehicleField" placeholder="Search  Vehicle"
                                            value="{{ request()->input('fields.driver_name') }}">
                                        <label for="vehicleField">Search  Vehicle</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-floating">
                                        <input type="text" class="form-control shadow-sm" name="fields[eway_bill_number]"
                                            id="ewayBillField" placeholder="Search  E-way Bill"
                                            value="{{ request()->input('fields.eway_bill_number') }}">
                                        <label for="ewayBillField">Search  E-way Bill</label>
                                    </div>
                                </div>

                                <div class="col-md-2 text-center mt-3">
                                    <button type="submit" class="btn btn-outline-primary shadow-sm me-2" title="Search">
                                        <i class="bi bi-search"></i>
                                    </button>
                                    <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary shadow-sm"
                                        title="Reset">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </a>
                                </div>
                            </form>

                            <!-- Table with stripped rows -->
                            @if ($sales->isEmpty())
                                <div class="text-center">No sales found</div>
                            @else
                                <table class="table" id="salesTable">
                                    <thead>
                                        <tr>
                                            <th><b>No</b></th>
                                            <th><b>E-way Bill</b></th>
                                            <th><b>Sale Date</b></th>
                                            <th><b>Vendor Name</b></th>
                                            <th><b>Customer Name</b></th>
                                            <th><b>Driver Name</b></th>
                                            <th><b>Total Amount</b></th>
                                            <th><b>Actions</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sales as $sale)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $sale->eway_bill_number }}</td>
                                                <td>{{ $sale->date }}</td>
                                                <td>{{ $sale->vendor_name }}</td>
                                                <td>{{ $sale->customer_name }}</td>
                                                <td>{{ $sale->driver_name ?? 'N/A' }}</td>
                                                <td>₹{{ number_format($sale->s_total, 2) }}</td>

                                                <td>
                                                    <a href="{{ route('sales.show', $sale->id) }}"
                                                        class="btn btn-sm btn-outline-info">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('sales.invoice', $sale->id) }}"
                                                        class="btn btn-sm btn-outline-success">
                                                        <i class="bi bi-file-earmark-text"></i>
                                                    </a>
                                                    <a href="{{ route('sales.edit', $sale->id) }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $sale->id }}">
                                                        <i class="bi bi-trash"></i>
                                                    </button>

                                                    <!-- Delete Modal -->
                                                    <div class="modal fade" id="deleteModal{{ $sale->id }}"
                                                        tabindex="-1">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Delete Sale</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure you want to delete this sale?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-outline-secondary"
                                                                        data-bs-dismiss="modal">Cancel</button>
                                                                    <form action="{{ route('sales.destroy', $sale->id) }}"
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
                                {{ $sales->links() }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->
@endsection
