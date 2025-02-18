@extends('admin.layouts.master')
@section('title', 'Payment In')
@section('main-container')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Payment In</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Payments In</li>
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
                                    <a href="{{ route('transactions-in.export', [
                                        'date_from' => request('date_from'),
                                        'date_to' => request('date_to'),
                                        'customer_id' => request('customer_id'),
                                        'payment_method' => request('payment_method')
                                    ]) }}" class="btn btn-outline-success me-2">
                                        <i class="bi bi-file-earmark-excel me-1"></i> Export
                                    </a>
                                    <a href="{{ route('transactions-in.create') }}" class="btn btn-outline-primary"><i
                                            class="bi bi-plus-circle me-1"></i> Create Payment</a>
                                </div>
                            </div>

                            <!-- Custom Search Filters -->
                            <form action="{{ route('transactions-in.index') }}" method="GET"
                                class="row mb-3 justify-content-center">
                                <div class="col-md-2">
                                    <div class="form-floating">
                                        <input type="date" class="form-control shadow-sm" name="date_from"
                                            id="startDateField" placeholder="Start Date" value="{{ request('date_from') }}">
                                        <label for="startDateField">Start Date</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-floating">
                                        <input type="date" class="form-control shadow-sm" name="date_to"
                                            id="endDateField" placeholder="End Date" value="{{ request('date_to') }}">
                                        <label for="endDateField">End Date</label>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-floating">
                                        <select class="form-select shadow-sm select2" name="customer_id"
                                            id="customerField">
                                            <option value="">Select Customer</option>
                                            @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                                    {{ $customer->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-floating">
                                        <select class="form-select shadow-sm" name="payment_method"
                                            id="methodField">
                                            <option value="">Select Method</option>
                                            <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                            <option value="bank" {{ request('payment_method') == 'bank' ? 'selected' : '' }}>Bank</option>
                                            <option value="mobile_money" {{ request('payment_method') == 'mobile_money' ? 'selected' : '' }}>Mobile Money</option>
                                        </select>
                                        <label for="methodField">Payment Method</label>
                                    </div>
                                </div>

                                <div class="col-md-2 text-center mt-2">
                                    <button type="submit" class="btn btn-outline-primary shadow-sm me-2" title="Search">
                                        <i class="bi bi-search"></i>
                                    </button>
                                    <a href="{{ route('transactions-in.index') }}" class="btn btn-outline-secondary shadow-sm"
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
                                        <th><b>Customer</b></th>
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
                                            <td>{{ $payment->customer->name ?? 'N/A' }}</td>
                                            <td>{{ number_format($payment->amount, 2) }}</td>
                                            <td>{{ ucwords($payment->payment_method) }}</td>
                                            <td>{{ $payment->payment_date }}</td>
                                            <td>
                                                <a href="{{ route('transactions-in.receipt', $payment->id) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-printer"></i>
                                                </a>

                                                <a href="{{ route('transactions-in.edit', $payment->id) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteModal{{ $payment->id }}">
                                                    <i class="bi bi-trash"></i>
                                                </button>

                                                <!-- Delete Modal -->
                                                <div class="modal fade" id="deleteModal{{ $payment->id }}"
                                                    tabindex="-1">
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
                                                                    action="{{ route('transactions-in.destroy', $payment->id) }}"
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
                                            <td colspan="7" class="text-center">No payments found</td>
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
     $("#customerField").select2({
            placeholder: "Select Customer",
            allowClear: true,
            width: '100%',
            theme: 'bootstrap-5',
            minimumInputLength: 1,
            ajax: {
                url: '{{ route('customerSearch') }}',
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        search: params.term
                    };
                },
                processResults: function(data) {
                    return {
                        results: data.map(function(customer) {
                            return {
                                id: customer.id,
                                text: customer.name
                            };
                        })
                    };
                },
                cache: true
            }
        });
</script>
@endsection
