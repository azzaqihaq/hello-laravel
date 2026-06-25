<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'dark';
            document.documentElement.setAttribute('data-theme', savedTheme);
        })();
    </script>
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
            border-radius: 20px;
            padding: 2.25rem 2.5rem;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
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

        /* Premium Theme Toggle Switch */
        .theme-switch-wrapper {
            position: relative;
            display: inline-flex;
            background: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 9999px;
            padding: 4px;
            cursor: pointer;
            user-select: none;
            width: 150px;
            height: 48px;
            align-items: center;
            justify-content: space-between;
            overflow: hidden;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2);
            transition: var(--transition-smooth);
        }

        .theme-switch-wrapper:hover {
            border-color: var(--primary);
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2), 0 0 10px var(--primary-glow);
        }

        /* The sliding pill */
        .theme-switch-slider {
            position: absolute;
            top: 4px;
            left: 4px;
            width: 68px;
            height: 38px;
            border-radius: 9999px;
            background: linear-gradient(135deg, var(--primary) 0%, hsl(263, 85%, 55%) 100%);
            box-shadow: 0 4px 10px var(--primary-glow);
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            z-index: 1;
        }

        [data-theme="light"] .theme-switch-slider {
            transform: translateX(74px);
            background: linear-gradient(135deg, var(--primary) 0%, hsl(263, 75%, 45%) 100%);
            box-shadow: 0 4px 10px var(--primary-glow);
        }

        /* Icons inside switch */
        .theme-switch-btn {
            position: relative;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
            z-index: 2;
            color: var(--text-muted);
            font-size: 0.8rem;
            font-weight: 700;
            gap: 0.35rem;
            transition: color 0.3s ease;
        }

        .theme-switch-btn svg {
            width: 14px;
            height: 14px;
            fill: none;
            stroke: currentColor;
            stroke-width: 2.5;
            transition: transform 0.3s ease;
        }

        /* Active text colors */
        .theme-switch-btn.active {
            color: #fff !important;
        }
        
        .theme-switch-btn.active svg {
            transform: rotate(360deg);
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
                <p class="content-desc">Manage your workspace options and interface theme preference.</p>
            </header>

            <div class="settings-grid">
                
                <!-- Card: Theme Configuration -->
                <div class="settings-card">
                    <div class="settings-option">
                        <div class="option-info">
                            <span class="option-title">Theme Preference</span>
                            <span class="option-desc">Toggle the global website theme color between dark and light mode.</span>
                        </div>
                        
                        <!-- Dynamic Switch Slider Control -->
                        <div class="theme-switch-wrapper" id="theme-toggle-switch">
                            <div class="theme-switch-slider"></div>
                            
                            <!-- Left Button: Dark -->
                            <div class="theme-switch-btn" id="btn-theme-dark">
                                <svg viewBox="0 0 24 24">
                                    <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                                </svg>
                                <span>Dark</span>
                            </div>
                            
                            <!-- Right Button: Light -->
                            <div class="theme-switch-btn" id="btn-theme-light">
                                <svg viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="5"></circle>
                                    <line x1="12" y1="1" x2="12" y2="3"></line>
                                    <line x1="12" y1="21" x2="12" y2="23"></line>
                                    <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
                                    <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
                                    <line x1="1" y1="12" x2="3" y2="12"></line>
                                    <line x1="21" y1="12" x2="23" y2="12"></line>
                                    <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
                                    <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
                                </svg>
                                <span>Light</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </main>
    </div>

    <!-- Toggle Logic Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleSwitch = document.getElementById('theme-toggle-switch');
            const btnDark = document.getElementById('btn-theme-dark');
            const btnLight = document.getElementById('btn-theme-light');
            
            // Sync active text class depending on current theme
            function syncSwitchButtons(theme) {
                if (theme === 'light') {
                    btnLight.classList.add('active');
                    btnDark.classList.remove('active');
                } else {
                    btnDark.classList.add('active');
                    btnLight.classList.remove('active');
                }
            }
            
            // Initial Sync
            const currentTheme = document.documentElement.getAttribute('data-theme') || 'dark';
            syncSwitchButtons(currentTheme);

            // Click Toggle Action
            toggleSwitch.addEventListener('click', function() {
                const activeTheme = document.documentElement.getAttribute('data-theme') === 'light' ? 'dark' : 'light';
                
                // Set HTML attribute for immediate CSS changes
                document.documentElement.setAttribute('data-theme', activeTheme);
                
                // Save to storage
                localStorage.setItem('theme', activeTheme);
                
                // Sync button text highlight
                syncSwitchButtons(activeTheme);
            });
        });
    </script>
</body>
</html>
