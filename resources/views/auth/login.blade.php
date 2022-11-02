@extends('layouts.app')
@section('title')
    <title> Login | {{ config('app.name', 'Streamlab') }}</title>
@stop
@section('content')
    <div class="container">
        <div class="flex-row">
            <div class="col col1">
                <div class="login-text">
                    <p>Streamlabs Assignment </p>
                </div>
            </div>
            <div class="col col2">
                <form class="form" action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <h1>Sign In</h1>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter your Email">
                        @error('email')
                        <span class="input-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter your Password">
                        @error('password')
                        <span class="input-error">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn text-capitalize">login <i class="fal fa-sign-in"></i> </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
