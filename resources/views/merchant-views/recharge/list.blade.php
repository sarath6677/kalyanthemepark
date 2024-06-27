@extends('layouts.merchant.app')

@section('title', translate('Recharge List'))

@section('content')
    <div class="content container-fluid">
        <div class="d-flex align-items-center gap-3 mb-3">
            <img width="24" src="{{asset('public/assets/admin/img/media/dollar-1.png')}}" alt="{{ translate('Recharge') }}">
            <h2 class="page-header-title">{{translate('Recharge List')}}</h2>
        </div>

        <div class="card">
            <div class="card-header __wrap-gap-10">
                <div class="d-flex align-items-center gap-2">
                    <h5 class="card-header-title">{{translate('Recharge Table')}}</h5>
                    <span class="badge badge-soft-secondary text-dark">{{ $nfcRecharges->total() }}</span>
                </div>
                <div class="d-flex flex-wrap gap-3">
                    {{-- <form action="{{url()->current()}}" method="GET">
                        <div class="input-group">
                            <input id="datatableSearch_" type="search" name="search"
                                    class="form-control mn-md-w280"
                                    placeholder="{{translate('Search by Name')}}" aria-label="Search"
                                    value="{{$search}}" required autocomplete="off">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">{{translate('Search')}}</button>
                            </div>
                        </div>
                    </form> --}}

                    <a href="{{route('vendor.recharge.add')}}" class="btn btn-primary">
                        <i class="tio-add"></i> {{translate('Add')}} {{translate('Game Play')}}
                    </a>
                </div>
            </div>

            <div class="table-responsive datatable-custom">
                <table
                    class="table table-borderless table-thead-bordered table-nowrap table-align-middle card-table">
                    <thead class="thead-light">
                    <tr>
                        <th>{{translate('SL')}}</th>
                        <th>{{translate('name')}}</th>
                        <th>{{translate('Amount')}}</th>
                        <th class="text-center">{{translate('action')}}</th>
                    </tr>
                    </thead>

                    <tbody id="set-rows">
                    @foreach($nfcRecharges as $key=>$nfcRecharge)
                        <tr>
                            <td>{{$nfcRecharges->firstitem()+$key}}</td>
                            <td>
                                <a href="{{route('admin.customer.view',[$nfcRecharge->user['id']])}}" class="media gap-3 align-items-center text-dark">
                                    <div class="avatar avatar-lg border rounded-circle">
                                        <img class="rounded-circle img-fit"
                                            src="{{$nfcRecharge->user['image_fullpath']}}"
                                             alt="{{ translate('vendor') }}">
                                    </div>
                                    <div class="media-body">
                                        {{$nfcRecharge->user['f_name'].' '.$nfcRecharge->user['l_name']}}
                                    </div>
                                </a>
                            </td>
                            <td>
                                {{$nfcRecharge->amount }}
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a class="action-btn btn btn-outline-primary"
                                        href="{{route('admin.recharge.list',[$nfcRecharge['id']])}}">
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
                    {!! $nfcRecharges->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
