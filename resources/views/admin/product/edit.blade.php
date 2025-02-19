@extends('admin.layouts.master')
@section('title', 'Edit Product')
@section('main-container')

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Edit Product</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
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
                            <h5 class="card-title">Edit Product</h5>
                            <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> Back
                            </a>
                        </div>

                        <!-- Edit Product Form -->
                        <form class="row g-3" method="POST" action="{{ route('products.update', $product->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" placeholder="Product Name"
                                        value="{{ old('name', $product->name) }}" required>
                                    <label for="name">Product Name <span class="text-danger">*</span></label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('hsn_code') is-invalid @enderror"
                                        id="hsn_code" name="hsn_code" placeholder="HSN Code"
                                        value="{{ old('hsn_code', $product->hsn_code) }}" required>
                                    <label for="hsn_code">HSN Code</label>
                                    @error('hsn_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('grade') is-invalid @enderror"
                                        id="grade" name="grade" placeholder="Grade"
                                        value="{{ old('grade', $product->grade) }}" required>
                                    <label for="grade">Grade</label>
                                    @error('grade')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <select class="form-select @error('tax_id') is-invalid @enderror" id="tax_id"
                                        name="tax_id" required>
                                        <option value="">Select Tax Rate</option>
                                        @foreach ($taxes as $tax)
                                            <option value="{{ $tax->id }}"
                                                {{ old('tax_id', $product->tax_id) == $tax->id ? 'selected' : '' }}>
                                                {{ $tax->tax_name }} ({{ $tax->tax_rate }}%)
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="tax_id">Tax Rate</label>
                                    @error('tax_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="number" step="0.01"
                                        class="form-control @error('price') is-invalid @enderror" id="price"
                                        name="price" placeholder="Price" value="{{ old('price', $product->price) }}"
                                        required>
                                    <label for="price">Price <span class="text-danger">*</span></label>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                                        id="image" name="image" accept="image/*">
                                    <label for="image">Product Image</label>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                @if ($product->image)
                                    <div class="mt-2">
                                        <img src="{{ asset('images/product/' . $product->image) }}" alt="Product Image"
                                            class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-12">
                                <div class="form-check form-switch">
                                  <input class="form-check-input @error('status') is-invalid @enderror" type="checkbox" id="status" name="status" value="1" {{ old('status', $product->status) ? 'checked' : '' }}>
                                  <label class="form-check-label" for="status">Status</label>
                                  @error('status')
                                      <div class="invalid-feedback">{{ $message }}</div>
                                  @enderror
                                </div>
                              </div>

                            <div>
                                <button type="submit" class="btn btn-outline-primary">Update</button>
                                <button type="reset" class="btn btn-outline-secondary">Reset</button>
                            </div>
                        </form><!-- End Edit Product Form -->

                    </div>
                </div>
            </div>
        </section>
    </main><!-- End #main -->
@endsection
