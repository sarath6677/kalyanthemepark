@extends('layouts.main')

@section('content')
<div class="card">
    <div class="card-header">Users List</div>
    <div class="card-body">
            <a href="{{ route('zone.create') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i> Add Zone</a>
        <table class="table table-striped table-bordered">
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

                    {{ $zones->links() }}

                </div>
            </div>
            @endsection
