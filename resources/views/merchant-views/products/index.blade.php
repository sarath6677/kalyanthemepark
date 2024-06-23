@extends('layouts.merchant.app')

@section('title', translate('Product List'))

@section('content')
    <div class="content container-fluid">
        <div class="d-flex align-items-center gap-3 mb-3">
            <img width="24" src="{{asset('public/assets/admin/img/media/dollar-1.png')}}" alt="{{ translate('Product') }}">
            <h2 class="page-header-title">{{translate('Product List')}}</h2>
        </div>

        <div class="card">
            <div class="card-header __wrap-gap-10">
                <div class="d-flex align-items-center gap-2">
                    <h5 class="card-header-title">{{translate('Product Table')}}</h5>
                    <span class="badge badge-soft-secondary text-dark">{{ $products->total() }}</span>
                </div>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{route('vendor.products.create')}}" class="btn btn-primary">
                        <i class="tio-add"></i> {{translate('Add')}} {{translate('Product')}}
                    </a>
                </div>
            </div>

            <div class="table-responsive datatable-custom">
                <table
                    class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                    <thead class="thead-light">
                    <tr>
                        <th>{{translate('SL')}}</th>
                        <th>{{translate('Product Name')}}</th>
                        <th>{{translate('Description')}}</th>
                        <th>{{translate('Amount')}}</th>
                        <th class="text-center">{{translate('action')}}</th>
                    </tr>
                    </thead>

                    <tbody id="set-rows">
                    @foreach($products as $key=>$product)
                        <tr>
                            <td>{{$products->firstitem()+$key}}</td>
                            <td>
                                {{$product->product_name }}
                            </td>
                            <td>
                                {{$product->description }}
                            </td>
                            <td>
                                {{$product->price }}
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a class="action-btn btn btn-outline-primary"
                                        href="{{route('admin.recharge.list',[$product['id']])}}">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div class="table-responsive mt-4 px-3">
                <div class="d-flex justify-content-end">
                    {!! $products->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
