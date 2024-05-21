@extends('layouts.main')

@section('content')
<div class="card">
    <div class="card-header">Users List</div>
    <div class="card-body">
            <a href="{{ route('user.create') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i> Add User</a>
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                <th scope="col">S.No</th>
                <th scope="col">User Name</th>
                <th scope="col">Balance</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($customers as $customer)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $customer->customer_name }}</td>
                    <td>{{ $customer->card_amount }}</td>
                    <td>
                        <form action="{{ route('user.destroy', $customer->id) }}" method="get">
                            @csrf
                            @method('DELETE')

                            <a href="{{ route('user.show', $customer->id) }}" class="btn btn-warning btn-sm"><i class="bi bi-eye"></i> Show</a>

                                {{-- <a href="{{ route('vendor.edit', $vendor->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a> --}}

                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Do you want to delete this User?');"><i class="bi bi-trash"></i> Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                    <td colspan="6">
                        <span class="text-danger">
                            <strong>No Users Found!</strong>
                        </span>
                    </td>
                @endforelse
            </tbody>
        </table>

        {{ $customers->links() }}

    </div>
</div>
@endsection
