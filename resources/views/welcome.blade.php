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
        :root {
            --instagram-blue: #0095f6;
            --instagram-dark: #262626;
            --instagram-gray: #8e8e8e;
            --instagram-light-gray: #dbdbdb;
            --instagram-bg: #fafafa;
        }
        
        body {
            background-color: var(--instagram-bg);
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        
        .login-container {
            max-width: 350px;
            width: 100%;
            margin: 0 auto;
        }
        
        .login-box {
            background: white;
            border: 1px solid var(--instagram-light-gray);
            border-radius: 3px;
            padding: 2rem;
            margin-bottom: 0.75rem;
        }
        
        .instagram-logo {
            font-family: 'Billabong', cursive;
            font-size: 3rem;
            text-align: center;
            margin: 1.5rem 0;
            color: var(--instagram-dark);
        }
        
        .form-control {
            background: #fafafa;
            border: 1px solid var(--instagram-light-gray);
            border-radius: 3px;
            padding: 0.75rem;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }
        
        .form-control:focus {
            border-color: #a8a8a8;
            box-shadow: none;
        }
        
        .btn-primary {
            background: var(--instagram-blue);
            border: none;
            border-radius: 4px;
            padding: 0.5rem;
            font-weight: 600;
            margin-top: 0.5rem;
        }
        
        .divider {
            display: flex;
            align-items: center;
            margin: 1rem 0;
        }
        
        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid var(--instagram-light-gray);
        }
        
        .divider-text {
            padding: 0 1rem;
            color: var(--instagram-gray);
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .facebook-login {
            color: #385185;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .forgot-password {
            color: #00376b;
            text-decoration: none;
            font-size: 0.75rem;
            text-align: center;
            display: block;
            margin-top: 0.75rem;
        }
        
        .signup-box {
            background: white;
            border: 1px solid var(--instagram-light-gray);
            border-radius: 3px;
            padding: 1.25rem;
            text-align: center;
        }
        
        .get-app {
            text-align: center;
            padding: 1rem 0;
        }
        
        .app-download {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 0.5rem;
            flex-wrap: wrap;
        }
        
        .app-download img {
            height: 40px;
        }
        
        .error-message {
            color: #ed4956;
            font-size: 0.75rem;
            text-align: center;
            margin: 0.5rem 0;
        }

        @media (max-width: 768px) {
            body {
                align-items: flex-start;
                padding-top: 2rem;
            }
            
            .login-box, .signup-box {
                border: none;
                background: transparent;
            }
            
            .login-box {
                padding: 1rem;
            }
            
            .instagram-logo {
                font-size: 2.5rem;
                margin: 1rem 0;
            }
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 0 1rem;
            }
            
            .instagram-logo {
                font-size: 2.2rem;
            }
        }

        /* Touch device improvements */
        @media (hover: none) and (pointer: coarse) {
            .btn-primary, .facebook-login, .forgot-password {
                min-height: 44px;
            }
            
            .form-control {
                min-height: 44px;
            }
        }
    </style>

    <style>
        @font-face {
            font-family: 'Billabong';
            src: local('Billabong'), url('https://fonts.cdnfonts.com/s/13949/Billabong.woff') format('woff');
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="login-container">
            <div class="login-box">
                <div class="instagram-logo">Instagram</div>
                
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <input id="email" type="email" 
                           class="form-control @error('email') is-invalid @enderror" 
                           name="email" 
                           value="{{ old('email') }}" 
                           placeholder="Phone number, username, or email"
                           required 
                           autocomplete="email" 
                           autofocus>

                    <input id="password" type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           name="password" 
                           placeholder="Password"
                           required 
                           autocomplete="current-password">

                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror

                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror

                    <button type="submit" class="btn btn-primary w-100">
                        Log In
                    </button>

                    <div class="divider">
                        <span class="divider-text">OR</span>
                    </div>

                    <div class="text-center mb-2">
                        <a href="#" class="facebook-login">
                            <i class="bi bi-facebook"></i> Log in with Facebook
                        </a>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('password.request') }}" class="forgot-password">
                            Forgot password?
                        </a>
                    </div>
                </form>
            </div>

            <div class="signup-box">
                <p class="mb-0">Don't have an account? 
                    <a href="{{ route('register') }}" class="text-decoration-none fw-bold" style="color: var(--instagram-blue);">Sign up</a>
                </p>
            </div>

            <div class="get-app">
                <p class="mb-2">Get the app.</p>
                <div class="app-download">
                    <a href="#">
                        <img src="https://static.cdninstagram.com/rsrc.php/v3/yz/r/c5Rp7Ym-Klz.png" alt="Download on App Store">
                    </a>
                    <a href="#">
                        <img src="https://static.cdninstagram.com/rsrc.php/v3/yu/r/EHY6QnZYdNX.png" alt="Get it on Google Play">
                    </a>
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