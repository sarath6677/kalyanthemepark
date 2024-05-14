@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">Vendor List</div>
    <div class="card-body">
            <a href="{{ route('vendor.create') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i> Add New vendor</a>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                <th scope="col">S#</th>
                <th scope="col">Bussiness Name</th>
                <th scope="col">Address</th>
                <th scope="col">Vendor Name</th>
                <th scope="col">Description</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($vendors as $vendor)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $vendor->business_name }}</td>
                    <td>{{ $vendor->address }}</td>
                    <td>{{ $vendor->vendor_name }}</td>
                    <td>{{ $vendor->description }}</td>
                    <td>
                        <form action="{{ route('vendor.destroy', $vendor->id) }}" method="post">
                            @csrf
                            @method('DELETE')

                            <a href="{{ route('vendor.show', $vendor->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> Show</a>

                                {{-- <a href="{{ route('vendor.edit', $vendor->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a> --}}

                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this vendor?');"><i class="bi bi-trash"></i> Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                    <td colspan="6">
                        <span class="text-danger">
                            <strong>No Vendor Found!</strong>
                        </span>
                    </td>
                @endforelse
            </tbody>
        </table>

        {{ $vendors->links() }}

    </div>
</div>
@endsection
