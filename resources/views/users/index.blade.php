@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Users') }} <a href="{{ route('user.create') }}" class="btn btn-primary"><i class="fa fa-pencil">Create</i></a>
                </div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Name</th>
                                <th>Balance</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($customers as $customer)
                               <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $customer->customer_name }}</td>
                                <td>{{ $customer->card_amount }}</td>
                                <td>
                                    {{-- <a href="{{ route('user.edit') }}" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                                    <a href="{{ route('user.edit') }}" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                                    <a href="{{ route('user.edit') }}" class="btn btn-primary"><i class="fa fa-pencil"></i></a> --}}
                                </td>
                               </tr>
                            @empty
                               <tr>
                                <td colspan="4"> No Record Found</td>
                               </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
