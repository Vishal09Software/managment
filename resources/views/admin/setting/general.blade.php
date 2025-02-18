@extends('admin.layouts.master')
@section('title', 'General Settings')
@section('main-container')

<main id="main" class="main">

    <div class="pagetitle">
      <h1>General Settings</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
          <li class="breadcrumb-item active">General Settings</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
        @include('admin.layouts.flashmsg')
      <div class="row">
        <div class="card">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center">
                <h5 class="card-title">Business Details</h5>
              </div>

              <!-- Business Details Form -->
              <form class="row g-3" method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
                @csrf

                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="text" class="form-control @error('business_name') is-invalid @enderror" id="business_name" name="business_name" placeholder="Business Name" value="{{ old('business_name', $settings->business_name ?? '') }}" required>
                    <label for="business_name">Business Name</label>
                    @error('business_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="text" class="form-control @error('business_phone') is-invalid @enderror" id="business_phone" name="business_phone" placeholder="Business Phone" value="{{ old('business_phone', $settings->business_phone ?? '') }}" required>
                    <label for="business_phone">Business Phone</label>
                    @error('business_phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="email" class="form-control @error('business_email') is-invalid @enderror" id="business_email" name="business_email" placeholder="Business Email" value="{{ old('business_email', $settings->business_email ?? '') }}" required>
                    <label for="business_email">Business Email</label>
                    @error('business_email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="text" class="form-control @error('business_address') is-invalid @enderror" id="business_address" name="business_address" placeholder="Business Address" value="{{ old('business_address', $settings->business_address ?? '') }}" required>
                    <label for="business_address">Business Address</label>
                    @error('business_address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="text" class="form-control @error('gst_number') is-invalid @enderror" id="gst_number" name="gst_number" placeholder="GST Number" value="{{ old('gst_number', $settings->gst_number ?? '') }}" required>
                    <label for="gst_number">GST Number</label>
                    @error('gst_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                      <label for="business_logo" class="form-label">Business Logo</label>
                      <input type="file" class="form-control @error('business_logo') is-invalid @enderror" id="business_logo" name="business_logo">
                      @if($settings->business_logo)
                        <img src="{{ asset('images/settings/' . $settings->business_logo) }}" alt="Current Logo" class="mt-2" style="max-width: 200px;">
                      @endif
                      @error('business_logo')
                          <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>

                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Bank Details</h5>
                  </div>

                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="text" class="form-control @error('bank_name') is-invalid @enderror" id="bank_name" name="bank_name" placeholder="Bank Name" value="{{ old('bank_name', $settings->bank_name ?? '') }}" required>
                    <label for="bank_name">Bank Name</label>
                    @error('bank_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="text" class="form-control @error('account_no') is-invalid @enderror" id="account_no" name="account_no" placeholder="Account Number" value="{{ old('account_no', $settings->account_no ?? '') }}" required>
                    <label for="account_no">Account Number</label>
                    @error('account_no')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="text" class="form-control @error('ifsc_code') is-invalid @enderror" id="ifsc_code" name="ifsc_code" placeholder="IFSC Code" value="{{ old('ifsc_code', $settings->ifsc_code ?? '') }}" required>
                    <label for="ifsc_code">IFSC Code</label>
                    @error('ifsc_code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="col-md-6">
                  <div class="form-floating">
                    <input type="text" class="form-control @error('account_holder_name') is-invalid @enderror" id="account_holder_name" name="account_holder_name" placeholder="Account Holder Name" value="{{ old('account_holder_name', $settings->account_holder_name ?? '') }}" required>
                    <label for="account_holder_name">Account Holder Name</label>
                    @error('account_holder_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>



                <div>
                  <button type="submit" class="btn btn-outline-primary">Save Changes</button>
                  <button type="reset" class="btn btn-outline-secondary">Reset</button>
                </div>
              </form><!-- End Business Details Form -->

            </div>
          </div>
      </div>
    </section>
  </main><!-- End #main -->
@endsection
