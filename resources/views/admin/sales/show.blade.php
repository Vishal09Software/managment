@extends('admin.layouts.master')
@section('title', 'Sale Details')
@section('main-container')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Sale Details</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('sales.index') }}">Sales</a></li>
                    <li class="breadcrumb-item active">Sale Details</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title">Sale Information</h5>
                                <a href="{{ route('sales.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left"></i> Back
                                </a>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Basic Details</h6>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="30%">Date</th>
                                            <td>{{ date('d M Y', strtotime($sale->date)) }}</td>
                                        </tr>
                                        <tr>
                                            <th>E-way Bill Number</th>
                                            <td>{{ $sale->eway_bill_number }}</td>
                                        </tr>
                                        <tr>
                                            <th>Driver Name</th>
                                            <td>{{ $sale->driver_name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Driver Phone</th>
                                            <td>{{ $sale->driver_phone }}</td>
                                        </tr>
                                        <tr>
                                            <th>Vehicle Number</th>
                                            <td>{{ $sale->vehicle_number }}</td>
                                        </tr>
                                        <tr>
                                            <th>Vehicle Rate</th>
                                            <td>₹{{ number_format($sale->vehicle_rate, 2) }}</td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="col-md-6">
                                    <h6>Weight & Price Details</h6>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="30%">Product Name</th>
                                            <td>{{ $sale->product->name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th width="30%">Rawana Weight</th>
                                            <td>{{ $sale->r_weight }}</td>
                                        </tr>
                                        <tr>
                                            <th>Kanta Weight</th>
                                            <td>{{ $sale->k_weight }}</td>
                                        </tr>
                                        <tr>
                                            <th>Purchase Price</th>
                                            <td>₹{{ number_format($sale->p_price, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Sale Price</th>
                                            <td>₹{{ number_format($sale->s_price, 2) }}</td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="col-md-6 mt-4">
                                    <h6>Vendor Details</h6>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="30%">Name</th>
                                            <td>{{ $sale->vendor_name }}</td>
                                        </tr>
                                        <tr>
                                            <th width="30%">Mobile</th>
                                            <td>{{ $sale->vendor_mobile }}</td>
                                        </tr>

                                    </table>
                                </div>

                                <div class="col-md-6 mt-4">
                                    <h6>Customer Details</h6>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="30%">Name</th>
                                            <td>{{ $sale->customer_name }}</td>
                                        </tr>
                                        <tr>
                                            <th width="30%">Mobile</th>
                                            <td>{{ $sale->customer_mobile }}</td>
                                        </tr>
                                        <tr>
                                            <th width="30%">Supply Address</th>
                                            <td>{{ $sale->supply_place ?? 'N/A' }}</td>
                                        </tr>

                                    </table>
                                </div>

                                <div class="col-md-12 mt-4">
                                    <h6>Financial Details</h6>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="30%">Tax</th>
                                            <td>{{ $sale->tax_name ?? 'N/A' }} ({{ $sale->tax_rate ?? '0' }}%)</td>
                                        </tr>
                                        <tr>
                                            <th width="30%">Purchase Total</th>
                                            <td>₹{{ number_format($sale->p_total ?? 0, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th width="30%">Sale Total</th>
                                            <td>₹{{ number_format($sale->s_total ?? 0, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th width="30%">Remark</th>
                                            <td>{{ $sale->remark ?? 'No remarks' }}</td>
                                        </tr>
                                    </table>
                                </div>

                                @if($sale->image)
                                <div class="col-md-12 mt-4">
                                    <h6>Attached Document</h6>
                                    <img src="{{ asset('images/sales/' . $sale->image) }}" alt="Sale Document" class="img-fluid" style="max-width: 300px;">
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
