@extends('admin.layouts.master')
@section('title', 'Edit Vehicle')
@section('main-container')

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Edit Vehicle</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('vehicles.index') }}">Vehicles</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            @include('admin.layouts.flashmsg')
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Edit Vehicle</h5>
                            <a href="{{ route('vehicles.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> Back
                            </a>
                        </div>

                        <!-- Edit Vehicle Form -->
                        <form class="row g-3" method="POST" action="{{ route('vehicles.update', $vehicle->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('vehicle_name') is-invalid @enderror"
                                        id="vehicle_name" name="vehicle_name" placeholder="Vehicle Name"
                                        value="{{ old('vehicle_name', $vehicle->vehicle_name) }}" required>
                                    <label for="vehicle_name">Vehicle Name <span class="text-danger">*</span></label>
                                    @error('vehicle_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('vehicle_number') is-invalid @enderror"
                                        id="vehicle_number" name="vehicle_number" placeholder="Vehicle Number"
                                        value="{{ old('vehicle_number', $vehicle->vehicle_number) }}" required>
                                    <label for="vehicle_number">Vehicle Number <span class="text-danger">*</span></label>
                                    @error('vehicle_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('owner_name') is-invalid @enderror"
                                        id="owner_name" name="owner_name" placeholder="Owner Name"
                                        value="{{ old('owner_name', $vehicle->owner_name) }}" required>
                                    <label for="owner_name">Owner Name <span class="text-danger">*</span></label>
                                    @error('owner_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="tel" class="form-control @error('owner_phone') is-invalid @enderror"
                                        id="owner_phone" name="owner_phone" placeholder="Owner Phone"
                                        value="{{ old('owner_phone', $vehicle->owner_phone) }}" required>
                                    <label for="owner_phone">Owner Phone <span class="text-danger">*</span></label>
                                    @error('owner_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('owner_address') is-invalid @enderror"
                                        id="owner_address" name="owner_address" placeholder="Owner Address"
                                        value="{{ old('owner_address', $vehicle->owner_address) }}">
                                    <label for="owner_address">Owner Address</label>
                                    @error('owner_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('driver_name') is-invalid @enderror"
                                        id="driver_name" name="driver_name" placeholder="Driver Name"
                                        value="{{ old('driver_name', $vehicle->driver_name) }}" required>
                                    <label for="driver_name">Driver Name <span class="text-danger">*</span> </label>
                                    @error('driver_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="tel" class="form-control @error('driver_phone') is-invalid @enderror"
                                        id="driver_phone" name="driver_phone" placeholder="Driver Phone"
                                        value="{{ old('driver_phone', $vehicle->driver_phone) }}" required>
                                    <label for="driver_phone">Driver Phone <span class="text-danger">*</span></label>
                                    @error('driver_phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <button type="submit" class="btn btn-outline-primary">Update</button>
                                <button type="reset" class="btn btn-outline-secondary">Reset</button>
                            </div>
                        </form><!-- End Edit Vehicle Form -->

                    </div>
                </div>
            </div>
        </section>
    </main><!-- End #main -->
@endsection
