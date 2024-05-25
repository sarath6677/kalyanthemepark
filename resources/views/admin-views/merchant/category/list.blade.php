@extends('layouts.admin.app')

@section('title', translate('Vendor Category'))

@section('content')
    <div class="content container-fluid">
        <div class="d-flex align-items-center gap-3 mb-3">
            <img width="24" src="{{asset('public/assets/admin/img/media/store.png')}}" alt="{{ translate('vendor') }}">
            <h2 class="page-header-title">{{translate('Vendor Category')}}</h2>
        </div>

        <div class="card">
            <div class="card-header __wrap-gap-10">
                <div class="d-flex align-items-center gap-2">
                    <h5 class="card-header-title">{{translate('Vendor Category Table')}}</h5>
                    <span class="badge badge-soft-secondary text-dark">{{ $categories->total() }}</span>
                </div>
                <div class="d-flex flex-wrap gap-3">

                    <a href="{{route('admin.vendor.add-category')}}" class="btn btn-primary">
                        <i class="tio-add"></i> {{translate('Add')}} {{translate('Category')}}
                    </a>
                </div>
            </div>

            <div class="table-responsive datatable-custom">
                <table
                    class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                    <thead class="thead-light">
                    <tr>
                        <th>{{translate('SL')}}</th>
                        <th>{{translate('Category Name')}}</th>
                        <th>{{translate('Description')}}</th>
                        <th class="text-center">{{translate('action')}}</th>
                    </tr>
                    </thead>

                    <tbody id="set-rows">
                    @foreach($categories as $key=>$category)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>
                                {{$category->category_name }}
                            </td>
                            <td>
                                {{$category->description }}
                            </td>
                            <td>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="table-responsive mt-4 px-3">
                <div class="d-flex justify-content-end">
                    {!! $categories->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
