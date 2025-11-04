<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Instagram</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #fafafa;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }
        .login-container {
            max-width: 350px;
            margin: 0 auto;
            padding: 20px 0;
        }
        .login-box {
            background: white;
            border: 1px solid #dbdbdb;
            border-radius: 1px;
            padding: 20px 40px;
            margin-bottom: 10px;
        }
        .instagram-logo {
            font-family: 'Billabong', cursive;
            font-size: 3rem;
            text-align: center;
            margin: 20px 0;
            color: #262626;
        }
        .form-control {
            background: #fafafa;
            border: 1px solid #dbdbdb;
            border-radius: 3px;
            padding: 9px 8px;
            font-size: 12px;
        }
        .form-control:focus {
            background: #fafafa;
            border-color: #a8a8a8;
            box-shadow: none;
        }
        .btn-primary {
            background: #0095f6;
            border: none;
            border-radius: 4px;
            padding: 5px 9px;
            font-weight: 600;
            width: 100%;
        }
        .btn-primary:hover {
            background: #1877f2;
        }
        .btn-primary:disabled {
            background: #b2dffc;
        }
        .divider {
            display: flex;
            align-items: center;
            margin: 20px 0;
        }
        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid #dbdbdb;
        }
        .divider-text {
            padding: 0 15px;
            color: #8e8e8e;
            font-size: 13px;
            font-weight: 600;
        }
        .facebook-login {
            color: #385185;
            font-weight: 600;
            text-decoration: none;
            font-size: 14px;
        }
        .signup-box {
            background: white;
            border: 1px solid #dbdbdb;
            border-radius: 1px;
            padding: 20px;
            text-align: center;
            font-size: 14px;
        }
        .terms {
            color: #8e8e8e;
            font-size: 12px;
            text-align: center;
            margin: 15px 0;
        }
    </style>

    <style>
        @font-face {
            font-family: 'Billabong';
            font-style: normal;
            font-weight: normal;
            src: local('Billabong'), url('https://fonts.cdnfonts.com/s/13949/Billabong.woff') format('woff');
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-4">
                <div class="login-box">
                    <div class="instagram-logo">Instagram</div>
                    <p class="text-center text-muted mb-4" style="font-size: 16px; font-weight: 600;">
                        Sign up to see photos and videos from your friends.
                    </p>
                    
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <input id="email" type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="Mobile Number or Email"
                                   required 
                                   autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <input id="name" type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="Full Name"
                                   required 
                                   autocomplete="name" 
                                   autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <input id="username" type="text" 
                                   class="form-control @error('username') is-invalid @enderror" 
                                   name="username" 
                                   value="{{ old('username') }}" 
                                   placeholder="Username"
                                   required 
                                   autocomplete="username">
                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <input id="password" type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   name="password" 
                                   placeholder="Password"
                                   required 
                                   autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <input id="password-confirm" type="password" 
                                   class="form-control" 
                                   name="password_confirmation" 
                                   placeholder="Confirm Password"
                                   required 
                                   autocomplete="new-password">
                        </div>

                        <div class="terms">
                            <p class="mb-2">People who use our service may have uploaded your contact information to Instagram. <a href="#" class="text-decoration-none">Learn More</a></p>
                            <p class="mb-2">By signing up, you agree to our <a href="#" class="text-decoration-none">Terms</a>, <a href="#" class="text-decoration-none">Privacy Policy</a> and <a href="#" class="text-decoration-none">Cookies Policy</a>.</p>
                        </div>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">
                                Sign Up
                            </button>
                        </div>
                    </form>
                </div>

                <div class="signup-box">
                    <p class="mb-0">Have an account? 
                        <a href="{{ route('login') }}" class="text-decoration-none fw-bold" style="color: #0095f6;">Log in</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
</body>
</html>