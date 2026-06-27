<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Reset your account password.">
    <title>Forgot Password - Coleo.Inc</title>

    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>

    <!-- Ambient glowing backgrounds -->
    <div class="ambient-bg">
        <div class="ambient-glow-1"></div>
        <div class="ambient-glow-2"></div>
    </div>

    <!-- Forgot Password Wrapper -->
    <div class="auth-wrapper">
        <div class="auth-card">
            
            <div class="auth-header">
                <div class="auth-logo">
                    <!-- Key icon -->
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 2l-2 2m-7.61 7.61a5.5 5.5 0 1 1-7.778 7.778 5.5 5.5 0 0 1 7.777-7.777zm0 0L15.5 7.5m0 0l3 3L22 7l-3-3m-3.5 3.5L19 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                    </svg>
                </div>
                <h1 class="auth-title">Forgot Password?</h1>
                <p class="auth-subtitle">Enter your email address and we'll send you a link to reset your password.</p>
            </div>

            @if (session('status'))
                <div style="background: var(--success-bg); border: 1px solid var(--success-border); color: var(--success-text); padding: 0.85rem 1rem; border-radius: 12px; font-size: 0.85rem; margin-bottom: 1.5rem; text-align: center; line-height: 1.4;">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Forgot Password Form -->
            <form action="{{ route('password.email') }}" method="POST">
                @csrf

                <!-- Email Input -->
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-wrapper">
                        <input 
                            type="email" 
                            name="email" 
                            id="email" 
                            class="form-input @error('email') is-invalid @enderror" 
                            placeholder="admin@example.com" 
                            value="{{ old('email') }}" 
                            required 
                            autofocus
                        >
                        <span class="input-icon">
                            <!-- Mail Icon -->
                            <svg viewBox="0 0 24 24">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </span>
                    </div>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-auth" style="margin-bottom: 1.5rem;">Send Reset Link</button>

                <!-- Back to Login Link -->
                <div style="text-align: center;">
                    <span style="font-size: 0.85rem; color: var(--text-muted);">
                        Remember your password? 
                        <a href="{{ route('login') }}" class="forgot-password" style="font-weight: 600;">Back to Sign In</a>
                    </span>
                </div>

            </form>

        </div>
    </div>

</body>
</html>
