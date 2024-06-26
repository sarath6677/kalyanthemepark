@extends('layouts.admin.app')

@section('title', translate('Add New Money List'))

@section('content')
    <div class="content container-fluid">
        <div class="d-flex align-items-center gap-3 mb-3">
            <img width="24" src="{{asset('public/assets/admin/img/media/dollar-2.png')}}" alt="{{ translate('Recharge') }}">
            <h2 class="page-header-title">{{translate('Add Mobile Money')}}</h2>
        </div>

        <div class="card card-body">
            <form action="{{route('admin.add-money.store')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-sm-6 col-lg-4">
                        <div class="form-group">
                            <label class="input-label" for="exampleFormControlInput1">{{translate('Amount')}}</label>
                            <input type="text" name="amount" class="form-control" value="{{ old('amount') }}"
                                    placeholder="{{translate('amount')}}" required>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="form-group">
                            <label class="input-label" for="exampleFormControlInput1">{{translate('Cashback Amount')}}</label>
                            <input type="text" name="cashback_amount" class="form-control" value="{{ old('cashback_amount') }}"
                                    placeholder="{{translate('cashback amount')}}" required>
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
@endpush
