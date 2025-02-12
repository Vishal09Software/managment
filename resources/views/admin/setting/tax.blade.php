@extends('admin.layouts.master')
@section('title', 'Tax Settings')
@section('main-container')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Tax Settings</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Tax Settings</li>
                </ol>
            </nav>
        </div>
        <section class="section">
            <div class="row">
                @include('admin.layouts.flashmsg')
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title">Tax Rates</h5>
                                <div>
                                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#addTaxModal">
                                        <i class="bi bi-plus-circle me-1"></i> Add Tax Rate
                                    </button>
                                </div>
                            </div>

                            <!-- Tax Rates Table -->
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Tax Name</th>
                                        <th>Rate (%)</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($taxes as $tax)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $tax->tax_name }}</td>
                                            <td>{{ $tax->tax_rate }}</td>
                                            <td>
                                                @if ($tax->status)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-outline-primary"
                                                    data-bs-toggle="modal" data-bs-target="#editTaxModal{{ $tax->id }}"
                                                    data-id="{{ $tax->id }}">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                    data-bs-toggle="modal" data-bs-target="#deleteModal{{ $tax->id }}"
                                                    data-id="{{ $tax->id }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </td>
                                        </tr>

                                        <!-- Edit Tax Modal -->
                                        <div class="modal fade" id="editTaxModal{{ $tax->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit Tax Rate</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('taxes.update', $tax->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="tax_id"
                                                            value="{{ isset($tax) ? $tax->id : '' }}">
                                                        <div class="modal-body">
                                                            <div class="form-floating mb-3">
                                                                <input type="text" class="form-control"
                                                                    id="editTaxName{{ $tax->id }}" name="tax_name"
                                                                    value="{{ isset($tax) ? $tax->tax_name : '' }}"
                                                                    required>
                                                                <label for="editTaxName{{ $tax->id }}">Tax
                                                                    Name</label>
                                                            </div>
                                                            <div class="form-floating mb-3">
                                                                <input type="number" class="form-control"
                                                                    id="editTaxRate{{ $tax->id }}" name="tax_rate"
                                                                    step="0.01"
                                                                    value="{{ isset($tax) ? $tax->tax_rate : '' }}"
                                                                    required>
                                                                <label for="editTaxRate{{ $tax->id }}">Tax Rate
                                                                    (%)</label>
                                                            </div>
                                                            <div class="form-floating mb-3">
                                                                <select class="form-select"
                                                                    id="editTaxStatus{{ $tax->id }}" name="status">
                                                                    <option value="1"
                                                                        {{ isset($tax) && $tax->status ? 'selected' : '' }}>
                                                                        Active</option>
                                                                    <option value="0"
                                                                        {{ isset($tax) && !$tax->status ? 'selected' : '' }}>
                                                                        Inactive</option>
                                                                </select>
                                                                <label
                                                                    for="editTaxStatus{{ $tax->id }}">Status</label>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit"
                                                                class="btn btn-outline-primary">Update</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal{{ $tax->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Delete Tax Rate</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete this tax rate?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-secondary"
                                                            data-bs-dismiss="modal">Cancel</button>
                                                        <form action="{{ route('taxes.destroy', $tax->id) }}"
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
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No tax rates found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center mt-3">
                                {{ $taxes->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Tax Modal -->
            <div class="modal fade" id="addTaxModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add New Tax Rate</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form action="{{ route('taxes.store') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="taxName" name="tax_name"
                                            placeholder="Tax Name" required>
                                        <label for="taxName">Tax Name</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="taxRate" name="tax_rate"
                                            step="0.01" placeholder="Tax Rate (%)" required>
                                        <label for="taxRate">Tax Rate (%)</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-floating">
                                        <select class="form-select" id="taxStatus" name="status">
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                        <label for="taxStatus">Status</label>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-outline-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
