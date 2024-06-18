@extends('layouts.admin.app')

@section('title', translate('Money List'))

@section('content')
    <div class="content container-fluid">
        <div class="d-flex align-items-center gap-3 mb-3">
            <img width="24" src="{{asset('public/assets/admin/img/media/dollar-1.png')}}" alt="{{ translate('Money') }}">
            <h2 class="page-header-title">{{translate('Money List')}}</h2>
        </div>

        <div class="card">
            <div class="card-header __wrap-gap-10">
                <div class="d-flex align-items-center gap-2">
                    <h5 class="card-header-title">{{translate('Money Table')}}</h5>
                    <span class="badge badge-soft-secondary text-dark">{{ $nfcAddMoney->total() }}</span>
                </div>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{route('admin.add-money.create')}}" class="btn btn-primary">
                        <i class="tio-add"></i> {{translate('Add')}} {{translate('Recharge')}}
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
                    @foreach($nfcAddMoney as $key=>$nfcMoney)
                        <tr>
                            <td>{{$nfcAddMoney->firstitem()+$key}}</td>
                            <td>
                                {{$nfcMoney->amount }}
                            </td>
                            <td>
                                {{$nfcMoney->cashback_amount }}
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a class="action-btn btn btn-outline-primary"
                                        href="{{route('admin.recharge.list',[$nfcMoney['id']])}}">
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
                    {!! $nfcAddMoney->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
