@extends('admin.layouts.master')
@section('title', 'Edit Payment')
@section('main-container')

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Edit Payment</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('transactions-in.index') }}">Payments In</a></li>
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
                            <a href="{{ route('transactions-in.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> Back
                            </a>
                        </div>

                        <!-- Edit Payment Form -->
                        <form class="row g-3" method="POST"
                            action="{{ route('transactions-in.update', $payment->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select select2 @error('customer_id') is-invalid @enderror"
                                        id="customerId" name="customer_id" required>
                                        <option value="">Select Customer</option>
                                        <option value="{{ $payment->customer_id }}" selected>
                                            {{ $payment->customer->name }}
                                        </option>
                                    </select>
                                    @error('customer_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" step="0.01"
                                        class="form-control @error('total_amount') is-invalid @enderror" id="total_amount"
                                        name="total_amount" placeholder="Total Amount" readonly>
                                    <label for="total_amount">Total Amount</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" step="0.01"
                                        class="form-control @error('amount') is-invalid @enderror" id="amount"
                                        name="amount" placeholder="Payment Amount"
                                        value="{{ old('amount', $payment->amount) }}" required>
                                    <label for="amount">Payment Amount</label>
                                    @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" step="0.01"
                                        class="form-control @error('remaining_amount') is-invalid @enderror"
                                        id="remaining_amount" name="remaining_amount" placeholder="Remaining Amount"
                                        value="{{ old('remaining_amount', $payment->remaining_amount) }}" readonly>
                                    <label for="remaining_amount">Remaining Amount</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select @error('payment_method') is-invalid @enderror"
                                        id="payment_method" name="payment_method" required>
                                        <option value="">Select Payment Method</option>
                                        <option value="cash" {{ $payment->payment_method == 'cash' ? 'selected' : '' }}>
                                            Cash</option>
                                        <option value="bank" {{ $payment->payment_method == 'bank' ? 'selected' : '' }}>
                                            Bank</option>
                                        <option value="mobile_money"
                                            {{ $payment->payment_method == 'mobile_money' ? 'selected' : '' }}>Mobile Money
                                        </option>
                                    </select>
                                    <label for="payment_method">Payment Method</label>
                                    @error('payment_method')
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

                            <div class="col-md-12">
                                <div class="form-floating">
                                    <textarea class="form-control" id="remark" name="remarks" placeholder="Remark">{{ old('remark', $payment->remarks) }}</textarea>
                                    <label for="remark">Remark</label>
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

    <script src="{{ url('admin_theme/assets/js/customer.js') }}"></script>
    <script>
        var baseUrl = '{{ url('/') }}';
    </script>

    <script>
        // Load initial amounts on page load for selected customer
        $(document).ready(function () {
            let customerId = $('#customerId').val();
            if (customerId) {
                $.ajax({
                    url: "{{ route('getCustomerAmounts', '') }}/" + customerId,
                    type: "GET",
                    dataType: "json",
                    success: function (response) {
                        let totalAmount = response.total_amount;
                        let amount = $('#amount').val();
                        $('#total_amount').val(totalAmount);
                        $('#remaining_amount').val(response.remaining_amount.toFixed(2));
                    },
                    error: function () {
                        alert("Error fetching customer data. Please try again.");
                    }
                });
            }
        });

    </script>
@endsection
