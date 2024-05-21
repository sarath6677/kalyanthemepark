@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-8">

        <div class="card">
            <div class="card-header">
                <div class="float-start">
                    vendor Information
                </div>
                <div class="float-end">
                    <a href="{{ route('vendor.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                </div>
            </div>
            <div class="card-body">

                    <div class="row">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Bussiness Name:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $vendor->business_name }}
                        </div>
                    </div>

                    <div class="row">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong> Address:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $vendor->address }}
                        </div>
                    </div>

                    <div class="row">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Vendor Name:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $vendor->vendor_name }}
                        </div>
                    </div>

                    <div class="row">
                        <label for="description" class="col-md-4 col-form-label text-md-end text-start"><strong>Description:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $vendor->description }}
                        </div>
                    </div>

            </div>

            <div class="card-header">
                <div class="float-start">
                    Payment Details
                </div>
            </div>

            <div class="row">
                <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Account No:</strong></label>
                <div class="col-md-6" style="line-height: 35px;">
                    {{ $VendorBank->account_no ?? '-' }}
                </div>
            </div>

            <div class="row">
                <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Bank Name:</strong></label>
                <div class="col-md-6" style="line-height: 35px;">
                    {{ $VendorBank->bank_name ?? '-' }}
                </div>
            </div>

            <div class="row">
                <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>IFSC Code:</strong></label>
                <div class="col-md-6" style="line-height: 35px;">
                    {{ $VendorBank->ifsc_code ?? '-' }}
                </div>
            </div>

            <div class="row">
                <label for="name" class="col-md-4 col-form-label text-md-end text-start"><strong>Branch:</strong></label>
                <div class="col-md-6" style="line-height: 35px;">
                    {{ $VendorBank->branch ?? '-' }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
