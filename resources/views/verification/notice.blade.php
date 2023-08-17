@extends('layouts.auth', ['title' => 'Please Verify Your Email First!'])

@section('content')
    <div class="container d-flex flex-column">
        <div class="row vh-100">
            <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
                <div class="d-table-cell align-middle">

                    <div class="text-center mt-4">
                        <h1 class="h2">Welcome!</h1>
                        <p class="lead">
                            Please verify your email
                        </p>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            {{-- <div class="m-sm-3">
                                <form action={{ route('login') }} method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input class="form-control form-control-lg" type="email" name="email"
                                            placeholder="Enter your email" />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <input class="form-control form-control-lg" type="password" name="password"
                                            placeholder="Enter your password" />
                                    </div>
                                    <div>
                                        <div class="form-check align-items-center">
                                            <input id="customControlInline" type="checkbox" class="form-check-input"
                                                value="remember-me" name="remember-me" checked>
                                            <label class="form-check-label text-small" for="customControlInline">Remember
                                                me</label>
                                        </div>
                                    </div>
                                    <div class="d-grid gap-2 mt-3">
                                        <button type="submit" class="btn btn-lg btn-primary">Sign in</button>
                                    </div>
                                </form>
                            </div> --}}
                            @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                A fresh verification link has been sent to your email address.
                            </div>
                            @endif

                            Before proceeding, please check your email for a verification link. If you did not receive the email,
                            <form action="{{ route('verification.resend') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="d-inline btn btn-link p-0">
                                    click here to request another
                                </button>.
                            </form>
                        </div>
                    </div>
                    <div class="text-center mb-3">
                        Don't have an account? <a href="{{ route('register') }}">Sign up</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
