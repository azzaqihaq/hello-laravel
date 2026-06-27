<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Set a new password for your account.">
    <title>Reset Password - Coleo.Inc</title>

    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>

    <!-- Ambient glowing backgrounds -->
    <div class="ambient-bg">
        <div class="ambient-glow-1"></div>
        <div class="ambient-glow-2"></div>
    </div>

    <!-- Reset Password Wrapper -->
    <div class="auth-wrapper">
        <div class="auth-card">
            
            <div class="auth-header">
                <div class="auth-logo">
                    <!-- Shield-check icon -->
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                        <path d="M9 12l2 2 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                    </svg>
                </div>
                <h1 class="auth-title">Reset Password</h1>
                <p class="auth-subtitle">Choose a new password for your account.</p>
            </div>

            @if (session('status'))
                <div style="background: var(--success-bg); border: 1px solid var(--success-border); color: var(--success-text); padding: 0.85rem 1rem; border-radius: 12px; font-size: 0.85rem; margin-bottom: 1.5rem; text-align: center; line-height: 1.4;">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Reset Password Form -->
            <form action="{{ route('password.update') }}" method="POST">
                @csrf

                <!-- Hidden Token -->
                <input type="hidden" name="token" value="{{ $token }}">

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
                            value="{{ $email ?? old('email') }}" 
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

                <!-- New Password Input -->
                <div class="form-group">
                    <label for="password" class="form-label">New Password</label>
                    <div class="input-wrapper">
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            class="form-input @error('password') is-invalid @enderror" 
                            placeholder="At least 8 characters" 
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

                <!-- Confirm Password Input -->
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <div class="input-wrapper">
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            id="password_confirmation" 
                            class="form-input" 
                            placeholder="Repeat your new password" 
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
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-auth" style="margin-bottom: 1.5rem;">Reset Password</button>

                <!-- Back to Login Link -->
                <div style="text-align: center;">
                    <span style="font-size: 0.85rem; color: var(--text-muted);">
                        <a href="{{ route('login') }}" class="forgot-password" style="font-weight: 600;">Back to Sign In</a>
                    </span>
                </div>

            </form>

        </div>
    </div>

</body>
</html>
