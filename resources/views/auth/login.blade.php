@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <h2 class="fw-bold mb-3" style="color: #262626;">Instagram Clone</h2>
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="mb-3">
                        @csrf
                        
                        <div class="mb-3">
                            <input id="email" type="email" class="form-control bg-light @error('email') is-invalid @enderror" 
                                name="email" value="{{ old('email') }}" 
                                placeholder="Email" 
                                required autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <input id="password" type="password" 
                                class="form-control bg-light @error('password') is-invalid @enderror" 
                                name="password" 
                                placeholder="Password" 
                                required autocomplete="current-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label text-muted small" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                            
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-decoration-none small" style="color: #00376b;">
                                    {{ __('Forgot password?') }}
                                </a>
                            @endif
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg" style="background-color: #0095f6; border: none;">
                                {{ __('Log In') }}
                            </button>
                        </div>

                        <div class="text-center mb-4">
                            <div class="position-relative">
                                <hr>
                                <span class="position-absolute top-50 start-50 translate-middle bg-white px-2 text-muted small">OR</span>
                            </div>
                        </div>

                        <div class="text-center">
                            <a href="#" class="text-decoration-none d-block mb-3">
                                <i class="bi bi-facebook me-2"></i> Log in with Facebook
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mt-3 border-0 shadow-sm">
                <div class="card-body text-center py-4">
                    <p class="mb-0">
                        Don't have an account? 
                        <a href="{{ route('register') }}" class="text-decoration-none fw-bold" style="color: #0095f6;">Sign up</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #fafafa;
    }
    .card {
        border-radius: 1rem;
    }
    .form-control {
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
    }
    .form-control:focus {
        box-shadow: none;
        border-color: #ced4da;
    }
    .btn-primary {
        padding: 0.6rem;
        font-weight: 600;
        border-radius: 0.5rem;
    }
    .btn-primary:hover {
        background-color: #1877f2 !important;
    }
    .form-check-input:checked {
        background-color: #0095f6;
        border-color: #0095f6;
    }
</style>

<!-- Add Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
@endsection
