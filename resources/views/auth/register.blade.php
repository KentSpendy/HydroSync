@extends('layouts.guest')

@section('content')
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        .register-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 460px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }

        .register-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .register-title {
            font-size: 28px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
        }

        .register-subtitle {
            color: #6b7280;
            font-size: 16px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 16px;
            background: #f9fafb;
        }

        .form-input:focus {
            outline: none;
            border-color: #6366f1;
            background: white;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .password-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .form-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 32px;
        }

        .login-link {
            font-size: 14px;
            color: #6366f1;
            text-decoration: none;
            font-weight: 500;
        }

        .register-button {
            padding: 12px 24px;
            background: #6366f1;
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
        }

        .register-button:hover {
            background: #4f46e5;
        }

        .error-message {
            color: #dc2626;
            font-size: 14px;
            margin-top: 4px;
        }

        @media (max-width: 480px) {
            .password-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .form-actions {
                flex-direction: column;
                gap: 16px;
                align-items: stretch;
            }

            .register-button {
                width: 100%;
            }
        }
    </style>

    <div class="register-card">
        <div class="register-header">
            <h1 class="register-title">Create Account</h1>
            <p class="register-subtitle">Join us today and get started</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label for="name" class="form-label">Name</label>
                <input id="name" class="form-input" type="text" name="name" value="{{ old('name') }}" required autofocus>
                @error('name') <div class="error-message">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required>
                @error('email') <div class="error-message">{{ $message }}</div> @enderror
            </div>

            <div class="password-grid">
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" class="form-input" type="password" name="password" required>
                    @error('password') <div class="error-message">{{ $message }}</div> @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input id="password_confirmation" class="form-input" type="password" name="password_confirmation" required>
                </div>
            </div>

            <div class="form-actions">
                <a class="login-link" href="{{ route('login') }}">
                    Already registered?
                </a>

                <button type="submit" class="register-button">
                    Create Account
                </button>
            </div>
        </form>
    </div>
@endsection
