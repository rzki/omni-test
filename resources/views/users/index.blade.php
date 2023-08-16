@extends('layouts.app', ['title' => 'User Management'])

@section('content')
    <div class="container-fluid p-0">
        <h1 class="h2 mb-3 text-bold">User Management</h1>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-end mb-3">
                            <a href="{{ route('users.create') }}" class="btn btn-success">
                                <i class="align-middle me-1" data-feather="user-plus"></i>
                                New User
                            </a>
                        </div>
                        <table class="table table-bordered table-responsive">
                            <thead>
                                <tr class="text-center text-black">
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">
                                                <i class="align-middle me-1" data-feather="edit"></i>
                                                Edit
                                            </a>
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger">
                                                    <i class="align-middle me-1" data-feather="trash-2"></i>
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                @endforeach
                            </tbody>
                            {{ $users->links('pagination::bootstrap-5') }}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
