@extends('admin.layouts.master')
@section('title', 'Edit Payment')
@section('main-container')

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Edit Payment</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('transactions-out.index') }}">Payments Out</a></li>
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
                            <h5 class="card-title">Edit Payment</h5>
                            <a href="{{ route('transactions-out.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> Back
                            </a>
                        </div>

                        <!-- Edit Payment Form -->
                        <form class="row g-3" method="POST" action="{{ route('transactions-out.update', $payment->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select shadow-sm @error('type') is-invalid @enderror"
                                        name="type" id="typeField" required onchange="handleTypeChange()">
                                        <option value="">Select Type</option>
                                        <option value="vendor" {{ $payment->type == 'vendor' ? 'selected' : '' }}>
                                            Vendor</option>
                                        <option value="vehicle" {{ $payment->type == 'vehicle' ? 'selected' : '' }}>
                                            Vehicle</option>
                                    </select>
                                    <label for="typeField">Type</label>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating" id="vendorSelect" style="display:none;">
                                    <select class="form-select select2 @error('vendor_id') is-invalid @enderror"
                                        id="vendorId" name="vendor_id" onchange="getVendorAmounts('vendor', this.value)">
                                        <option value="">Select Vendor</option>
                                        @foreach ($vendors as $vendor)
                                            <option value="{{ $vendor->id }}"
                                                {{ $payment->vendor_id == $vendor->id ? 'selected' : '' }}>
                                                {{ $vendor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('vendor_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-floating" id="vehicleSelect" style="display:none;">
                                    <select class="form-select select2 @error('vehicle_id') is-invalid @enderror"
                                        id="vehicleId" name="vehicle_id" onchange="getVendorAmounts('vehicle', this.value)">
                                        <option value="">Select Vehicle</option>
                                        @foreach ($vehicles as $vehicle)
                                            <option value="{{ $vehicle->id }}"
                                                {{ $payment->vehicle_id == $vehicle->id ? 'selected' : '' }}>
                                                {{ $vehicle->driver_name ? $vehicle->driver_name . ' (' . $vehicle->vehicle_number . ')' : $vehicle->owner_name . ' (' . $vehicle->vehicle_number . ')' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('vehicle_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control @error('payment_date') is-invalid @enderror"
                                        id="payment_date" name="payment_date"
                                        value="{{ old('payment_date', $payment->payment_date) }}" required>
                                    <label for="payment_date">Payment Date</label>
                                    @error('payment_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select @error('payment_method') is-invalid @enderror"
                                        id="payment_method" name="payment_method" required>
                                        <option value="">Select Payment Method</option>
                                        <option value="cash" {{ $payment->payment_method == 'cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="bank" {{ $payment->payment_method == 'bank' ? 'selected' : '' }}>Bank</option>
                                        <option value="mobile_money" {{ $payment->payment_method == 'mobile_money' ? 'selected' : '' }}>Mobile Money</option>
                                    </select>
                                    <label for="payment_method">Payment Method</label>
                                    @error('payment_method')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" step="0.01" readonly
                                        class="form-control @error('total_amount') is-invalid @enderror" id="total_amount"
                                        name="total_amount" placeholder="Total Amount"
                                        value="{{ $payment->type == 'vendor' ? number_format($payment->vendor->total_amount ?? 0, 2, '.', '') : number_format($payment->vehicle->total_amount ?? 0, 2, '.', '') }}">
                                    <label for="total_amount">Total Amount</label>
                                    @error('total_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">

                                    <input type="number" step="0.01"
                                        class="form-control @error('amount') is-invalid @enderror"
                                        name="amount" placeholder="Amount" value="{{ number_format($payment->amount, 2, '.', '') }}" required>
                                    <label for="amount">Amount</label>
                                    @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" step="0.01" readonly
                                        class="form-control @error('remaining_amount') is-invalid @enderror"
                                        id="remaining_amount" name="remaining_amount" placeholder="Remaining Amount"
                                        value="{{ $payment->type == 'vendor' ? number_format($payment->vendor->remaining_amount ?? 0, 2, '.', '') : number_format($payment->vehicle->remaining_amount ?? 0, 2, '.', '') }}">
                                    <label for="remaining_amount">Remaining Amount</label>
                                    @error('remaining_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-floating">
                                    <textarea class="form-control" id="remarks" name="remarks" placeholder="Remarks">{{ old('remarks', $payment->remarks) }}</textarea>
                                    <label for="remarks">Remarks</label>
                                </div>
                            </div>

                            <div>
                                <button type="submit" class="btn btn-outline-primary">Update Payment</button>
                                <button type="reset" class="btn btn-outline-secondary">Reset</button>
                            </div>
                        </form><!-- End Edit Payment Form -->

                    </div>
                </div>
            </div>
        </section>
    </main><!-- End #main -->
@endsection

@section('scripts')

<script src="{{ url('admin_theme/assets/js/vendor.js') }}"></script>
<script src="{{ url('admin_theme/assets/js/vehicle.js') }}"></script>
<script>
    var baseUrl = '{{ url('/') }}';
</script>

    <script>
        function handleTypeChange() {
            const type = document.getElementById('typeField').value;
            const vendorSelect = document.getElementById('vendorSelect');
            const vehicleSelect = document.getElementById('vehicleSelect');

            // Reset amounts
            $('#total_amount').val('0.00');
            $('#remaining_amount').val('0.00');
            $('#amount').val('0.00');

            if (type === 'vendor') {
                vendorSelect.style.display = 'block';
                vehicleSelect.style.display = 'none';
                $('#vehicleId').val('').trigger('change');
            } else if (type === 'vehicle') {
                vendorSelect.style.display = 'none';
                vehicleSelect.style.display = 'block';
                $('#vendorId').val('').trigger('change');
            } else {
                vendorSelect.style.display = 'none';
                vehicleSelect.style.display = 'none';
            }
        }

        function getVendorAmounts(type, value) {
            if (value) {
                $.ajax({
                    url: '{{ route('getVendorAmounts') }}',
                    type: 'GET',
                    data: {
                        type: type,
                        [type === 'vendor' ? 'vendor_id' : 'vehicle_id']: value
                    },
                    success: function(response) {
                        $('#total_amount').val(parseFloat(response.total_amount).toFixed(2));
                        $('#remaining_amount').val(parseFloat(response.remaining_amount).toFixed(2));
                        // Keep existing amount value instead of resetting
                        if (!$('#amount').val()) {
                            $('#amount').val('0.00');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching amounts:', error);
                        $('#total_amount, #remaining_amount').val('0.00');
                        if (!$('#amount').val()) {
                            $('#amount').val('0.00');
                        }
                    }
                });
            }
        }
        // Call handleTypeChange on page load to handle initial state
        document.addEventListener('DOMContentLoaded', function() {
            handleTypeChange();
            // Show initial values without resetting amount
            const type = document.getElementById('typeField').value;
            if (type === 'vendor') {
                getVendorAmounts('vendor', document.getElementById('vendorId').value);
            } else if (type === 'vehicle') {
                getVendorAmounts('vehicle', document.getElementById('vehicleId').value);
            }
        });
    </script>
@endsection
