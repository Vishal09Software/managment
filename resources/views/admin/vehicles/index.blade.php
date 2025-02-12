@extends('admin.layouts.master')
@section('title', 'Vehicle Management')
@section('main-container')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Vehicle Management</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Vehicles</li>
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
                                <h5 class="card-title">Vehicles List</h5>
                                <div>
                                    <a href="{{ route('vehicles.create') }}" class="btn btn-outline-primary"><i
                                            class="bi bi-plus-circle me-1"></i> Create Vehicle</a>
                                </div>
                            </div>

                            <!-- Custom Search Filters -->
                            <form action="{{ route('vehicles.index') }}" method="GET" class="row mb-3 justify-content-center">
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control shadow-sm" name="fields[vehicle_number]" id="vehicleNumberField" placeholder="Search by Vehicle Number" value="{{ request()->input('fields.vehicle_number') }}">
                                        <label for="vehicleNumberField">Search by Vehicle Number</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control shadow-sm" name="fields[vehicle_name]" id="vehicleNameField" placeholder="Search by Vehicle Name" value="{{ request()->input('fields.vehicle_name') }}">
                                        <label for="vehicleNameField">Search by Vehicle Name</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control shadow-sm" name="fields[driver_name]" id="driverNameField" placeholder="Search by Driver Name" value="{{ request()->input('fields.driver_name') }}">
                                        <label for="driverNameField">Search by Driver Name</label>
                                    </div>
                                </div>

                                <div class="col-md-3 text-center">
                                    <button type="submit" class="btn btn-outline-primary shadow-sm me-2" title="Search">
                                        <i class="bi bi-search"></i>
                                    </button>
                                    <a href="{{ route('vehicles.index') }}" class="btn btn-outline-secondary shadow-sm" title="Reset">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </a>
                                </div>
                            </form>

                            <!-- Table with stripped rows -->
                            @if ($vehicles->isEmpty())
                                <div class="text-center">No vehicles found</div>
                            @else
                                <table class="table" id="vehiclesTable">
                                    <thead>
                                        <tr>
                                            <th><b>No</b></th>
                                            <th><b>Vehicle Name</b></th>
                                            <th><b>Vehicle Number</b></th>
                                            <th><b>Owner Name</b></th>
                                            <th><b>Driver Name</b></th>
                                            <th><b>Actions</b></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($vehicles as $vehicle)
                                            <tr>
                                                <td>{{ ($vehicles->currentPage() - 1) * $vehicles->perPage() + $loop->iteration }}</td>
                                                <td>{{ $vehicle->vehicle_name }}</td>
                                                <td>{{ $vehicle->vehicle_number }}</td>
                                                <td>{{ $vehicle->owner_name }}</td>
                                                <td>{{ $vehicle->driver_name }}</td>
                                                <td>
                                                    <a href="{{ route('vehicles.edit', $vehicle->id) }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal{{ $vehicle->id }}">
                                                        <i class="bi bi-trash"></i>
                                                    </button>

                                                    <!-- Delete Modal -->
                                                    <div class="modal fade" id="deleteModal{{ $vehicle->id }}"
                                                        tabindex="-1">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Delete Vehicle</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Are you sure you want to delete this vehicle?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-outline-secondary"
                                                                        data-bs-dismiss="modal">Cancel</button>
                                                                    <form action="{{ route('vehicles.destroy', $vehicle->id) }}"
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
                                {{ $vehicles->appends(request()->query())->links() }}
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main><!-- End #main -->
@endsection
