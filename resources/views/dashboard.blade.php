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
        @include('partials.sidebar')

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
