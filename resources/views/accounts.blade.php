<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Account Management - Coleo.Inc</title>

    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    
    <!-- Table & Badge Specific Styles -->
    <style>
        .table-wrapper {
            width: 100%;
            max-width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-top: 1.5rem;
        }
        
        .accounts-table {
            width: 100%;
            min-width: 800px;
            border-collapse: collapse;
            text-align: left;
            table-layout: fixed;
        }

        .accounts-table th:nth-child(1) { width: 28%; }
        .accounts-table th:nth-child(2) { width: 32%; }
        .accounts-table th:nth-child(3) { width: 18%; }
        .accounts-table th:nth-child(4) { width: 12%; }
        .accounts-table th:nth-child(5) { width: 10%; }
        
        .accounts-table th {
            padding: 1.15rem 1.5rem;
            color: var(--text-muted);
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 2px solid var(--border-color);
            white-space: nowrap;
        }
        
        .accounts-table td {
            padding: 1.25rem 1.5rem;
            color: var(--text-main);
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
            white-space: nowrap;
        }
        
        .accounts-table tr:hover td {
            background: var(--tr-hover-bg);
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
            background: var(--success-bg);
            border: 1px solid var(--success-border);
            color: var(--success-text);
        }
        
        .badge-role.editor {
            background: rgba(56, 200, 255, 0.15);
            border: 1px solid rgba(56, 200, 255, 0.3);
            color: var(--accent);
        }
        
        .badge-role.user {
            background: var(--bg-base);
            border: 1px solid var(--border-color);
            color: var(--text-muted);
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
            border-radius: 24px;
            font-family: var(--font-sans);
            font-weight: 600;
            font-size: 0.85rem;
            cursor: pointer;
            transition: var(--transition-smooth);
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }
        
        .btn-status-toggle.activate, .btn-status-toggle.deactivate {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            color: var(--text-main);
        }
        
        .btn-status-toggle.activate:hover, .btn-status-toggle.deactivate:hover {
            background: var(--primary);
            border-color: var(--border-hover);
            color: var(--on-primary);
            box-shadow: 0 4px 12px var(--primary-glow);
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
            background: var(--success-bg);
            border: 1px solid var(--success-border);
            color: var(--success-text);
        }
        
        .alert-banner.error {
            background: var(--error-bg);
            border: 1px solid var(--error-border);
            color: var(--error-text);
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
            background: var(--success-bg);
            border: 1px solid var(--success-border);
            color: var(--success-text);
        }
 
        .confirm-modal-icon.deactivate {
            background: var(--error-bg);
            border: 1px solid var(--error-border);
            color: var(--danger);
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
            border-radius: 24px;
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
            background: var(--bg-base);
            color: var(--text-main);
            border-color: var(--border-hover);
        }

        .btn-confirm-proceed {
            padding: 0.6rem 1.25rem;
            border-radius: 24px;
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

        .btn-confirm-proceed.activate, .btn-confirm-proceed.deactivate {
            background: var(--primary);
            color: var(--on-primary);
            border: none;
            box-shadow: 0 4px 12px var(--primary-glow);
        }

        .btn-confirm-proceed.activate:hover, .btn-confirm-proceed.deactivate:hover {
            transform: translateY(-2px);
            background: #cdffad;
            color: var(--on-primary);
            box-shadow: 0 8px 24px var(--primary-glow);
        }

        /* Responsive accounts card styling */
        .accounts-workspace-card {
            display: block;
            text-align: left;
            padding: 2.25rem 2.5rem;
            align-items: stretch;
            justify-content: flex-start;
            min-height: unset;
            max-width: 100%;
            overflow: hidden;
        }

        @media (max-width: 768px) {
            .accounts-workspace-card {
                padding: 1rem 0.75rem !important;
            }

            .accounts-content-header .content-title {
                font-size: 1.5rem;
            }

            .accounts-content-header .content-desc {
                font-size: 0.9rem;
            }

            .table-actions-bar {
                flex-direction: column !important;
                align-items: stretch !important;
                gap: 0.75rem !important;
            }

            .table-actions-bar > div:first-child {
                max-width: 100% !important;
                min-width: 0 !important;
            }

            .table-actions-bar .filter-options {
                width: 100%;
            }

            .table-actions-bar select.form-input {
                width: 100%;
            }

            .dataTables_wrapper .dataTables_info {
                text-align: center;
                font-size: 0.8rem;
                padding-top: 1rem;
            }

            .dataTables_wrapper .dataTables_paginate {
                justify-content: center;
                flex-wrap: wrap;
                padding-top: 0.75rem;
            }

            .dataTables_wrapper .dataTables_paginate .paginate_button {
                min-width: 32px;
                height: 32px;
                font-size: 0.8rem;
            }
        }

        /* Custom DataTables Styling overrides to match Wise theme */
        .dataTables_wrapper {
            font-family: var(--font-sans);
            width: 100% !important;
            overflow: visible;
        }

        .dataTables_scrollHead {
            overflow: visible !important;
        }

        .dataTables_scrollBody {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .dataTables_wrapper .dataTables_info {
            color: var(--text-muted) !important;
            font-size: 0.85rem;
            padding-top: 1.25rem;
            float: none;
        }

        .dataTables_wrapper .dataTables_paginate {
            padding-top: 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
            float: none;
        }

        @media (min-width: 576px) {
            .dataTables_wrapper {
                display: block;
            }
            .dataTables_wrapper .dataTables_info {
                float: left;
            }
            .dataTables_wrapper .dataTables_paginate {
                float: right;
            }
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            padding: 0 0.5rem;
            border-radius: 10px;
            border: 1px solid var(--border-color) !important;
            background: var(--bg-card) !important;
            color: var(--text-main) !important;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition-smooth);
            margin: 0 2px;
            box-shadow: none;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: var(--tr-hover-bg) !important;
            color: var(--text-main) !important;
            border-color: var(--border-hover) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: var(--primary) !important;
            border-color: var(--primary) !important;
            color: var(--on-primary) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover,
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:active {
            opacity: 0.4;
            cursor: not-allowed;
            background: transparent !important;
            border-color: var(--border-color) !important;
            color: var(--text-dark) !important;
        }

        .dataTables_length, .dataTables_filter {
            display: none !important;
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
            
            <header class="content-header accounts-content-header">
                <h1 class="content-title">Account Management</h1>
                <p class="content-desc">Review registered user applications and toggle their activation status.</p>
            </header>


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
            <div class="workspace-card accounts-workspace-card">
                
                <!-- Search and Filter Bar -->
                <div class="table-actions-bar" style="display: flex; align-items: center; justify-content: space-between; gap: 1rem; margin-bottom: 1.5rem; flex-wrap: wrap;">
                    <!-- Search Input -->
                    <div style="position: relative; flex-grow: 1; max-width: 400px; min-width: 250px;">
                        <input type="text" id="search-input" placeholder="Search users by name, email, or ID..." class="form-input" style="padding-left: 2.75rem; margin-bottom: 0; width: 100%;">
                        <span style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: var(--text-dark); pointer-events: none; display: flex; align-items: center;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                        </span>
                    </div>

                    <!-- Filter Options -->
                    <div style="display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
                        <!-- Role Filter -->
                        <div style="position: relative; min-width: 140px;">
                            <select id="role-filter" class="form-input" style="margin-bottom: 0; padding-left: 1rem; padding-right: 2rem; appearance: none; -webkit-appearance: none; background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2216%22 height=%2216%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22><polyline points=%226 9 12 15 18 9%22></polyline></svg>'); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 16px;">
                                <option value="all">All Roles</option>
                                <option value="editor">Editor</option>
                                <option value="user">User</option>
                            </select>
                        </div>

                        <!-- Status Filter -->
                        <div style="position: relative; min-width: 140px;">
                            <select id="status-filter" class="form-input" style="margin-bottom: 0; padding-left: 1rem; padding-right: 2rem; appearance: none; -webkit-appearance: none; background-image: url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2216%22 height=%2216%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22><polyline points=%226 9 12 15 18 9%22></polyline></svg>'); background-repeat: no-repeat; background-position: right 0.75rem center; background-size: 16px;">
                                <option value="all">All Statuses</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                        <!-- Reset Filters -->
                        <button type="button" id="btn-reset-filters" class="btn-confirm-cancel" style="padding: 0.8rem 1.25rem; font-size: 0.9rem; border-radius: 24px; margin: 0; display: none;">
                            Reset
                        </button>
                    </div>
                </div>

                <div class="table-wrapper">
                    <table class="accounts-table" id="accounts-table">
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
                                    <td data-label="User">
                                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                                            <div class="user-avatar" style="width: 2.25rem; height: 2.25rem; font-size: 0.85rem; flex-shrink: 0; margin-bottom: 0;">
                                                @if($user->profile_photo)
                                                    <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Profile Photo">
                                                @else
                                                    <span>{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                                                @endif
                                            </div>
                                            <div style="display: flex; flex-direction: column;">
                                                <span class="user-name-text" style="font-weight: 600;">{{ $user->name }}</span>
                                                <span style="font-size: 0.75rem; color: var(--text-dark);">{{ $user->member_id ?? 'No Member ID' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="Email Address" style="color: var(--text-muted);">{{ $user->email }}</td>
                                    <td data-label="Selected Role">
                                        <span class="badge-role {{ strtolower($user->role?->slug ?? 'user') }}">
                                            {{ $user->role?->name ?? 'None' }}
                                        </span>
                                    </td>
                                    <td data-label="Status">
                                        <div id="status-container-{{ $user->id }}" class="badge-status {{ $user->is_active ? 'active' : 'inactive' }}">
                                            <div class="badge-status-dot"></div>
                                            <span id="status-label-{{ $user->id }}">{{ $user->is_active ? 'Active' : 'Inactive' }}</span>
                                        </div>
                                    </td>
                                    <td data-label="Action" style="text-align: right;">
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

    <!-- jQuery and DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <!-- AJAX Account Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alertDiv = document.getElementById('ajax-alert');

            // Initialize DataTable
            const table = $('#accounts-table').DataTable({
                pageLength: 5,
                searching: true,
                ordering: true,
                info: true,
                scrollX: false,
                autoWidth: false,
                dom: 'rtip', // Hide default search & length controls
                language: {
                    paginate: {
                        next: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>',
                        previous: '<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>'
                    }
                },
                columnDefs: [
                    { orderable: false, targets: [4] } // Action column is not sortable
                ]
            });
            
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
                const userName = row.querySelector('.user-name-text').textContent.trim();

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

            // Intercept form submissions via event delegation to show modal first
            document.addEventListener('submit', function(e) {
                const form = e.target.closest('.ajax-toggle-form');
                if (form) {
                    e.preventDefault();
                    showConfirmModal(form);
                }
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

                        // Invalidate elements in DataTables cache so searching/sorting uses updated values
                        const statusCell = statusContainer.closest('td');
                        const actionCell = button.closest('td');
                        if (statusCell) table.cell(statusCell).invalidate();
                        if (actionCell) table.cell(actionCell).invalidate();
                        table.draw(false);

                        // Show success banner
                        alertDiv.className = 'toast-alert success';
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
                            alertDiv.className = 'toast-alert error';
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
                        alertDiv.className = 'toast-alert error';
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

            // ── Client-side Table Search & Filter ──
            const searchInput = document.getElementById('search-input');
            const roleFilter = document.getElementById('role-filter');
            const statusFilter = document.getElementById('status-filter');
            const btnReset = document.getElementById('btn-reset-filters');

            function filterTable() {
                const query = searchInput.value.trim();
                const selectedRole = roleFilter.value;
                const selectedStatus = statusFilter.value;

                let hasActiveFilters = query !== '' || selectedRole !== 'all' || selectedStatus !== 'all';
                btnReset.style.display = hasActiveFilters ? 'inline-block' : 'none';

                // Search query globally
                table.search(query);

                // Role Filter (Column 2)
                if (selectedRole === 'all') {
                    table.column(2).search('');
                } else {
                    table.column(2).search(selectedRole);
                }

                // Status Filter (Column 3)
                if (selectedStatus === 'all') {
                    table.column(3).search('');
                } else {
                    table.column(3).search(selectedStatus);
                }

                table.draw();
            }

            if (searchInput && roleFilter && statusFilter) {
                searchInput.addEventListener('input', filterTable);
                roleFilter.addEventListener('change', filterTable);
                statusFilter.addEventListener('change', filterTable);

                btnReset.addEventListener('click', function() {
                    searchInput.value = '';
                    roleFilter.value = 'all';
                    statusFilter.value = 'all';
                    filterTable();
                });
            }
        });
    </script>
    <!-- AJAX Success Alert -->
    <div id="ajax-alert" class="toast-alert"></div>
</body>
</html>
