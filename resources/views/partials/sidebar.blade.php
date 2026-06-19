<!-- Sidebar Navigation -->
<aside class="sidebar">
    
    <!-- Sidebar Header -->
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
            </svg>
        </div>
        <span class="sidebar-title">Coleo.Inc</span>
    </div>

    <!-- Sidebar Navigation Links -->
    <ul class="sidebar-nav">
        <li class="sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}" class="sidebar-link" id="nav-item-overview">
                <svg viewBox="0 0 24 24">
                    <rect x="3" y="3" width="7" height="9"></rect>
                    <rect x="14" y="3" width="7" height="5"></rect>
                    <rect x="14" y="12" width="7" height="9"></rect>
                    <rect x="3" y="16" width="7" height="5"></rect>
                </svg>
                <span>Overview</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="#" class="sidebar-link" id="nav-item-analytics">
                <svg viewBox="0 0 24 24">
                    <line x1="18" y1="20" x2="18" y2="10"></line>
                    <line x1="12" y1="20" x2="12" y2="4"></line>
                    <line x1="6" y1="20" x2="6" y2="14"></line>
                </svg>
                <span>Analytics</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="#" class="sidebar-link" id="nav-item-projects">
                <svg viewBox="0 0 24 24">
                    <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                </svg>
                <span>Projects</span>
            </a>
        </li>
        @if(Auth::user()->role?->slug === 'administrator')
        <li class="sidebar-item {{ request()->routeIs('admin.accounts') ? 'active' : '' }}">
            <a href="{{ route('admin.accounts') }}" class="sidebar-link" id="nav-item-accounts">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                <span>Accounts</span>
            </a>
        </li>
        @endif
        <li class="sidebar-item sidebar-item-settings">
            <a href="#" class="sidebar-link" id="nav-item-settings">
                <svg viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="3"></circle>
                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                </svg>
                <span>Settings</span>
            </a>
        </li>
    </ul>

    <!-- Sidebar Footer (Profile & Logout Form) -->
    <div class="sidebar-footer">
        <div class="user-profile-wrapper">
            <a href="{{ route('profile') }}" class="user-profile" id="user-profile-trigger" style="text-decoration: none; color: inherit;">
                <div class="user-avatar" id="sidebar-avatar">
                    @if(Auth::user()->profile_photo)
                        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile Photo">
                    @else
                        <span>{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</span>
                    @endif
                </div>
                <div class="user-info">
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <span class="user-role">{{ Auth::user()->role?->name ?? 'Guest' }}</span>
                </div>
            </a>
        </div>

        <form action="{{ route('logout') }}" method="POST" id="logout-form" style="display: none;">
            @csrf
        </form>
        <button 
            class="btn-logout" 
            id="btn-logout-trigger"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
        >
            <svg viewBox="0 0 24 24">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                <polyline points="16 17 21 12 16 7"></polyline>
                <line x1="21" y1="12" x2="9" y2="12"></line>
            </svg>
            <span>Logout</span>
        </button>
    </div>

</aside>
