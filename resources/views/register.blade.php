<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Register a new account.">
    <title>Create Account - Antigravity</title>

    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>

    <!-- Ambient glowing backgrounds -->
    <div class="ambient-bg">
        <div class="ambient-glow-1"></div>
        <div class="ambient-glow-2"></div>
    </div>

    <!-- Register Wrapper -->
    <div class="auth-wrapper" style="padding: 4rem 2rem;">
        <div class="auth-card" style="max-width: 500px;">
            
            <div class="auth-header">
                <div class="auth-logo">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                    </svg>
                </div>
                <h1 class="auth-title">Create Account</h1>
                <p class="auth-subtitle">Join the dashboard platform</p>
            </div>

            <!-- Registration Form -->
            <form action="{{ url('/register') }}" method="POST">
                @csrf

                <!-- Name Row (Flexbox for side-by-side layout) -->
                <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem; flex-wrap: wrap;">
                    <!-- First Name -->
                    <div class="form-group" style="flex: 1; min-width: 200px; margin-bottom: 0;">
                        <label for="first_name" class="form-label">First Name</label>
                        <div class="input-wrapper">
                            <input 
                                type="text" 
                                name="first_name" 
                                id="first_name" 
                                class="form-input @error('first_name') is-invalid @enderror" 
                                placeholder="Paul" 
                                value="{{ old('first_name') }}" 
                                required 
                                autofocus
                            >
                            <span class="input-icon">
                                <svg viewBox="0 0 24 24">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </span>
                        </div>
                        @error('first_name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Last Name -->
                    <div class="form-group" style="flex: 1; min-width: 200px; margin-bottom: 0;">
                        <label for="last_name" class="form-label">Last Name</label>
                        <div class="input-wrapper">
                            <input 
                                type="text" 
                                name="last_name" 
                                id="last_name" 
                                class="form-input @error('last_name') is-invalid @enderror" 
                                placeholder="Perth" 
                                value="{{ old('last_name') }}"
                            >
                            <span class="input-icon">
                                <svg viewBox="0 0 24 24">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </span>
                        </div>
                        @error('last_name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Email Input -->
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-wrapper">
                        <input 
                            type="email" 
                            name="email" 
                            id="email" 
                            class="form-input @error('email') is-invalid @enderror" 
                            placeholder="name@example.com" 
                            value="{{ old('email') }}" 
                            required
                        >
                        <span class="input-icon">
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

                <!-- Role Input -->
                <div class="form-group">
                    <label for="user_role_id" class="form-label">Account Role</label>
                    <div class="input-wrapper">
                        <select 
                            name="user_role_id" 
                            id="user_role_id" 
                            class="form-input @error('user_role_id') is-invalid @enderror"
                            style="appearance: none; -webkit-appearance: none; cursor: pointer;"
                            required
                        >
                            <option value="" disabled selected>Select your account role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}" {{ old('user_role_id') == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        <span class="input-icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </span>
                        <!-- Custom select arrow indicator -->
                        <span style="position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-dark); pointer-events: none;">
                            ▼
                        </span>
                    </div>
                    @error('user_role_id')
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
                <div class="form-group" style="margin-bottom: 2rem;">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <div class="input-wrapper">
                        <input 
                            type="password" 
                            name="password_confirmation" 
                            id="password_confirmation" 
                            class="form-input" 
                            placeholder="••••••••" 
                            required
                        >
                        <span class="input-icon">
                            <svg viewBox="0 0 24 24">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                        </span>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-auth" style="margin-bottom: 1.5rem;">Create Account</button>

                <!-- Redirect to Login Link -->
                <div style="text-align: center;">
                    <span style="font-size: 0.85rem; color: var(--text-muted);">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="forgot-password" style="font-weight: 600;">Sign In</a>
                    </span>
                </div>

            </form>

        </div>
    </div>

</body>
</html>
