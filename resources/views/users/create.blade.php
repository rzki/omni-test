@extends('layouts.app', ['title' => 'Add New User'])

@section('content')
    <div class="container-fluid p-0">
        <h1 class="h2 mb-3 text-bold">User Management</h1>
        <div class="row">
            <div class="col-12">
                <div class="card py-5">
                    <div class="card-header px-5">
                        <div class="d-flex justify-content-start pb-3">
                            <a href="{{ route('users.create') }}" class="btn btn-primary">
                                <i class="align-middle me-1" data-feather="arrow-left"></i>
                                New User
                            </a>
                        </div>
                    </div>
                    <div class="card-body px-5">
                        <div class="text-center">
                            <h3>Add New User Form</h3>
                        </div>
                        <div class="form mt-3">
                            <form action={{ route('users.store') }} method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="exampleInputName1" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
                                </div>
                                <div class="d-grid pb-3">
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
