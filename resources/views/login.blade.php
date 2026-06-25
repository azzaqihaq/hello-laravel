<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sign in to your account.">
    <title>Sign In - Coleo.Inc</title>

    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>

    <!-- Ambient glowing backgrounds -->
    <div class="ambient-bg">
        <div class="ambient-glow-1"></div>
        <div class="ambient-glow-2"></div>
    </div>

    <!-- Login Wrapper -->
    <div class="auth-wrapper">
        <div class="auth-card">
            
            <div class="auth-header">
                <div class="auth-logo">
                    <!-- Geometric logo -->
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                    </svg>
                </div>
                <h1 class="auth-title">Welcome Back</h1>
                <p class="auth-subtitle">Sign in to your dashboard</p>
            </div>

            @if (session('success'))
                <div style="background: var(--success-bg); border: 1px solid var(--success-border); color: var(--success-text); padding: 0.85rem 1rem; border-radius: 12px; font-size: 0.85rem; margin-bottom: 1.5rem; text-align: center; line-height: 1.4;">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ url('/login') }}" method="POST">
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

                <!-- Password Input -->
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-wrapper">
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            class="form-input @error('password') is-invalid @enderror" 
                            placeholder="••••••••" 
                            required
                        >
                        <span class="input-icon">
                            <!-- Lock Icon -->
                            <svg viewBox="0 0 24 24">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                        </span>
                    </div>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Form Options -->
                <div class="form-actions">
                    <label class="remember-me">
                        <input type="checkbox" name="remember" class="remember-checkbox">
                        Remember me
                    </label>
                    <a href="#" class="forgot-password">Forgot Password?</a>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-auth" style="margin-bottom: 1.5rem;">Sign In</button>

                <!-- Redirect to Register Link -->
                <div style="text-align: center;">
                    <span style="font-size: 0.85rem; color: var(--text-muted);">
                        Don't have an account? 
                        <a href="{{ route('register') }}" class="forgot-password" style="font-weight: 600;">Create Account</a>
                    </span>
                </div>

            </form>

        </div>
    </div>

</body>
</html>
