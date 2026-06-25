<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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

                </div>
            </form>

        </main>
    </div>

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
        });
    </script>

</body>
</html>
