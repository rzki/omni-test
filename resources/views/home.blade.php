@extends('layouts.auth', ['title' => 'Dashboard'])

@section('content')
    <h1>Yay! Login successful!</h1>
    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-danger">
        Logout
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
    </form>
@endsection
