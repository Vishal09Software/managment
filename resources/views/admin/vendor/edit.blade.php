@extends('admin.layouts.master')
@section('title', 'Edit Vendor')
@section('main-container')

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Edit Vendor</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('vendors.index') }}">Vendors</a></li>
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
                <h5 class="card-title">Edit Vendor</h5>
                <a href="{{ route('vendors.index') }}" class="btn btn-outline-secondary">
                  <i class="bi bi-arrow-left"></i> Back
                </a>
              </div>

              <!-- Edit Vendor Form -->
              <form class="row g-3" method="POST" action="{{ route('vendors.update', $vendor->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Full Name" value="{{ old('name', $vendor->name) }}" required>
                    <label for="name">Full Name</label>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email Address" value="{{ old('email', $vendor->email) }}" required>
                    <label for="email">Email Address</label>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="tel" class="form-control @error('mobile') is-invalid @enderror" id="mobile" name="mobile" placeholder="Mobile Number" value="{{ old('mobile', $vendor->mobile) }}" required>
                    <label for="mobile">Mobile Number</label>
                    @error('mobile')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="text" class="form-control @error('gst_number') is-invalid @enderror" id="gst_number" name="gst_number" placeholder="GST Number" value="{{ old('gst_number', $vendor->gst_number) }}" required>
                    <label for="gst_number">GST Number</label>
                    @error('gst_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-floating">
                    <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                      <option value="">Select Gender</option>
                      <option value="male" {{ old('gender', $vendor->gender) == 'male' ? 'selected' : '' }}>Male</option>
                      <option value="female" {{ old('gender', $vendor->gender) == 'female' ? 'selected' : '' }}>Female</option>
                      <option value="other" {{ old('gender', $vendor->gender) == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    <label for="gender">Gender</label>
                    @error('gender')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="date" class="form-control @error('dob') is-invalid @enderror" id="dob" name="dob" placeholder="Date of Birth" value="{{ old('dob', $vendor->dob) }}" required>
                    <label for="dob">Date of Birth</label>
                    @error('dob')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="text" class="form-control @error('city') is-invalid @enderror" id="city" name="city" placeholder="City" value="{{ old('city', $vendor->city) }}" required>
                    <label for="city">City</label>
                    @error('city')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="text" class="form-control @error('state') is-invalid @enderror" id="state" name="state" placeholder="State" value="{{ old('state', $vendor->state) }}" required>
                    <label for="state">State</label>
                    @error('state')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="text" class="form-control @error('country') is-invalid @enderror" id="country" name="country" placeholder="Country" value="{{ old('country', $vendor->country) }}" required>
                    <label for="country">Country</label>
                    @error('country')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="text" class="form-control @error('zip_code') is-invalid @enderror" id="zip_code" name="zip_code" placeholder="ZIP Code" value="{{ old('zip_code', $vendor->zip_code) }}" required>
                    <label for="zip_code">ZIP Code</label>
                    @error('zip_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                    <label for="image">Profile Image</label>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                  @if($vendor->image)
                    <div class="mt-2">
                      <img src="{{ asset('images/vendor/'.$vendor->image) }}" alt="Profile Image" class="img-thumbnail" style="max-width: 200px;">
                    </div>
                  @endif
                </div>

                <div class="col-md-12">
                    <div class="form-floating">
                      <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" placeholder="Address" required>{{ old('address', $vendor->address) }}</textarea>
                      <label for="address">Address</label>
                      @error('address')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                </div>

                <div class="col-md-12">
                  <div class="form-check form-switch">
                    <input class="form-check-input @error('status') is-invalid @enderror" type="checkbox" id="status" name="status" value="1" {{ old('status', $vendor->status) ? 'checked' : '' }}>
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
              </form><!-- End Edit Vendor Form -->

            </div>
          </div>
      </div>
    </section>
  </main><!-- End #main -->
@endsection
