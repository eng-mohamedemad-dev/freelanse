@extends('website.layouts.app')

@section('title', __('website.login'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="auth-card">
                <h2 class="auth-title">{{ __('website.login') }}</h2>
                
                <form method="POST" action="{{ route('website.login.submit') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label for="email">{{ __('website.email') }}</label>
                        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="password">{{ __('website.password') }}</label>
                        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" id="remember" name="remember" class="form-check-input">
                            <label for="remember" class="form-check-label">{{ __('website.remember_me') }}</label>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-block">{{ __('website.login') }}</button>
                </form>
                
                <div class="auth-links">
                    <a href="{{ route('website.password.request') }}">{{ __('website.forgot_password') }}</a>
                    <a href="{{ route('website.register') }}">{{ __('website.dont_have_account') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.auth-card {
    background: white;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    margin: 2rem 0;
}

.auth-title {
    text-align: center;
    margin-bottom: 2rem;
    color: #333;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: bold;
    color: #333;
}

.form-control {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 1rem;
}

.form-control:focus {
    outline: none;
    border-color: #007bff;
    box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
}

.btn-block {
    width: 100%;
    padding: 0.75rem;
    font-size: 1rem;
}

.auth-links {
    text-align: center;
    margin-top: 1.5rem;
}

.auth-links a {
    color: #007bff;
    text-decoration: none;
    margin: 0 1rem;
}

.auth-links a:hover {
    text-decoration: underline;
}
</style>
@endpush
