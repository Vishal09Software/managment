@extends('admin.layouts.master')
@section('title', 'Payment Out')
@section('main-container')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Payment Out</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Payments Out</li>
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
                                <h5 class="card-title">Payments List</h5>
                                <div>
                                    <a href="{{ route('transactions-out.export', [
                                        'date_from' => request('date_from'),
                                        'date_to' => request('date_to'),
                                        'type' => request('type'),
                                        'vendor_id' => request('vendor_id'),
                                        'vehicle_id' => request('vehicle_id'),
                                        'payment_method' => request('payment_method')
                                    ]) }}" class="btn btn-outline-success me-2">
                                        <i class="bi bi-file-earmark-excel me-1"></i> Export
                                    </a>
                                    <a href="{{ route('transactions-out.create') }}"
                                        class="btn btn-outline-primary"><i class="bi bi-plus-circle me-1"></i> Create
                                        Payment</a>
                                </div>
                            </div>

                            <!-- Custom Search Filters -->
                            <form action="{{ route('transactions-out.index') }}" method="GET"
                                class="row mb-3 justify-content-center">
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input type="date" class="form-control shadow-sm" name="date_from"
                                            id="startDateField" placeholder="Start Date" value="{{ request('date_from') }}">
                                        <label for="startDateField">Start Date</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input type="date" class="form-control shadow-sm" name="date_to"
                                            id="endDateField" placeholder="End Date" value="{{ request('date_to') }}">
                                        <label for="endDateField">End Date</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <select class="form-select shadow-sm" name="type" id="typeField"
                                            onchange="showSecondSelect()">
                                            <option value="">Select Type</option>
                                            <option value="vendor" {{ request('type') == 'vendor' ? 'selected' : '' }}>
                                                Vendor</option>
                                            <option value="vehicle" {{ request('type') == 'vehicle' ? 'selected' : '' }}>
                                                Vehicle</option>
                                        </select>
                                        <label for="typeField">Type</label>
                                    </div>
                                </div>

                                <div class="col-md-3" id="vendorSelect" style="display:none;">
                                    <div class="form-floating">
                                        <select class="form-select select2 shadow-sm" name="vendor_id" id="vendorId">
                                            <option value="">Select Vendor</option>
                                            @foreach ($vendors as $vendor)
                                                <option value="{{ $vendor->id }}"
                                                    {{ request('vendor_id') == $vendor->id ? 'selected' : '' }}>
                                                    {{ $vendor->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3" id="vehicleSelect" style="display:none;">
                                    <div class="form-floating">
                                        <select class="form-select select2 shadow-sm" name="vehicle_id" id="vehicleId">
                                            <option value="">Select Vehicle</option>
                                            @foreach ($vehicles as $vehicle)
                                                <option value="{{ $vehicle->id }}"
                                                    {{ request('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                                    {{ $vehicle->driver_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <select class="form-select shadow-sm" name="payment_method" id="methodField">
                                            <option value="">Select Method</option>
                                            <option value="cash"
                                                {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                            <option value="bank"
                                                {{ request('payment_method') == 'bank' ? 'selected' : '' }}>Bank</option>
                                            <option value="mobile_money"
                                                {{ request('payment_method') == 'mobile_money' ? 'selected' : '' }}>Mobile
                                                Money</option>
                                        </select>
                                        <label for="methodField">Payment Method</label>
                                    </div>
                                </div>

                                <div class="col-md-3 text-center">
                                    <button type="submit" class="btn btn-outline-primary shadow-sm me-2" title="Search">
                                        <i class="bi bi-search"></i>
                                    </button>
                                    <a href="{{ route('transactions-out.index') }}" class="btn btn-outline-secondary shadow-sm"
                                        title="Reset">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </a>
                                </div>
                            </form>

                            <!-- Table with stripped rows -->
                            <table class="table" id="paymentsTable">
                                <thead>
                                    <tr>
                                        <th><b>No</b></th>
                                        <th><b>Reference No</b></th>
                                        <th><b>Vendor</b></th>
                                        <th><b>Vehicle</b></th>
                                        <th><b>Amount</b></th>
                                        <th><b>Method</b></th>
                                        <th><b>Payment Date</b></th>
                                        <th><b>Actions</b></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($payments as $payment)
                                        <tr>
                                            <td>{{ ($payments->currentPage() - 1) * $payments->perPage() + $loop->iteration }}
                                            </td>
                                            <td>{{ $payment->reference_no }}</td>
                                            <td>{{ $payment->vendor->name ?? 'N/A' }}</td>
                                            <td>{{ $payment->vehicle->driver_name ?? 'N/A' }}</td>
                                            <td>{{ number_format($payment->amount, 2) }}</td>
                                            <td>{{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}</td>
                                            <td>{{ $payment->payment_date }}</td>
                                            <td>
                                                <a href="{{ route('transactions-out.edit', $payment->id) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $payment->id }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>

                                                <!-- Delete Modal -->
                                                <div class="modal fade" id="deleteModal{{ $payment->id }}" tabindex="-1">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Delete Payment</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Are you sure you want to delete this payment?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-outline-secondary"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                <form
                                                                    action="{{ route('transactions-out.destroy', $payment->id) }}"
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
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No payments found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-center mt-3">
                                {{ $payments->appends(request()->query())->links() }}
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main><!-- End #main -->
@endsection
@section('scripts')
    <script>
        $("#vendorId").select2({
            placeholder: "Select Vendor",
            allowClear: true,
            width: '100%',
            theme: 'bootstrap-5',
            minimumInputLength: 1,
            ajax: {
                url: '{{ route('sales.vendorsearch') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.map(function(vendor) {
                            return {
                                id: vendor.id,
                                text: vendor.name
                            };
                        })
                    };
                },
                cache: true
            }
        });

        $("#vehicleId").select2({
            placeholder: "Select Vehicle",
            allowClear: true,
            width: '100%',
            theme: 'bootstrap-5',
            minimumInputLength: 1,
            ajax: {
                url: '{{ route('sales.vehicleSearch') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.map(function(vehicle) {
                            return {
                                id: vehicle.id,
                                text: vehicle.driver_name ?
                                    vehicle.driver_name + ' (' + vehicle.vehicle_number + ')' : vehicle
                                    .owner_name + ' (' + vehicle.vehicle_number + ')'
                            };
                        })
                    };
                },
                cache: true
            }
        });

        function showSecondSelect() {
            var type = document.getElementById('typeField').value;
            document.getElementById('vendorSelect').style.display = type === 'vendor' ? 'block' : 'none';
            document.getElementById('vehicleSelect').style.display = type === 'vehicle' ? 'block' : 'none';
        }
        // Show correct select on page load
        showSecondSelect();
    </script>
@endsection
