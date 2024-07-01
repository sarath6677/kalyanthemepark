@extends('layouts.merchant.app')

@section('title', translate('Add New Products List'))

@section('content')
    <div class="content container-fluid">
        <div class="d-flex align-items-center gap-3 mb-3">
            <img width="24" src="{{asset('public/assets/admin/img/media/dollar-2.png')}}" alt="{{ translate('Products') }}">
            <h2 class="page-header-title">{{translate('Add Products Money')}}</h2>
        </div>

        <div class="card card-body">
            <form action="{{route('vendor.products.store')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-sm-6 col-lg-4">
                        <div class="form-group">
                            <label class="input-label" for="exampleFormControlInput1">{{translate('Product Name')}}</label>
                            <input type="text" name="product_name" class="form-control" value="{{ old('product_name') }}"
                                    placeholder="{{translate('product name')}}" required>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="form-group">
                            <label class="input-label" for="exampleFormControlInput1">{{translate('Description')}}</label>
                            <input type="text" name="description" class="form-control" value="{{ old('description') }}"
                                    placeholder="{{translate('Description')}}" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 col-lg-4">
                        <div class="form-group">
                            <label class="input-label" for="exampleFormControlInput1">{{translate('Card Reader ID')}}</label>
                            <input type="text" name="rfid_tag" id="rfid_tag" class="form-control" value="{{ old('rfid_tag') }}"
                                    placeholder="{{translate('Card Reader ID')}}" required>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="form-group">
                            <label class="input-label" for="exampleFormControlInput1">{{translate('Amount')}}</label>
                            <input type="text" name="price" class="form-control" value="{{ old('price') }}"
                                    placeholder="{{translate('Amount')}}" required>
                        </div>
                    </div>
                </div>
            </div>

                <div class="d-flex justify-content-end gap-3">
                    <button type="reset" class="btn btn-secondary">{{translate('reset')}}</button>
                    <button type="submit" class="btn btn-primary">{{translate('submit')}}</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('script_2')
    <script src="{{asset('public/assets/admin/js/spartan-multi-image-picker.js')}}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const rfidInput = document.getElementById('rfid_tag');
            rfidInput.focus();

            rfidInput.addEventListener('input', (event) => {
                // Optionally, handle the RFID input if needed
                console.log('RFID Tag:', rfidInput.value);
            });
        });
    </script>
@endpush
