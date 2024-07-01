@extends('layouts.merchant.app')

@section('title', translate('Add Recharge'))

@section('content')
    <div class="content container-fluid">
        <div class="d-flex align-items-center gap-3 mb-3">
            <img width="24" src="{{asset('public/assets/admin/img/media/dollar-2.png')}}" alt="{{ translate('Recharge') }}">
            <h2 class="page-header-title">{{translate('Deduct Money for Game Play')}}</h2>
        </div>

        <div class="card card-body">
            <form action="{{route('vendor.recharge.store')}}" method="post" id="myForm">
                @csrf
                <div class="row">
                    <div class="col-sm-6 col-lg-4">
                        <div class="form-group">
                            <label class="input-label" for="exampleFormControlInput1">{{translate('Select Product')}}</label>
                            <select name="product_id" id="fetch-product" class="form-control">
                                <option value="" selected disabled>--Please select--</option>
                                @forelse ($products as $product)
                                    <option value="{{$product->id }}">{{ $product->product_name}}</option>
                                @empty
                                <option value="">--Product not Found--</option>
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="form-group">
                            <label class="input-label" for="exampleFormControlInput1">{{translate('Card Number')}}</label>
                            <input type="text" name="card_id" class="form-control" value="{{ old('card_id') }}"
                                    placeholder="{{translate('Please Tap a Card')}}" required>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="form-group">
                            <label class="input-label" for="exampleFormControlInput1">{{translate('Amount')}}</label>
                            <input type="text" name="amount" class="form-control amount" value="{{ old('amount') }}"
                                    placeholder="{{translate('amount')}}" required readonly>
                        </div>
                    </div>
                </div>
            </div>

                <div class="d-flex justify-content-end gap-3">
                    <button type="reset" class="btn btn-secondary">{{translate('reset')}}</button>
                    <button type="submit" id="submitBtn" class="btn btn-primary">{{translate('submit')}}</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('script_2')
    <script src="{{asset('public/assets/admin/js/spartan-multi-image-picker.js')}}"></script>

    <script>
        $(document).ready(function() {
        $('form').on('submit', function(event) {
            // Check if the submit button was clicked
            if ($(document.activeElement).is(':submit')) {
                // Proceed with the form submission
                return true;
            } else {
                // Prevent the form submission
                event.preventDefault();
            }
        });
    $('#fetch-product').change(function() {
        var pId = $(this).val();
        var url = '{{route('vendor.recharge.getProduct',':pId')}}';
        var url = url.replace(':pId', pId);
        $.ajax({
            url: url, // URL to fetch product with ID 1
            type: 'GET',
            success: function(data) {
                $('.amount').val(data)
            },
            error: function(error) {
            }
        });
    });
});
    </script>
@endpush
