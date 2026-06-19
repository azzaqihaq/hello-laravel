<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Account Management - Antigravity</title>

    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    
    <!-- Table & Badge Specific Styles -->
    <style>
        .table-wrapper {
            width: 100%;
            overflow-x: auto;
            margin-top: 1.5rem;
        }
        
        .accounts-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }
        
        .accounts-table th {
            padding: 1.15rem 1.5rem;
            color: var(--text-muted);
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 2px solid var(--border-color);
        }
        
        .accounts-table td {
            padding: 1.25rem 1.5rem;
            color: var(--text-main);
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
        }
        
        .accounts-table tr:hover td {
            background: hsla(224, 25%, 12%, 0.2);
        }
        
        /* Badges */
        .badge-role {
            display: inline-block;
            padding: 0.35rem 0.75rem;
            border-radius: 100px;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.02em;
        }
        
        .badge-role.admin {
            background: hsla(263, 85%, 65%, 0.15);
            border: 1px solid hsla(263, 85%, 65%, 0.3);
            color: hsl(263, 85%, 75%);
        }
        
        .badge-role.editor {
            background: hsla(190, 95%, 50%, 0.15);
            border: 1px solid hsla(190, 95%, 50%, 0.3);
            color: hsl(190, 95%, 60%);
        }
        
        .badge-role.user {
            background: hsla(290, 80%, 50%, 0.15);
            border: 1px solid hsla(290, 80%, 50%, 0.3);
            color: hsl(290, 80%, 70%);
        }
        
        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .badge-status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }
        
        .badge-status.active {
            color: hsl(150, 85%, 55%);
        }
        
        .badge-status.active .badge-status-dot {
            background-color: hsl(150, 85%, 55%);
            box-shadow: 0 0 10px hsl(150, 85%, 55%);
        }
        
        .badge-status.inactive {
            color: var(--text-dark);
        }
        
        .badge-status.inactive .badge-status-dot {
            background-color: var(--text-dark);
        }
        
        /* Action Buttons */
        .btn-status-toggle {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 8px;
            font-family: var(--font-sans);
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            transition: var(--transition-smooth);
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }
        
        .btn-status-toggle.activate {
            background: hsla(150, 85%, 55%, 0.1);
            border: 1px solid hsla(150, 85%, 55%, 0.25);
            color: hsl(150, 85%, 55%);
        }
        
        .btn-status-toggle.activate:hover {
            background: hsl(150, 85%, 55%);
            color: #fff;
            box-shadow: 0 4px 12px hsla(150, 85%, 55%, 0.25);
        }
        
        .btn-status-toggle.deactivate {
            background: hsla(0, 85%, 60%, 0.1);
            border: 1px solid hsla(0, 85%, 60%, 0.25);
            color: hsl(0, 85%, 60%);
        }
        
        .btn-status-toggle.deactivate:hover {
            background: hsl(0, 85%, 60%);
            color: #fff;
            box-shadow: 0 4px 12px hsla(0, 85%, 60%, 0.25);
        }
        
        .alert-banner {
            border-radius: 12px;
            padding: 1rem 1.25rem;
            font-size: 0.9rem;
            margin-bottom: 2rem;
            line-height: 1.4;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .alert-banner.success {
            background: hsla(150, 85%, 35%, 0.15);
            border: 1px solid hsla(150, 85%, 35%, 0.3);
            color: hsl(150, 85%, 55%);
        }
        
        .alert-banner.error {
            background: hsla(0, 85%, 45%, 0.15);
            border: 1px solid hsla(0, 85%, 45%, 0.3);
            color: hsl(0, 85%, 65%);
        }
        
        #ajax-alert {
            position: fixed;
            top: 2rem;
            right: 2rem;
            z-index: 9999;
            max-width: 320px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.45);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            animation: slide-in-toast 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        
        @keyframes slide-in-toast {
            from {
                transform: translateX(120%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Confirmation Modal */
        .confirm-modal-content {
            display: flex;
            flex-direction: column;
        }

        .confirm-modal-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.25rem;
        }

        .confirm-modal-icon.activate {
            background: hsla(150, 85%, 55%, 0.12);
            color: hsl(150, 85%, 55%);
        }

        .confirm-modal-icon.deactivate {
            background: hsla(0, 85%, 60%, 0.12);
            color: hsl(0, 85%, 60%);
        }

        .confirm-modal-icon svg {
            width: 24px;
            height: 24px;
        }

        .confirm-modal-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 0.5rem;
        }

        .confirm-modal-desc {
            font-size: 0.9rem;
            color: var(--text-muted);
            line-height: 1.55;
            margin-bottom: 1.75rem;
        }

        .confirm-modal-desc strong {
            color: var(--text-main);
        }

        .confirm-modal-actions {
            display: flex;
            gap: 0.75rem;
            justify-content: flex-end;
        }

        .btn-confirm-cancel {
            padding: 0.6rem 1.25rem;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            background: transparent;
            color: var(--text-muted);
            font-family: var(--font-sans);
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            transition: var(--transition-smooth);
        }

        .btn-confirm-cancel:hover {
            background: hsla(224, 20%, 20%, 0.5);
            color: var(--text-main);
        }

        .btn-confirm-proceed {
            padding: 0.6rem 1.25rem;
            border-radius: 10px;
            border: none;
            font-family: var(--font-sans);
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            transition: var(--transition-smooth);
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .btn-confirm-proceed.activate {
            background: hsl(150, 85%, 55%);
            color: #fff;
        }

        .btn-confirm-proceed.activate:hover {
            box-shadow: 0 4px 18px hsla(150, 85%, 55%, 0.35);
        }

        .btn-confirm-proceed.deactivate {
            background: hsl(0, 85%, 60%);
            color: #fff;
        }

        .btn-confirm-proceed.deactivate:hover {
            box-shadow: 0 4px 18px hsla(0, 85%, 60%, 0.35);
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

        <!-- Main Dashboard Workspace -->
        <main class="main-content">
            
            <header class="content-header">
                <h1 class="content-title">Account Management</h1>
                <p class="content-desc">Review registered user applications and toggle their activation status.</p>
            </header>

            <!-- Success/Error Alert Banners -->
            <div id="ajax-alert" style="display: none;" class="alert-banner"></div>

            @if (session('success'))
                <div class="alert-banner success">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                        <polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="alert-banner error">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Glassmorphic Users Card -->
            <div class="workspace-card" style="display: block; text-align: left; padding: 2rem; align-items: stretch; justify-content: flex-start; min-height: unset;">
                
                <div class="table-wrapper">
                    <table class="accounts-table">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Email Address</th>
                                <th>Selected Role</th>
                                <th>Status</th>
                                <th style="text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                                            <div class="user-avatar" style="width: 2.25rem; height: 2.25rem; font-size: 0.85rem; flex-shrink: 0; margin-bottom: 0;">
                                                @if($user->profile_photo)
                                                    <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile Photo">
                                                @else
                                                    <span>{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                                @endif
                                            </div>
                                            <div style="display: flex; flex-direction: column;">
                                                <span style="font-weight: 600;">{{ $user->name }}</span>
                                                <span style="font-size: 0.75rem; color: var(--text-dark);">{{ $user->member_id ?? 'No Member ID' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="color: var(--text-muted);">{{ $user->email }}</td>
                                    <td>
                                        <span class="badge-role {{ strtolower($user->role?->slug ?? 'user') }}">
                                            {{ $user->role?->name ?? 'None' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div id="status-container-{{ $user->id }}" class="badge-status {{ $user->is_active ? 'active' : 'inactive' }}">
                                            <div class="badge-status-dot"></div>
                                            <span id="status-label-{{ $user->id }}">{{ $user->is_active ? 'Active' : 'Inactive' }}</span>
                                        </div>
                                    </td>
                                    <td style="text-align: right;">
                                        @if (Auth::id() !== $user->id)
                                            <form action="{{ route('admin.accounts.toggle', $user) }}" method="POST" class="ajax-toggle-form" style="margin: 0; display: inline-block;">
                                                @csrf
                                                <button 
                                                    type="submit" 
                                                    class="btn-status-toggle {{ $user->is_active ? 'deactivate' : 'activate' }}"
                                                    id="btn-toggle-{{ $user->id }}"
                                                >
                                                    @if ($user->is_active)
                                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                                        </svg>
                                                        <span>Deactivate</span>
                                                    @else
                                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                                        </svg>
                                                        <span>Activate</span>
                                                    @endif
                                                </button>
                                            </form>
                                        @else
                                            <span style="color: var(--text-dark); font-size: 0.85rem; font-style: italic;">
                                                Logged In
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

        </main>
    </div>

    <!-- Confirmation Modal (Native Dialog) -->
    <dialog id="confirm-dialog" closedby="any" class="glass-dialog" aria-labelledby="confirm-modal-title">
        <div class="confirm-modal-content">
            <div class="confirm-modal-icon" id="confirm-modal-icon"></div>
            <h3 class="confirm-modal-title" id="confirm-modal-title"></h3>
            <p class="confirm-modal-desc" id="confirm-modal-desc"></p>
            <div class="confirm-modal-actions">
                <button type="button" class="btn-confirm-cancel" id="confirm-cancel">Cancel</button>
                <button type="button" class="btn-confirm-proceed" id="confirm-proceed">Confirm</button>
            </div>
        </div>
    </dialog>

    <!-- AJAX Account Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('.ajax-toggle-form');
            const alertDiv = document.getElementById('ajax-alert');
            
            // Mobile Profile Dropdown Toggle
            const profileTrigger = document.getElementById('user-profile-trigger');
            const dropdown = document.getElementById('profile-dropdown');
            
            if (profileTrigger && dropdown) {
                profileTrigger.addEventListener('click', function(e) {
                    e.stopPropagation();
                    dropdown.classList.toggle('show');
                });

                document.addEventListener('click', function() {
                    dropdown.classList.remove('show');
                });
            }
            
            // Confirmation Modal Elements
            const confirmDialog = document.getElementById('confirm-dialog');
            const modalIcon = document.getElementById('confirm-modal-icon');
            const modalTitle = document.getElementById('confirm-modal-title');
            const modalDesc = document.getElementById('confirm-modal-desc');
            const btnCancel = document.getElementById('confirm-cancel');
            const btnProceed = document.getElementById('confirm-proceed');
            let pendingForm = null;

            function showConfirmModal(form) {
                const button = form.querySelector('button');
                const isDeactivating = button.classList.contains('deactivate');
                const row = form.closest('tr');
                const userName = row.querySelector('td:first-child span').textContent.trim();

                pendingForm = form;

                if (isDeactivating) {
                    modalIcon.className = 'confirm-modal-icon deactivate';
                    modalIcon.innerHTML = `
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                    `;
                    modalTitle.textContent = 'Deactivate Account';
                    modalDesc.innerHTML = `Are you sure you want to deactivate <strong>${userName}</strong>'s account? They will be logged out of all devices immediately.`;
                    btnProceed.className = 'btn-confirm-proceed deactivate';
                    btnProceed.textContent = 'Deactivate';
                } else {
                    modalIcon.className = 'confirm-modal-icon activate';
                    modalIcon.innerHTML = `
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                            <polyline points="22 4 12 14.01 9 11.01"></polyline>
                        </svg>
                    `;
                    modalTitle.textContent = 'Activate Account';
                    modalDesc.innerHTML = `Are you sure you want to activate <strong>${userName}</strong>'s account? They will be able to log in.`;
                    btnProceed.className = 'btn-confirm-proceed activate';
                    btnProceed.textContent = 'Activate';
                }

                confirmDialog.showModal();
            }

            function hideConfirmModal() {
                confirmDialog.close();
                pendingForm = null;
            }

            // Close modal on Cancel
            btnCancel.addEventListener('click', hideConfirmModal);

            // Cleanup when dialog is closed natively (esc key, closedby, etc.)
            confirmDialog.addEventListener('close', function() {
                pendingForm = null;
            });

            // Fallback for click outside modal (backdrop click dismiss)
            if (!('closedBy' in HTMLDialogElement.prototype)) {
                confirmDialog.addEventListener('click', function(event) {
                    if (event.target !== confirmDialog) return;
                    const rect = confirmDialog.getBoundingClientRect();
                    const isDialogContent = (
                        rect.top <= event.clientY &&
                        event.clientY <= rect.top + rect.height &&
                        rect.left <= event.clientX &&
                        event.clientX <= rect.left + rect.width
                    );
                    if (!isDialogContent) {
                        hideConfirmModal();
                    }
                });
            }

            // Intercept form submissions to show modal first
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    showConfirmModal(this);
                });
            });

            // Proceed button executes the AJAX request
            btnProceed.addEventListener('click', function() {
                if (!pendingForm) return;

                const form = pendingForm;
                hideConfirmModal();

                const actionUrl = form.getAttribute('action');
                const formData = new FormData(form);
                const button = form.querySelector('button');

                // Disable button to prevent double-clicks
                button.disabled = true;
                button.style.opacity = '0.5';

                fetch(actionUrl, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw response;
                    }
                    return response.json();
                })
                .then(data => {
                    button.disabled = false;
                    button.style.opacity = '1';

                    if (data.success) {
                        // Extract user ID from button ID (btn-toggle-{id})
                        const idParts = button.id.split('-');
                        const userId = idParts[idParts.length - 1];

                        const statusContainer = document.getElementById('status-container-' + userId);
                        const statusLabel = document.getElementById('status-label-' + userId);

                        if (data.is_active) {
                            // Set to Active
                            statusContainer.className = 'badge-status active';
                            statusLabel.textContent = 'Active';

                            // Update button to Deactivate state
                            button.className = 'btn-status-toggle deactivate';
                            button.innerHTML = `
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                </svg>
                                <span>Deactivate</span>
                            `;
                        } else {
                            // Set to Inactive
                            statusContainer.className = 'badge-status inactive';
                            statusLabel.textContent = 'Inactive';

                            // Update button to Activate state
                            button.className = 'btn-status-toggle activate';
                            button.innerHTML = `
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                </svg>
                                <span>Activate</span>
                            `;
                        }

                        // Show success banner
                        alertDiv.className = 'alert-banner success';
                        alertDiv.innerHTML = `
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                            <span>Successful</span>
                        `;
                        alertDiv.style.display = 'flex';

                        // Auto hide notice after 4 seconds
                        setTimeout(() => {
                            alertDiv.style.display = 'none';
                        }, 4000);
                    }
                })
                .catch(err => {
                    button.disabled = false;
                    button.style.opacity = '1';

                    // Parse JSON error response
                    if (err.json) {
                        err.json().then(errorData => {
                            alertDiv.className = 'alert-banner error';
                            alertDiv.innerHTML = `
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="8" x2="12" y2="12"></line>
                                    <line x1="12" y1="16" x2="12.01" y2="16"></line>
                                </svg>
                                <span>${errorData.message || 'An error occurred.'}</span>
                            `;
                            alertDiv.style.display = 'flex';
                        });
                    } else {
                        alertDiv.className = 'alert-banner error';
                        alertDiv.innerHTML = `
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                            <span>Failed to toggle status. Please try again.</span>
                        `;
                        alertDiv.style.display = 'flex';
                    }
                });
            });
        });
    </script>
</body>
</html>
