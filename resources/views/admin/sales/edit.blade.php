@extends('admin.layouts.master')
@section('title', 'Edit Sale')
@section('main-container')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Edit Sale</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('sales.index') }}">Sales</a></li>
                    <li class="breadcrumb-item active">Edit Sale</li>
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
                                <h5 class="card-title">Edit Sale</h5>
                                <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left"></i> Back
                                </a>
                            </div>

                            <form action="{{ route('sales.update', $sale->id) }}" method="POST" class="row g-3"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" name="date" id="date"
                                            placeholder="Date" value="{{ $sale->date }}" required>
                                        <label for="date">Date</label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <select class="form-control select2" name="vendor_id" id="vendorId" required>
                                            <option value="">Select Vendor</option>
                                            @foreach($vendors as $vendor)
                                                <option value="{{ $vendor->id }}" {{ $sale->vendor_id == $vendor->id ? 'selected' : '' }}>
                                                    {{ $vendor->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <select class="form-control select2" name="customer_id" id="customerId" required>
                                            <option value="">Select Customer</option>
                                            @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}" {{ $sale->customer_id == $customer->id ? 'selected' : '' }}>
                                                    {{ $customer->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="eway_bill_number" id="ewayBill"
                                            placeholder="E-way Bill Number" value="{{ $sale->eway_bill_number }}">
                                        <label for="ewayBill">E-way Bill Number</label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <select class="form-control select2" name="vehicle_id" id="vehicleId" required>
                                            <option value="">Select Vehicle</option>
                                            @foreach($vehicles as $vehicle)
                                                <option value="{{ $vehicle->id }}" {{ $sale->vehicle_id == $vehicle->id ? 'selected' : '' }}>
                                                    {{ $vehicle->driver_name ? $vehicle->driver_name . ' (' . $vehicle->vehicle_number . ')' : $vehicle->owner_name . ' (' . $vehicle->vehicle_number . ')' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" name="vehicle_rate" id="vehicleRate"
                                            placeholder="Vehicle Rate" value="{{ $sale->vehicle_rate }}" required>
                                        <label for="vehicleRate">Vehicle Rate</label>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="form-floating">
                                        <input type="file" class="form-control" name="image" id="purchaseImage" accept="image/*">
                                        <label for="purchaseImage">Purchase Image</label>
                                        @if($sale->image)
                                            <img src="{{ asset('images/sales/'.$sale->image) }}" width="100" class="mt-2">
                                        @endif
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" name="r_weight" id="rawanaWeight"
                                            placeholder="Rawana Weight" value="{{ $sale->r_weight }}">
                                        <label for="rawanaWeight">Rawana Weight</label>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" name="k_weight" id="kantaWeight"
                                            placeholder="Kanta Weight" value="{{ $sale->k_weight }}" onchange="calculateTotals()">
                                        <label for="kantaWeight">Kanta Weight</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="supply_place" id="supplyPlace" placeholder="Supply Place" value="{{ $sale->supply_place }}">
                                        <label for="supplyPlace">Supply Place</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Sale Item</h5>
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-floating">
                                                        <select class="form-select product-select" name="product_id"
                                                            id="productSelect" required>
                                                            <option value="">Select Product</option>
                                                            @foreach ($products as $product)
                                                                <option value="{{ $product->id }}"
                                                                    data-tax-id="{{ $product->tax->id }}"
                                                                    data-tax="{{ $product->tax->tax_rate }}"
                                                                    data-tax-name="{{ $product->tax->tax_name }}"
                                                                    data-price="{{ $product->price }}"
                                                                    {{ $sale->product_id == $product->id ? 'selected' : '' }}>
                                                                    {{ $product->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <label>Product</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-floating">
                                                        <input type="number" class="form-control purchase-price"
                                                            name="p_price" id="purchasePrice"
                                                            placeholder="Purchase Price" required
                                                            value="{{ $sale->p_price }}"
                                                            onchange="calculateTotals()">
                                                        <label>Purchase Price</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-floating">
                                                        <input type="number" class="form-control sale-price"
                                                            name="s_price" id="salePrice"
                                                            placeholder="Sale Price"
                                                            value="{{ $sale->s_price }}"
                                                            required onchange="calculateTotals()">
                                                        <label>Sale Price</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-floating">
                                                        <select class="form-select tax" name="tax_id" id="taxSelect"
                                                            required>
                                                            <option value="">Select Tax</option>
                                                            @foreach ($taxes as $tax)
                                                                <option value="{{ $tax->id }}"
                                                                    data-tax-rate="{{ $tax->tax_rate }}"
                                                                    {{ $sale->tax_id == $tax->id ? 'selected' : '' }}>
                                                                    {{ $tax->tax_name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <label>Tax %</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control remark" name="remark"
                                                            placeholder="Remark" value="{{ $sale->remark }}">
                                                        <label>Remark</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 offset-md-8">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="purchaseTotal"
                                            name="p_total" value="{{ $sale->p_total }}" readonly>
                                        <label for="purchaseTotal">Purchase Total</label>
                                    </div>
                                </div>

                                <div class="col-md-4 offset-md-8">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="saleTotal" name="s_total"
                                            value="{{ $sale->s_total }}" readonly>
                                        <label for="saleTotal">Sale Total</label>
                                    </div>
                                </div>

                                <div class="col-md-4 offset-md-8">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="vehicleTotal" name="v_total"
                                            value="{{ $sale->v_total }}" readonly>
                                        <label for="vehicleTotal">Vehicle Total </label>
                                    </div>
                                </div>

                                <div>
                                    <button type="submit" class="btn btn-outline-primary">Update Sale</button>
                                    <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary">Cancel</a>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            let itemCount = 1;

            // Handle product selection change
            $('#productSelect').change(function() {
                let selectedOption = $(this).find('option:selected');
                let price = selectedOption.data('price');
                let taxId = selectedOption.data('tax-id');
                let taxRate = selectedOption.data('tax');
                let taxName = selectedOption.data('tax-name');

                // Set purchase price
                $('#purchasePrice').val(price);

                // Set tax
                $('#taxSelect').val(taxId);

                calculateTotals();
            });

            // Handle tax selection change
            $('#taxSelect').change(function() {
                calculateTotals();
            });

            // Initialize Select2 for vendor dropdown
            $("#vendorId").select2({
                placeholder: "Select Vendor",
                allowClear: true,
                width: '100%',
                theme: 'bootstrap-5',
                minimumInputLength: 1,
                ajax: {
                    url: '{{ route("sales.vendorsearch") }}',
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

            // Initialize Select2 for customer dropdown
            $("#customerId").select2({
                placeholder: "Select Customer",
                allowClear: true,
                width: '100%',
                theme: 'bootstrap-5',
                minimumInputLength: 1,
                ajax: {
                    url: '{{ route("customerSearch") }}',
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

            // Initialize Select2 for vehicle dropdown
            $("#vehicleId").select2({
                placeholder: "Select Vehicle",
                allowClear: true,
                width: '100%',
                theme: 'bootstrap-5',
                minimumInputLength: 1,
                ajax: {
                    url: '{{ route("sales.vehicleSearch") }}',
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
                                        vehicle.driver_name + ' (' + vehicle.vehicle_number + ')' :
                                        vehicle.owner_name + ' (' + vehicle.vehicle_number + ')'
                                };
                            })
                        };
                    },
                    cache: true
                }
            });
        });

        function calculateTotals() {
            let kantaWeight = parseFloat($('#kantaWeight').val()) || 0;
            let purchasePrice = parseFloat($('#purchasePrice').val()) || 0;
            let salePrice = parseFloat($('#salePrice').val()) || 0;
            let vehicleRate = parseFloat($('#vehicleRate').val()) || 0;
            let taxRate = parseFloat($('#taxSelect option:selected').data('tax-rate')) || 0;

            // Calculate subtotals without tax
            let purchaseSubtotal = kantaWeight * purchasePrice;
            let saleSubtotal = kantaWeight * salePrice;
            let vehicleSubtotal = kantaWeight * vehicleRate;

            // Calculate tax amounts
            let purchaseTax = (purchaseSubtotal * taxRate) / 100;
            let saleTax = (saleSubtotal * taxRate) / 100;
            let vehicleTax = (vehicleSubtotal * taxRate) / 100;

            // Calculate final totals including tax
            let purchaseTotal = purchaseSubtotal + purchaseTax;
            let saleTotal = saleSubtotal + saleTax;
            let vehicleTotal = vehicleSubtotal + vehicleTax;

            // Update the total fields
            $('#purchaseTotal').val(purchaseTotal.toFixed(2));
            $('#saleTotal').val(saleTotal.toFixed(2));
            $('#vehicleTotal').val(vehicleTotal.toFixed(2));
        }
    </script>
@endsection
