@extends('admin.layouts.master')
@section('title', 'Create Payment')
@section('main-container')

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Create Payment</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('transactions-in.index') }}">Payments In</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            @include('admin.layouts.flashmsg')
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Create New Payment</h5>
                            <a href="{{ route('transactions-in.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> Back
                            </a>
                        </div>

                        <!-- Create Payment Form -->
                        <form class="row g-3" method="POST" action="{{ route('transactions-in.store') }}">
                            @csrf

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select class="form-select select2 @error('customer_id') is-invalid @enderror"
                                        id="customerId" name="customer_id" required>
                                        <option value="">Select Customer</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}"
                                                {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                                {{ $customer->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('customer_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="date" class="form-control @error('payment_date') is-invalid @enderror"
                                        id="payment_date" name="payment_date"
                                        value="{{ old('payment_date', date('Y-m-d')) }}" required>
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
                                        <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="bank" {{ old('payment_method') == 'bank' ? 'selected' : '' }}>Bank</option>
                                        <option value="mobile_money" {{ old('payment_method') == 'mobile_money' ? 'selected' : '' }}>Mobile Money</option>
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
                                        value="{{ old('total_amount', 0) }}">
                                    <label for="total_amount">Total Amount</label>
                                    @error('total_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" step="0.01" min="0"
                                        class="form-control @error('amount') is-invalid @enderror" id="amount"
                                        name="amount" placeholder="Amount" value="{{ old('amount') }}" required>
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
                                        value="{{ old('remaining_amount', 0) }}">
                                    <label for="remaining_amount">Remaining Amount</label>
                                    @error('remaining_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-floating">
                                    <textarea class="form-control" id="remarks" name="remarks" placeholder="Remarks">{{ old('remarks') }}</textarea>
                                    <label for="remarks">Remarks</label>
                                </div>
                            </div>

                            <div>
                                <button type="submit" class="btn btn-outline-primary">Create Payment</button>
                                <button type="reset" class="btn btn-outline-secondary">Reset</button>
                            </div>
                        </form><!-- End Create Payment Form -->

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
        $('#customerId').on('change', function() {
            let customerId = $(this).val();
            if (customerId) {
                $.ajax({
                    url: "{{ route('getCustomerAmounts', '') }}/" + customerId,
                    type: "GET",
                    dataType: "json",
                    success: function (response) {
                        let totalAmount = response.total_amount;
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
