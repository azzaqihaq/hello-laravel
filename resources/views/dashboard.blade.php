<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Coleo.Inc</title>

    <!-- ApexCharts CDN -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>

    <!-- Ambient glowing backgrounds -->
    <div class="ambient-bg">
        <div class="ambient-glow-1"></div>
        <div class="ambient-glow-2"></div>
    </div>

    <div class="dashboard-container">
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
                <li class="sidebar-item active">
                    <a href="#" class="sidebar-link" id="nav-item-overview">
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
                <li class="sidebar-item">
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
                <div class="user-profile">
                    <div class="user-avatar">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </div>
                    <div class="user-info">
                        <span class="user-name">{{ Auth::user()->name }}</span>
                        <span class="user-role">{{ Auth::user()->role?->name ?? 'Guest' }}</span>
                    </div>
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

        <!-- Main Dashboard Workspace -->
        <main class="main-content">
            
            <header class="content-header">
                <h1 class="content-title">Dashboard</h1>
                <p class="content-desc"><span id="client-greeting">Welcome</span>, {{ explode(' ', Auth::user()->first_name)[0] }}. Here is your overview.</p>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const hour = new Date().getHours();
                        let greeting = 'Welcome';
                        if (hour < 12) {
                            greeting = 'Good morning';
                        } else if (hour < 17) {
                            greeting = 'Good afternoon';
                        } else {
                            greeting = 'Good evening';
                        }
                        document.getElementById('client-greeting').textContent = greeting;
                    });
                </script>
            </header>

            <!-- Metrics Cards Grid -->
            <div class="metrics-grid">
                
                <!-- Metric Card 1: Users -->
                <div class="metric-card">
                    <div class="metric-info">
                        <span class="metric-label">Total Users</span>
                        <span class="metric-value">1,248</span>
                        <span class="metric-trend trend-up">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="3">
                                <polyline points="18 15 12 9 6 15"></polyline>
                            </svg>
                            +12.4% this week
                        </span>
                    </div>
                    <div class="metric-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                    </div>
                </div>

                <!-- Metric Card 2: Active Projects -->
                <div class="metric-card">
                    <div class="metric-info">
                        <span class="metric-label">Active Projects</span>
                        <span class="metric-value">38</span>
                        <span class="metric-trend trend-up">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="3">
                                <polyline points="18 15 12 9 6 15"></polyline>
                            </svg>
                            +5.2% this week
                        </span>
                    </div>
                    <div class="metric-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Metric Card 3: System Health -->
                <div class="metric-card">
                    <div class="metric-info">
                        <span class="metric-label">System Health</span>
                        <span class="metric-value">99.98%</span>
                        <span class="metric-trend trend-up">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="3">
                                <polyline points="18 15 12 9 6 15"></polyline>
                            </svg>
                            Stable
                        </span>
                    </div>
                    <div class="metric-icon">
                        <svg viewBox="0 0 24 24">
                            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                        </svg>
                    </div>
                </div>

            </div>

            <!-- Two Column Dashboard Grid -->
            <div class="dashboard-grid">
                
                <!-- Main Analytics Chart Card -->
                <div class="dashboard-card">
                    <div class="card-header-main">
                        <div>
                            <h3 class="card-title-main">Analytics Overview</h3>
                            <p class="card-subtitle-main">Platform usage and traffic growth trends</p>
                        </div>
                    </div>
                    <div id="analytics-chart" style="min-height: 350px; width: 100%;"></div>
                </div>

                <!-- Details Activity Tracker Card -->
                <div class="dashboard-card">
                    <div class="card-header-main">
                        <div>
                            <h3 class="card-title-main">Recent Activity</h3>
                            <p class="card-subtitle-main">Latest operations and system status changes</p>
                        </div>
                    </div>
                    <div class="details-table-wrapper">
                        <table class="details-table">
                            <thead>
                                <tr>
                                    <th>Activity</th>
                                    <th>User</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Deploy production v1.2.4</td>
                                    <td>Azza Qihaq</td>
                                    <td><span class="badge badge-success">Success</span></td>
                                </tr>
                                <tr>
                                    <td>Database migration run</td>
                                    <td>System Cron</td>
                                    <td><span class="badge badge-success">Success</span></td>
                                </tr>
                                <tr>
                                    <td>User role update (Editor)</td>
                                    <td>Jane Doe</td>
                                    <td><span class="badge badge-info">Info</span></td>
                                </tr>
                                <tr>
                                    <td>API rate limit warning</td>
                                    <td>External Client</td>
                                    <td><span class="badge badge-warning">Warning</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <!-- ApexCharts Initialization Script -->
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const options = {
                        chart: {
                            type: 'area',
                            height: 350,
                            background: 'transparent',
                            foreColor: 'hsl(220, 10%, 65%)',
                            toolbar: {
                                show: false
                            },
                            sparkline: {
                                enabled: false
                            }
                        },
                        stroke: {
                            curve: 'smooth',
                            width: 3
                        },
                        fill: {
                            type: 'gradient',
                            gradient: {
                                shadeIntensity: 1,
                                opacityFrom: 0.45,
                                opacityTo: 0.05,
                                stops: [0, 90, 100]
                            }
                        },
                        series: [{
                            name: 'Active Sessions',
                            data: [310, 400, 280, 510, 420, 1090, 1000]
                        }, {
                            name: 'Requests (x10)',
                            data: [110, 320, 450, 320, 340, 520, 410]
                        }],
                        xaxis: {
                            categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: false
                            }
                        },
                        yaxis: {
                            labels: {
                                formatter: function(val) {
                                    return val.toLocaleString();
                                }
                            }
                        },
                        grid: {
                            borderColor: 'hsla(224, 20%, 20%, 0.3)',
                            strokeDashArray: 4,
                            xaxis: {
                                lines: {
                                    show: true
                                }
                            }
                        },
                        colors: ['#a855f7', '#06b6d4'], // primary (purple) and accent (cyan)
                        legend: {
                            position: 'top',
                            horizontalAlign: 'right',
                            labels: {
                                colors: 'hsl(220, 15%, 90%)'
                            },
                            itemMargin: {
                                horizontal: 10,
                                vertical: 0
                            }
                        },
                        theme: {
                            mode: 'dark'
                        },
                        tooltip: {
                            theme: 'dark',
                            y: {
                                formatter: function(val) {
                                    return val;
                                }
                            }
                        }
                    };

                    const chart = new ApexCharts(document.querySelector("#analytics-chart"), options);
                    chart.render();
                });
            </script>

        </main>
    </div>

</body>
</html>
