@extends('admin.layouts.master')
@section('title', 'Create Customer')
@section('main-container')

<main id="main" class="main">

    <div class="pagetitle">
      <h1>Create Customer</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item"><a href="{{ route('customers.index') }}">Customers</a></li>
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
                <h5 class="card-title">Create New Customer</h5>
                <a href="{{ route('customers.index') }}" class="btn btn-outline-secondary">
                  <i class="bi bi-arrow-left"></i> Back
                </a>
              </div>

              <!-- Create Customer Form -->
              <form class="row g-3" method="POST" action="{{ route('customers.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Full Name" value="{{ old('name') }}" required>
                    <label for="name">Full Name</label>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email Address" value="{{ old('email') }}" required>
                    <label for="email">Email Address</label>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="tel" class="form-control @error('mobile') is-invalid @enderror" id="mobile" name="mobile" placeholder="Mobile Number" value="{{ old('mobile') }}" required>
                    <label for="mobile">Mobile Number</label>
                    @error('mobile')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="date" class="form-control @error('dob') is-invalid @enderror" id="dob" name="dob" value="{{ old('dob') }}" required>
                    <label for="dob">Date of Birth</label>
                    @error('dob')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-floating">
                    <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                      <option value="">Select Gender</option>
                      <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                      <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                      <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    <label for="gender">Gender</label>
                    @error('gender')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                    <label for="image">Profile Image</label>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-floating">
                    <input type="text" class="form-control @error('gst_number') is-invalid @enderror" id="gst_number" name="gst_number" placeholder="GST Number" value="{{ old('gst_number') }}">
                    <label for="gst_number">GST Number</label>
                    @error('gst_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-floating">
                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" placeholder="Address" style="height: 100px">{{ old('address') }}</textarea>
                    <label for="address">Address</label>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="form-check form-switch">
                    <input class="form-check-input @error('status') is-invalid @enderror" type="checkbox" id="status" name="status" value="1" checked>
                    <label class="form-check-label" for="status">Status </label>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div>
                  <button type="submit" class="btn btn-outline-primary">Create</button>
                  <button type="reset" class="btn btn-outline-secondary">Reset</button>
                </div>
              </form><!-- End Create Customer Form -->

            </div>
          </div>
      </div>
    </section>
  </main><!-- End #main -->
@endsection
