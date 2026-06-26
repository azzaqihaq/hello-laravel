<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Settings - Coleo.Inc</title>

    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">

    <!-- Page Specific Styles -->
    <style>
        .settings-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 1.5rem;
            margin-top: 1.5rem;
            max-width: 100%;
        }

        .settings-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 2.25rem 2.5rem;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            display: flex;
            flex-direction: column;
        }

        .settings-option {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 2rem;
            padding: 0.5rem 0;
        }

        .option-info {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }

        .option-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-main);
            font-family: var(--font-display);
        }

        .option-desc {
            font-size: 0.85rem;
            color: var(--text-muted);
            line-height: 1.4;
        }

        /* Settings Section Header */
        .settings-section-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 0.5rem;
            font-family: var(--font-display);
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 0.5rem;
        }

        /* Radio Options */
        .radio-group {
            display: flex;
            flex-direction: column;
            gap: 0.85rem;
            margin-top: 1.25rem;
        }

        .radio-label {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.95rem;
            color: var(--text-muted);
            cursor: pointer;
            user-select: none;
            transition: var(--transition-smooth);
        }

        .radio-label input[type="radio"] {
            appearance: none;
            -webkit-appearance: none;
            width: 20px;
            height: 20px;
            border: 1.5px solid var(--border-color);
            border-radius: 50%;
            outline: none;
            background: var(--input-bg);
            cursor: pointer;
            position: relative;
            transition: var(--transition-smooth);
        }

        .radio-label input[type="radio"]:checked {
            border-color: var(--border-hover);
            background: var(--primary);
        }

        .radio-label input[type="radio"]:checked::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--on-primary);
        }

        .radio-label:hover {
            color: var(--text-main);
        }

        /* Premium Toggle Switch Slider */
        .switch-option {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-color);
        }

        .switch-option:last-child {
            border-bottom: none;
        }

        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 48px;
            height: 24px;
            flex-shrink: 0;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider-round {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: var(--border-color);
            transition: .3s;
            border-radius: 34px;
        }

        .slider-round:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: var(--bg-card);
            transition: .3s;
            border-radius: 50%;
        }

        input:checked + .slider-round {
            background-color: var(--primary);
        }

        input:checked + .slider-round:before {
            transform: translateX(24px);
            background-color: var(--on-primary);
        }

        .btn-save-settings {
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 24px;
            background: var(--primary);
            color: var(--on-primary);
            font-family: var(--font-sans);
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            transition: var(--transition-smooth);
            box-shadow: 0 4px 12px var(--primary-glow);
            margin-top: 1.5rem;
            align-self: flex-start;
        }

        .btn-save-settings:hover {
            background: #cdffad;
            box-shadow: 0 8px 24px var(--primary-glow);
            transform: translateY(-2px);
        }

        /* Range Slider Styles */
        .slider-control-wrapper {
            display: flex;
            align-items: center;
            gap: 1rem;
            min-width: 240px;
        }

        .range-slider {
            -webkit-appearance: none;
            appearance: none;
            width: 100%;
            height: 6px;
            border-radius: 3px;
            background: var(--border-color);
            outline: none;
            transition: background 0.3s;
        }

        /* WebKit/Blink (Chrome, Safari, Edge) */
        .range-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: var(--on-primary);
            border: 2px solid var(--primary);
            cursor: pointer;
            transition: transform 0.1s, background-color 0.2s;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }

        .range-slider::-webkit-slider-thumb:hover {
            transform: scale(1.15);
            background: var(--primary);
        }

        /* Firefox */
        .range-slider::-moz-range-thumb {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: var(--on-primary);
            border: 2px solid var(--primary);
            cursor: pointer;
            transition: transform 0.1s, background-color 0.2s;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        }

        .range-slider::-moz-range-thumb:hover {
            transform: scale(1.15);
            background: var(--primary);
        }

        .range-value-label {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text-main);
            min-width: 45px;
            text-align: right;
            font-family: var(--font-display);
        }

        /* ── Session Management ── */
        .session-list {
            display: flex;
            flex-direction: column;
            gap: 0;
            margin-top: 1.25rem;
        }

        .session-item {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-color);
        }

        .session-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .session-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: var(--bg-base);
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: var(--text-muted);
        }

        .session-icon svg {
            width: 22px;
            height: 22px;
        }

        .session-info {
            flex: 1;
            min-width: 0;
        }

        .session-device {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--text-main);
            font-family: var(--font-display);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .session-current-badge {
            display: inline-block;
            padding: 0.15rem 0.6rem;
            border-radius: 100px;
            font-size: 0.72rem;
            font-weight: 700;
            font-family: var(--font-sans);
            letter-spacing: 0.04em;
            background: var(--success-bg);
            border: 1px solid var(--success-border);
            color: var(--success-text);
        }

        .session-meta {
            font-size: 0.82rem;
            color: var(--text-muted);
            margin-top: 0.2rem;
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            align-items: center;
        }

        .session-meta-sep {
            color: var(--border-color);
        }

        .btn-revoke-session {
            padding: 0.45rem 1rem;
            border: 1px solid hsl(0, 80%, 80%);
            border-radius: 10px;
            background: hsl(0, 80%, 97%);
            color: hsl(0, 65%, 50%);
            font-family: var(--font-sans);
            font-weight: 600;
            font-size: 0.82rem;
            cursor: pointer;
            transition: var(--transition-smooth);
            white-space: nowrap;
            flex-shrink: 0;
        }

        .btn-revoke-session:hover {
            background: hsl(0, 80%, 93%);
            border-color: hsl(0, 65%, 60%);
            color: hsl(0, 65%, 40%);
        }

        .btn-revoke-session:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .session-footer {
            margin-top: 1.5rem;
            padding-top: 1.25rem;
            border-top: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .session-footer-note {
            font-size: 0.82rem;
            color: var(--text-muted);
            line-height: 1.4;
        }

        .btn-revoke-all {
            padding: 0.6rem 1.25rem;
            border: 1px solid hsl(0, 80%, 80%);
            border-radius: 12px;
            background: transparent;
            color: hsl(0, 65%, 50%);
            font-family: var(--font-sans);
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            transition: var(--transition-smooth);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            white-space: nowrap;
        }

        .btn-revoke-all:hover {
            background: hsl(0, 80%, 97%);
            border-color: hsl(0, 65%, 60%);
            color: hsl(0, 65%, 40%);
        }

        .btn-revoke-all:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .session-empty {
            text-align: center;
            padding: 2rem 0 0.5rem;
            color: var(--text-muted);
            font-size: 0.9rem;
        }

        /* ── Change Password Card ── */
        .pw-form-group {
            margin-bottom: 1.1rem;
        }

        .pw-form-group label {
            display: block;
            font-size: 0.83rem;
            font-weight: 600;
            color: var(--text-muted);
            margin-bottom: 0.45rem;
        }

        .pw-input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }

        .pw-input-wrap input {
            width: 100%;
            padding: 0.72rem 2.6rem 0.72rem 1rem;
            background: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 10px;
            color: var(--text-main);
            font-family: var(--font-sans);
            font-size: 0.9rem;
            transition: var(--transition-smooth);
            box-sizing: border-box;
        }

        .pw-input-wrap input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-glow);
        }

        .pw-input-wrap input.has-error {
            border-color: hsl(0, 70%, 60%);
            box-shadow: 0 0 0 3px hsla(0, 70%, 60%, 0.15);
        }

        .pw-toggle-btn {
            position: absolute;
            right: 0.75rem;
            background: none;
            border: none;
            cursor: pointer;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            padding: 0;
        }

        .pw-toggle-btn:hover { color: var(--text-main); }

        .pw-error {
            font-size: 0.78rem;
            color: hsl(0, 70%, 55%);
            margin-top: 0.3rem;
        }

        .pw-last-changed {
            font-size: 0.82rem;
            color: var(--text-muted);
            margin-bottom: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .pw-last-changed svg {
            flex-shrink: 0;
            opacity: 0.6;
        }

        .btn-change-password {
            padding: 0.7rem 1.75rem;
            border: none;
            border-radius: 24px;
            background: var(--primary);
            color: var(--on-primary);
            font-family: var(--font-sans);
            font-weight: 600;
            font-size: 0.9rem;
            cursor: pointer;
            transition: var(--transition-smooth);
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 4px 12px var(--primary-glow);
            margin-top: 0.5rem;
        }

        .btn-change-password:hover {
            background: #cdffad;
            box-shadow: 0 8px 24px var(--primary-glow);
            transform: translateY(-2px);
        }

        .btn-change-password:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        /* ── Revoke Confirm Dialog ── */
        .revoke-dialog-content {
            display: flex;
            flex-direction: column;
            gap: 1.1rem;
        }

        .revoke-dialog-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: hsl(0, 80%, 96%);
            border: 1px solid hsl(0, 80%, 88%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: hsl(0, 65%, 52%);
        }

        .revoke-dialog-title {
            font-size: 1.15rem;
            font-weight: 800;
            color: var(--text-main);
            font-family: var(--font-display);
            margin: 0;
        }

        .revoke-dialog-body {
            font-size: 0.88rem;
            color: var(--text-muted);
            line-height: 1.5;
            margin: 0;
        }

        .revoke-dialog-actions {
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
            margin-top: 0.25rem;
        }

        .btn-dialog-cancel {
            padding: 0.6rem 1.25rem;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            background: transparent;
            color: var(--text-muted);
            font-family: var(--font-sans);
            font-weight: 600;
            font-size: 0.88rem;
            cursor: pointer;
            transition: var(--transition-smooth);
        }

        .btn-dialog-cancel:hover {
            background: var(--bg-base);
            color: var(--text-main);
        }

        .btn-dialog-confirm-revoke {
            padding: 0.6rem 1.25rem;
            border: none;
            border-radius: 10px;
            background: hsl(0, 70%, 55%);
            color: #fff;
            font-family: var(--font-sans);
            font-weight: 600;
            font-size: 0.88rem;
            cursor: pointer;
            transition: var(--transition-smooth);
            box-shadow: 0 4px 12px hsla(0, 70%, 55%, 0.25);
        }

        .btn-dialog-confirm-revoke:hover {
            background: hsl(0, 70%, 47%);
            box-shadow: 0 6px 18px hsla(0, 70%, 55%, 0.35);
        }
    </style>
</head>
<body>

    <!-- Ambient glowing backgrounds -->
    <div class="ambient-bg">
        <div class="ambient-glow-1"></div>
        <div class="ambient-glow-2"></div>
    </div>

    <div class="dashboard-container">
        <!-- Sidebar Navigation -->
        @include('partials.sidebar')

        <!-- Settings Workspace -->
        <main class="main-content">
            
            <header class="content-header">
                <h1 class="content-title">Settings</h1>
                <p class="content-desc">Manage your workspace preferences, notifications, and security options.</p>
            </header>

            <form id="settings-form" action="{{ route('settings.update') }}" method="POST">
                @csrf
                <div class="settings-grid">
                    
                    <!-- Card: Notification Settings -->
                    <div class="settings-card">
                        <h2 class="settings-section-title">Notification Settings</h2>
                        <p class="option-desc">Select when you want to receive notifications and alerts.</p>
                        
                        <div class="radio-group">
                            <label class="radio-label">
                                <input type="radio" name="notifications" value="all" {{ ($user->settings->notifications ?? 'all') === 'all' ? 'checked' : '' }}>
                                <span>Receive all notifications (Email & Desktop push alerts)</span>
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="notifications" value="mentions" {{ ($user->settings->notifications ?? 'all') === 'mentions' ? 'checked' : '' }}>
                                <span>Only direct mentions and actions (Recommended)</span>
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="notifications" value="none" {{ ($user->settings->notifications ?? 'all') === 'none' ? 'checked' : '' }}>
                                <span>Mute all notifications (Silence alerts)</span>
                            </label>
                        </div>
                    </div>

                <!-- Card: Privacy Settings -->
                <div class="settings-card">
                    <h2 class="settings-section-title">Privacy & Security</h2>
                    <p class="option-desc" style="margin-bottom: 0.75rem;">Adjust visibility settings and security diagnostics.</p>
                    
                    <div class="switch-option">
                        <div class="option-info">
                            <span class="option-title">Public Profile Visibility</span>
                            <span class="option-desc">Allow search engines and non-members to find your profile details.</span>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" checked>
                            <span class="slider-round"></span>
                        </label>
                    </div>

                    <div class="switch-option">
                        <div class="option-info">
                            <span class="option-title">Show Active Status</span>
                            <span class="option-desc">Show other members when you are active on the dashboard.</span>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" checked>
                            <span class="slider-round"></span>
                        </label>
                    </div>

                    <div class="switch-option">
                        <div class="option-info">
                            <span class="option-title">Anonymous Crash Telemetry</span>
                            <span class="option-desc">Share crash and analytics data anonymously to help diagnostic metrics.</span>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox">
                            <span class="slider-round"></span>
                        </label>
                    </div>
                </div>

                <!-- Card: Interface & Accessibility -->
                <div class="settings-card">
                    <h2 class="settings-section-title">Interface & Accessibility</h2>
                    <p class="option-desc" style="margin-bottom: 0.75rem;">Customize visual scales and auto-refresh intervals for your workspace.</p>
                    
                    <div class="switch-option">
                        <div class="option-info">
                            <span class="option-title">Interface Font Scale</span>
                            <span class="option-desc">Adjust the base text sizing of dashboard headings and labels.</span>
                        </div>
                        <div class="slider-control-wrapper">
                            <input type="range" class="range-slider" id="font-scale" min="12" max="20" value="16" oninput="document.getElementById('font-scale-val').textContent = this.value + 'px'">
                            <span class="range-value-label" id="font-scale-val">16px</span>
                        </div>
                    </div>

                    <div class="switch-option">
                        <div class="option-info">
                            <span class="option-title">Dashboard Refresh Rate</span>
                            <span class="option-desc">Set the automatic background refresh frequency.</span>
                        </div>
                        <div class="slider-control-wrapper">
                            <input type="range" class="range-slider" id="refresh-rate" min="5" max="60" value="30" step="5" oninput="document.getElementById('refresh-rate-val').textContent = this.value + 's'">
                            <span class="range-value-label" id="refresh-rate-val">30s</span>
                        </div>
                    </div>
                </div>

                <!-- Card: Active Sessions -->
                <div class="settings-card" id="sessions-card">
                    <h2 class="settings-section-title">Active Sessions</h2>
                    <p class="option-desc">Devices that are currently signed in to your account. Revoke any session you don't recognise.</p>

                    <div class="session-list" id="session-list">
                        @forelse ($sessions as $session)
                            <div class="session-item" id="session-{{ $session->id }}" data-session-id="{{ $session->id }}">

                                {{-- Device icon --}}
                                <div class="session-icon">
                                    @if ($session->is_mobile)
                                        {{-- Phone icon --}}
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect>
                                            <line x1="12" y1="18" x2="12.01" y2="18"></line>
                                        </svg>
                                    @else
                                        {{-- Monitor icon --}}
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                                            <line x1="8" y1="21" x2="16" y2="21"></line>
                                            <line x1="12" y1="17" x2="12" y2="21"></line>
                                        </svg>
                                    @endif
                                </div>

                                {{-- Session info --}}
                                <div class="session-info">
                                    <div class="session-device">
                                        <span>{{ $session->browser }} on {{ $session->os }}</span>
                                        @if ($session->is_current)
                                            <span class="session-current-badge">Current session</span>
                                        @endif
                                    </div>
                                    <div class="session-meta">
                                        <span>{{ $session->ip_address }}</span>
                                        <span class="session-meta-sep">·</span>
                                        <span class="session-last-active" data-timestamp="{{ $session->last_activity }}">
                                            {{ \Carbon\Carbon::createFromTimestamp($session->last_activity)->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Revoke button --}}
                                @if (!$session->is_current)
                                    <button
                                        type="button"
                                        class="btn-revoke-session"
                                        data-session-id="{{ $session->id }}"
                                        data-revoke-url="{{ url('/dashboard/settings/sessions/' . $session->id . '/revoke') }}"
                                    >Revoke</button>
                                @endif
                            </div>
                        @empty
                            <div class="session-empty">No active sessions found.</div>
                        @endforelse
                    </div>

                    @if ($sessions->where('is_current', false)->count() > 0)
                        <div class="session-footer">
                            <p class="session-footer-note">
                                Revoking a session immediately signs out that device.
                            </p>
                            <button
                                type="button"
                                class="btn-revoke-all"
                                id="btn-revoke-all"
                                data-url="{{ route('settings.sessions.revoke-others') }}"
                            >
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" y1="12" x2="9" y2="12"></line>
                                </svg>
                                Revoke all other sessions
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Card: Change Password -->
                <div class="settings-card">
                    <h2 class="settings-section-title">Change Password</h2>
                    <p class="option-desc">Update your account password. You'll remain logged in on this device.</p>

                    @if ($passwordChangedAt)
                        <div class="pw-last-changed" id="pw-last-changed-wrap">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            Last changed <span id="pw-last-changed-text">{{ $passwordChangedAt }}</span>
                        </div>
                    @else
                        <div class="pw-last-changed" id="pw-last-changed-wrap" style="display:none;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            Last changed <span id="pw-last-changed-text"></span>
                        </div>
                    @endif

                    <form id="password-form" action="{{ route('settings.password.change') }}" method="POST" novalidate>
                        @csrf
                        <div class="pw-form-group">
                            <label for="current_password">Current Password</label>
                            <div class="pw-input-wrap">
                                <input type="password" id="current_password" name="current_password" autocomplete="current-password" placeholder="Enter your current password">
                                <button type="button" class="pw-toggle-btn" data-target="current_password" aria-label="Toggle visibility">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                            </div>
                            <div class="pw-error" id="error-current_password"></div>
                        </div>

                        <div class="pw-form-group">
                            <label for="new_password">New Password</label>
                            <div class="pw-input-wrap">
                                <input type="password" id="new_password" name="new_password" autocomplete="new-password" placeholder="At least 8 characters">
                                <button type="button" class="pw-toggle-btn" data-target="new_password" aria-label="Toggle visibility">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                            </div>
                            <div class="pw-error" id="error-new_password"></div>
                        </div>

                        <div class="pw-form-group">
                            <label for="new_password_confirmation">Confirm New Password</label>
                            <div class="pw-input-wrap">
                                <input type="password" id="new_password_confirmation" name="new_password_confirmation" autocomplete="new-password" placeholder="Repeat your new password">
                                <button type="button" class="pw-toggle-btn" data-target="new_password_confirmation" aria-label="Toggle visibility">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                            </div>
                            <div class="pw-error" id="error-new_password_confirmation"></div>
                        </div>

                        <button type="submit" class="btn-change-password" id="btn-change-password">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                            <span>Update Password</span>
                        </button>
                    </form>
                </div>

                </div>
            </form>

        </main>
    </div>

    <!-- Revoke Confirmation Dialog -->
    <dialog id="revoke-confirm-dialog" class="glass-dialog" aria-labelledby="revoke-dialog-title">
        <div class="revoke-dialog-content">
            <div class="revoke-dialog-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
            </div>
            <h3 id="revoke-dialog-title" class="revoke-dialog-title">Revoke Session?</h3>
            <p class="revoke-dialog-body" id="revoke-dialog-body">
                This will immediately sign out that device. The user will need to log in again.
            </p>
            <div class="revoke-dialog-actions">
                <button type="button" class="btn-dialog-cancel" id="btn-revoke-cancel">Cancel</button>
                <button type="button" class="btn-dialog-confirm-revoke" id="btn-revoke-confirm">Yes, Revoke</button>
            </div>
        </div>
    </dialog>

    <!-- AJAX Settings Save Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('settings-form');
            const radios = document.querySelectorAll('input[name="notifications"]');

            function autoSaveSettings() {
                const formData = new FormData(form);

                fetch(form.getAttribute('action'), {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) return response.json().then(d => { throw d; });
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        showToast('success', 'Preferences auto-saved.');
                    }
                })
                .catch(err => {
                    showToast('error', err.message || 'Failed to auto-save settings.');
                });
            }

            radios.forEach(radio => {
                radio.addEventListener('change', autoSaveSettings);
            });

            // ── Toast Helper ──
            function showToast(type, message) {
                const existing = document.querySelectorAll('.toast-alert');
                existing.forEach(el => el.remove());

                const toast = document.createElement('div');
                toast.className = `toast-alert ${type}`;
                
                let iconSvg = '';
                if (type === 'success') {
                    iconSvg = `
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                    `;
                } else {
                    iconSvg = `
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                    `;
                }

                toast.innerHTML = `
                    ${iconSvg}
                    <span>${message}</span>
                `;
                document.body.appendChild(toast);

                setTimeout(() => {
                    toast.style.animation = 'slide-in-toast 0.3s cubic-bezier(0.16, 1, 0.3, 1) reverse forwards';
                    setTimeout(() => toast.remove(), 300);
                }, 4000);
            }

            // ── Session Revoke Logic ──
            const csrfToken = document.querySelector('meta[name="csrf-token"]')
                ? document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                : '{{ csrf_token() }}';

            const revokeDialog    = document.getElementById('revoke-confirm-dialog');
            const btnRevokeCancel = document.getElementById('btn-revoke-cancel');
            const btnRevokeConfirm = document.getElementById('btn-revoke-confirm');

            // State for the pending revoke
            let pendingRevokeAction = null;

            // Cancel button
            btnRevokeCancel?.addEventListener('click', () => {
                revokeDialog.close();
                pendingRevokeAction = null;
            });

            // Helper: animate and remove a session row
            function removeSessionRow(sessionId) {
                const item = document.getElementById('session-' + sessionId);
                if (!item) return;
                item.style.transition = 'opacity 0.3s ease, max-height 0.4s ease';
                item.style.overflow = 'hidden';
                item.style.opacity = '0';
                item.style.maxHeight = item.offsetHeight + 'px';
                requestAnimationFrame(() => {
                    item.style.maxHeight = '0';
                    item.style.paddingTop = '0';
                    item.style.paddingBottom = '0';
                });
                setTimeout(() => {
                    item.remove();
                    const remaining = document.querySelectorAll('.btn-revoke-session');
                    if (remaining.length === 0) {
                        document.querySelector('.session-footer')?.remove();
                    }
                }, 400);
            }

            // Confirm button executes the pending action
            btnRevokeConfirm?.addEventListener('click', async () => {
                if (!pendingRevokeAction) return;
                revokeDialog.close();

                const { url, sessionId, revokeAll } = pendingRevokeAction;
                pendingRevokeAction = null;

                try {
                    const res = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': csrfToken,
                        }
                    });
                    const data = await res.json();

                    if (data.success) {
                        if (revokeAll) {
                            document.querySelectorAll('.btn-revoke-session').forEach(b => {
                                removeSessionRow(b.dataset.sessionId);
                            });
                            document.querySelector('.session-footer')?.remove();
                            showToast('success', 'All other sessions have been revoked.');
                        } else {
                            removeSessionRow(sessionId);
                            showToast('success', 'Session revoked.');
                        }
                    } else {
                        showToast('error', data.message || 'Failed to revoke session.');
                    }
                } catch (e) {
                    showToast('error', 'Network error. Please try again.');
                }
            });

            // Per-session revoke — open confirm dialog
            document.getElementById('session-list')?.addEventListener('click', function (e) {
                const btn = e.target.closest('.btn-revoke-session');
                if (!btn) return;

                pendingRevokeAction = {
                    url: btn.dataset.revokeUrl,
                    sessionId: btn.dataset.sessionId,
                    revokeAll: false,
                };

                document.getElementById('revoke-dialog-body').textContent =
                    'This will immediately sign out that device. The user will need to log in again.';
                revokeDialog.showModal();
            });

            // Revoke all — open confirm dialog
            document.getElementById('btn-revoke-all')?.addEventListener('click', function () {
                pendingRevokeAction = {
                    url: this.dataset.url,
                    sessionId: null,
                    revokeAll: true,
                };

                document.getElementById('revoke-dialog-body').textContent =
                    'This will sign out all other devices immediately. Only your current session will remain active.';
                revokeDialog.showModal();
            });

            // ── Change Password ──
            const passwordForm = document.getElementById('password-form');

            passwordForm?.addEventListener('submit', async function (e) {
                e.preventDefault();

                // Clear previous errors
                document.querySelectorAll('.pw-error').forEach(el => el.textContent = '');
                document.querySelectorAll('.pw-input-wrap input').forEach(el => el.classList.remove('has-error'));

                const btn = document.getElementById('btn-change-password');
                btn.disabled = true;
                btn.querySelector('span').textContent = 'Updating…';

                try {
                    const formData = new FormData(passwordForm);
                    const res = await fetch(passwordForm.getAttribute('action'), {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        }
                    });
                    const data = await res.json();

                    if (data.success) {
                        showToast('success', data.message || 'Password updated successfully.');
                        passwordForm.reset();

                        // Update last-changed label
                        if (data.password_changed_at) {
                            const wrap = document.getElementById('pw-last-changed-wrap');
                            const txt  = document.getElementById('pw-last-changed-text');
                            if (wrap) wrap.style.display = 'flex';
                            if (txt)  txt.textContent = data.password_changed_at;
                        }
                    } else if (data.errors) {
                        for (const [field, messages] of Object.entries(data.errors)) {
                            const errEl = document.getElementById('error-' + field);
                            const inputEl = document.getElementById(field);
                            if (errEl) errEl.textContent = messages[0];
                            if (inputEl) inputEl.classList.add('has-error');
                        }
                    }
                } catch (e) {
                    showToast('error', 'Network error. Please try again.');
                } finally {
                    btn.disabled = false;
                    btn.querySelector('span').textContent = 'Update Password';
                }
            });

            // ── Show / Hide Password Toggles ──
            document.querySelectorAll('.pw-toggle-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const targetId = this.dataset.target;
                    const input = document.getElementById(targetId);
                    if (!input) return;
                    input.type = input.type === 'password' ? 'text' : 'password';
                });
            });

        });
    </script>

</body>
</html>
