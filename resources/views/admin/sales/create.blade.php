@extends('admin.layouts.master')
@section('title', 'Create Sale')
@section('main-container')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Create Sale</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('sales.index') }}">Sales</a></li>
                    <li class="breadcrumb-item active">Create Sale</li>
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
                                <h5 class="card-title">Create New Sale</h5>
                                <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left"></i> Back
                                </a>
                            </div>

                            <form action="{{ route('sales.store') }}" method="POST" class="row g-3"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="date" class="form-control" name="date" id="date"
                                            placeholder="Date" value="{{ date('Y-m-d') }}" required>
                                        <label for="date">Date</label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <select class="form-control select2" name="vendor_id" id="vendorId" required>
                                            <option value="">Select Vendor</option>
                                            @foreach($vendors as $vendor)
                                                <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <select class="form-control select2" name="customer_id" id="customerId" required>
                                            <option value="">Select Customer</option>
                                            @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="eway_bill_number" id="ewayBill"
                                            placeholder="E-way Bill Number">
                                        <label for="ewayBill">E-way Bill Number</label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <select class="form-control select2" name="vehicle_id" id="vehicleId" required>
                                            <option value="">Select Vehicle</option>
                                            @foreach($vehicles as $vehicle)
                                                <option value="{{ $vehicle->id }}">
                                                    {{ $vehicle->driver_name ? $vehicle->driver_name . ' (' . $vehicle->vehicle_number . ')' : $vehicle->owner_name . ' (' . $vehicle->vehicle_name . ')' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" name="vehicle_rate" id="vehicleRate"
                                            placeholder="Vehicle Rate" required>
                                        <label for="vehicleRate">Vehicle Rate</label>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="form-floating">
                                        <input type="file" class="form-control" name="image" id="purchaseImage" accept="image/*">
                                        <label for="purchaseImage">Purchase Image</label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" name="r_weight" id="rawanaWeight"
                                            placeholder="Rawana Weight">
                                        <label for="rawanaWeight">Rawana Weight</label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" name="k_weight" id="kantaWeight"
                                            placeholder="Kanta Weight" onchange="calculateTotals()">
                                        <label for="kantaWeight">Kanta Weight</label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="supply_place" id="supplyPlace" placeholder="Supply Place">
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
                                                                    data-price="{{ $product->price }}">
                                                                    {{ $product->name }}</option>
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
                                                            onchange="calculateTotals()">
                                                        <label>Purchase Price</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-floating">
                                                        <input type="number" class="form-control sale-price"
                                                            name="s_price" id="salePrice" placeholder="Sale Price"
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
                                                                <option value="{{ $tax->id }}" data-tax-rate="{{ $tax->tax_rate }}">
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
                                                            placeholder="Remark">
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
                                            name="p_total" readonly>
                                        <label for="purchaseTotal">Purchase Total</label>
                                    </div>
                                </div>
                                <div class="col-md-4 offset-md-8">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="saleTotal" name="s_total"
                                            readonly>
                                        <label for="saleTotal">Sale Total</label>
                                    </div>
                                </div>

                                <div class="col-md-4 offset-md-8">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="vehicleTotal" name="v_total" readonly>
                                        <label for="vehicleTotal">Vehicle Total </label>
                                    </div>
                                </div>

                                <div>
                                    <button type="submit" class="btn btn-outline-primary">Create Sale</button>
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


<script src="{{ url('admin_theme/assets/js/vendor.js') }}"></script>
<script src="{{ url('admin_theme/assets/js/customer.js') }}"></script>
<script src="{{ url('admin_theme/assets/js/vehicle.js') }}"></script>
<script src="{{ url('admin_theme/assets/js/sale.js') }}"></script>

<script>
    var baseUrl = '{{ url('/') }}';
</script>
@endsection
