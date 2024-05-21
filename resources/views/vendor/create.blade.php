@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card">
            <div class="card-header">
                <div class="float-start">
                    Add New Vendor
                </div>
                <div class="float-end">
                    <a href="{{ route('vendor.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('vendor.store') }}" method="post">
                    @csrf

                    <div class="mb-3 row">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start">Bussiness Name</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('business_name') is-invalid @enderror" id="business_name" name="business_name" value="{{ old('business_name') }}">
                            @if ($errors->has('business_name'))
                                <span class="text-danger">{{ $errors->first('business_name') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="address" class="col-md-4 col-form-label text-md-end text-start">Address</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address') }}">
                            @if ($errors->has('address'))
                                <span class="text-danger">{{ $errors->first('address') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="vendor_name" class="col-md-4 col-form-label text-md-end text-start">Vendor Name</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('vendor_name') is-invalid @enderror" id="vendor_name" name="vendor_name" value="{{ old('vendor_name') }}">
                            @if ($errors->has('vendor_name'))
                                <span class="text-danger">{{ $errors->first('vendor_name') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="description" class="col-md-4 col-form-label text-md-end text-start">Description</label>
                        <div class="col-md-6">
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description') }}</textarea>
                            @if ($errors->has('description'))
                                <span class="text-danger">{{ $errors->first('description') }}</span>
                            @endif
                        </div>
                    </div>

                    <br>

                    <h3>Payment Details</h3>

                    <div class="mb-3 row">
                        <label for="account_no" class="col-md-4 col-form-label text-md-end text-start">Account No</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('account_no') is-invalid @enderror" id="account_no" name="account_no" value="{{ old('account_no') }}">
                            @if ($errors->has('account_no'))
                                <span class="text-danger">{{ $errors->first('account_no') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="bank_name" class="col-md-4 col-form-label text-md-end text-start">Bank Name</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('bank_name') is-invalid @enderror" id="bank_name" name="bank_name" value="{{ old('bank_name') }}">
                            @if ($errors->has('bank_name'))
                                <span class="text-danger">{{ $errors->first('bank_name') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="ifsc_code" class="col-md-4 col-form-label text-md-end text-start">IFSC Code</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('ifsc_code') is-invalid @enderror" id="ifsc_code" name="ifsc_code" value="{{ old('ifsc_code') }}">
                            @if ($errors->has('ifsc_code'))
                                <span class="text-danger">{{ $errors->first('ifsc_code') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="branch" class="col-md-4 col-form-label text-md-end text-start">Branch</label>
                        <div class="col-md-6">
                          <input type="text" class="form-control @error('branch') is-invalid @enderror" id="branch" name="branch" value="{{ old('branch') }}">
                            @if ($errors->has('branch'))
                                <span class="text-danger">{{ $errors->first('branch') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Add Vendor">
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection
