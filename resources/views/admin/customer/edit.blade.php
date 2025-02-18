@extends('admin.layouts.master')
@section('title', 'Edit Customer')
@section('main-container')

    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Edit Customer</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('customers.index') }}">Customers</a></li>
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
                            <h5 class="card-title">Edit Customer</h5>
                            <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left"></i> Back
                            </a>
                        </div>

                        <!-- Edit Customer Form -->
                        <form class="row g-3" method="POST" action="{{ route('customers.update', $customer->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" name="name" placeholder="Full Name"
                                        value="{{ old('name', $customer->name) }}" required>
                                    <label for="name">Full Name</label>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" placeholder="Email Address"
                                        value="{{ old('email', $customer->email) }}" required>
                                    <label for="email">Email Address</label>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="tel" class="form-control @error('mobile') is-invalid @enderror"
                                        id="mobile" name="mobile" placeholder="Mobile Number"
                                        value="{{ old('mobile', $customer->mobile) }}" required>
                                    <label for="mobile">Mobile Number</label>
                                    @error('mobile')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>



                            <div class="col-md-3">
                                <div class="form-floating">
                                    <select class="form-select @error('gender') is-invalid @enderror" id="gender"
                                        name="gender" required>
                                        <option value="">Select Gender</option>
                                        <option value="male"
                                            {{ old('gender', $customer->gender) == 'male' ? 'selected' : '' }}>Male
                                        </option>
                                        <option value="female"
                                            {{ old('gender', $customer->gender) == 'female' ? 'selected' : '' }}>Female
                                        </option>
                                        <option value="other"
                                            {{ old('gender', $customer->gender) == 'other' ? 'selected' : '' }}>Other
                                        </option>
                                    </select>
                                    <label for="gender">Gender</label>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-floating">
                                    <input type="date" class="form-control @error('dob') is-invalid @enderror"
                                        id="dob" name="dob" value="{{ old('dob', $customer->dob) }}" required>
                                    <label for="dob">Date of Birth</label>
                                    @error('dob')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                                        id="image" name="image">
                                    <label for="image">Profile Image</label>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                @if ($customer->image)
                                    <div class="mt-2">
                                        <img src="{{ asset('images/customer/' . $customer->image) }}" alt="Profile Image"
                                            class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating input-group">
                                    <select class="form-select @error('gst_code') is-invalid @enderror" id="gst_code"
                                        name="gst_code" style="max-width: 200px;">
                                        <option value="">Select GST Code</option>
                                        @foreach ($gsts as $gst)
                                            <option value="{{ $gst->gst_code }}"
                                                {{ old('gst_code', $customer->gst_code) == $gst->gst_code ? 'selected' : '' }}>
                                                {{ $gst->name }} ({{ $gst->gst_code }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('gst_number') is-invalid @enderror"
                                            id="gst_number" name="gst_number" placeholder="GST Number"
                                            value="{{ old('gst_number', $customer->gst_number) }}">
                                        <label for="gst_number">GST Number</label>
                                    </div>
                                    @error('gst_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @error('gst_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating">
                                  <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" placeholder="Address" value="{{ old('address', $customer->address) }}">
                                  <label for="address">Address</label>
                                  @error('address')
                                      <div class="invalid-feedback">{{ $message }}</div>
                                  @enderror
                                </div>
                              </div>

                              <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('city') is-invalid @enderror"
                                        id="city" name="city" placeholder="City"
                                        value="{{ old('city', $customer->city) }}" required>
                                    <label for="city">City</label>
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('state') is-invalid @enderror"
                                        id="state" name="state" placeholder="State"
                                        value="{{ old('state', $customer->state) }}" required>
                                    <label for="state">State</label>
                                    @error('state')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('country') is-invalid @enderror"
                                        id="country" name="country" placeholder="Country"
                                        value="{{ old('country', $customer->country) }}" required>
                                    <label for="country">Country</label>
                                    @error('country')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('zipcode') is-invalid @enderror"
                                        id="zipcode" name="zipcode" placeholder="Zipcode"
                                        value="{{ old('zipcode', $customer->zipcode) }}" required>
                                    <label for="zipcode">Zipcode</label>
                                    @error('zipcode')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input @error('status') is-invalid @enderror" type="checkbox"
                                        id="status" name="status" value="1"
                                        {{ old('status', $customer->status) ? 'checked' : '' }}>
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
                        </form><!-- End Edit Customer Form -->

                    </div>
                </div>
            </div>
        </section>
    </main><!-- End #main -->
@endsection
