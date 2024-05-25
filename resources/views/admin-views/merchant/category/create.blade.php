@extends('layouts.admin.app')

@section('title', translate('Add New Category'))

@section('content')
    <div class="content container-fluid">
        <div class="d-flex align-items-center gap-3 mb-3">
            <img width="24" src="{{asset('public/assets/admin/img/media/store.png')}}" alt="{{ translate('vendor') }}">
            <h2 class="page-header-title">{{translate('Add New Category')}}</h2>
        </div>

        <div class="card card-body">
            <form action="{{route('admin.vendor.category-store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-sm-6 col-lg-4">
                        <div class="form-group">
                            <label class="input-label" for="exampleFormControlInput1">{{translate('Category Name')}}</label>
                            <input type="text" name="category_name" class="form-control" value="{{ old('category_name') }}"
                                    placeholder="{{translate('Category Name')}}" required>
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

                <div class="d-flex justify-content-end gap-3">
                    <button type="reset" class="btn btn-secondary">{{translate('reset')}}</button>
                    <button type="submit" class="btn btn-primary">{{translate('submit')}}</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('script_2')
@endpush
