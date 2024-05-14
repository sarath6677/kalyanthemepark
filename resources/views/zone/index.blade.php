@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Zone') }} <a href="{{ route('zone.create') }}" class="btn btn-primary"><i class="fa fa-pencil">Create</i></a>
                </div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Zone Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($zones as $zone)
                               <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $zone->zone_name }}</td>
                                <td>
                                    {{-- <a href="{{ route('user.edit') }}" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                                    <a href="{{ route('user.edit') }}" class="btn btn-primary"><i class="fa fa-pencil"></i></a>
                                    <a href="{{ route('user.edit') }}" class="btn btn-primary"><i class="fa fa-pencil"></i></a> --}}
                                </td>
                               </tr>
                            @empty
                               <tr>
                                <td colspan="3"> No Record Found</td>
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
