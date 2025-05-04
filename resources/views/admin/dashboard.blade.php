@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

<style>
    :root {
        --primary: #393D72;
        --secondary: rgba(254, 56, 115, 0.3);
        --accent: #1A1C2E;
        --dark: #ff2f6e;
        --light: #F8F9FA;
    }

    .dashboard-container {
        background: linear-gradient(135deg, #f5f7fa 0%, #f8f9fa 100%);
        padding: 25px;
        min-height: 100vh;
    }
    
    /* Stat Cards - Glassmorphism Style */
    .stat-card {
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 25px;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        text-align: center;
        border-left: 5px solid var(--primary);
        position: relative;
        overflow: hidden;
        z-index: 1;
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0) 70%);
        z-index: -1;
        opacity: 0;
        transition: opacity 0.4s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
    }
    
    .stat-card:hover::before {
        opacity: 1;
    }
    
    .stat-card h3 {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 8px;
        color: var(--accent);
        letter-spacing: -0.5px;
    }
    
    .stat-card p {
        color: #6c757d;
        margin-bottom: 0;
        font-size: 1.05rem;
        font-weight: 500;
    }
    
    .stat-card .icon {
        font-size: 2.8rem;
        margin-bottom: 20px;
        background: linear-gradient(135deg, var(--primary) 0%, var(--dark) 100%);
        -webkit-background-clip: text;
        background-clip: text;
        -webkit-text-fill-color: transparent;
        display: inline-block;
    }
    
    /* Chart Cards - Neumorphism Style */
    .chart-card {
        border-radius: 20px;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
        margin-bottom: 25px;
        border: none;
        transition: all 0.4s ease;
    }
    
    .chart-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 45px rgba(0, 0, 0, 0.12);
    }
    
    .chart-card .card-header {
        background: transparent;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 20px 25px;
        border-radius: 20px 20px 0 0 !important;
    }
    
    .chart-card .card-header h5 {
        font-weight: 700;
        color: var(--accent);
        margin: 0;
        font-size: 1.25rem;
        display: flex;
        align-items: center;
    }
    
    .chart-card .card-header h5 i {
        margin-right: 10px;
        font-size: 1.5rem;
    }
    
    .chart-container {
        position: relative;
        height: 320px;
        padding: 20px;
    }
    
    /* Growth Badges */
    .growth-badge {
        display: inline-flex;
        align-items: center;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 700;
        margin-left: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    
    .growth-up {
        background: linear-gradient(135deg, rgba(46, 204, 113, 0.15) 0%, rgba(46, 204, 113, 0.25) 100%);
        color: #27ae60;
    }
    
    .growth-down {
        background: linear-gradient(135deg, rgba(231, 76, 60, 0.15) 0%, rgba(231, 76, 60, 0.25) 100%);
        color: #e74c3c;
    }
    
    /* Card Specific Styles */
    .payment-card {
        border-left-color: var(--primary);
    }
    
    .user-card {
        border-left-color: #27ae60;
    }
    
    .course-card {
        border-left-color: #3498db;
    }
    
    /* Animations */
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
        100% { transform: translateY(0px); }
    }
    
    .stat-card:hover .icon {
        animation: float 2s ease-in-out infinite;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .stat-card h3 {
            font-size: 2rem;
        }
        
        .chart-container {
            height: 250px;
        }
    }
</style>

<div class="dashboard-container">
    <div class="row">
        <!-- Total Payments Card -->
        <div class="col-md-3 col-sm-6">
            <div class="stat-card payment-card">
                <div class="icon">
                    <i class="fas fa-credit-card"></i>
                </div>
                <h3>JOD{{ number_format($totalPayments) }}</h3>
                <p>Total Payments
                    <span class="growth-badge growth-up">
                        <i class="fas fa-arrow-up me-1"></i> {{ $paymentGrowth }}%
                    </span>
                </p>
            </div>
        </div>
        
        <!-- Total Users Card -->
        <div class="col-md-3 col-sm-6">
            <div class="stat-card user-card">
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>{{ number_format($totalUsers) }}</h3>
                <p>Registered Users
                    {{-- <span class="growth-badge growth-up">
                        <i class="fas fa-arrow-up me-1"></i> {{ $userGrowth }}%
                    </span> --}}
                </p>
            </div>
        </div>
        
        <!-- Courses Count Card -->
        <div class="col-md-3 col-sm-6">
            <div class="stat-card course-card">
                <div class="icon">
                    <i class="fas fa-book-open"></i>
                </div>
                <h3>{{ number_format($coursesCount) }}</h3>
                <p>Available Courses</p>
            </div>
        </div>

        <!-- Private Sessions Card -->
        <div class="col-md-3 col-sm-6">
            <div class="stat-card private-session-card">
                <div class="icon">
                    <i class="fas fa-user-secret"></i>
                </div>
                <h3>{{ number_format($privateSessionsCount) }}</h3>
                <p>Private Sessions</p>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <!-- Monthly Payments Growth Chart -->
        <div class="col-md-6">
            <div class="chart-card">
                <div class="card-header">
                    <h5><i class="fas fa-chart-line" style="background: linear-gradient(135deg, var(--primary) 0%, var(--dark) 100%); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;"></i> Monthly Revenue</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="paymentsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Monthly Users Growth Chart -->
        <div class="col-md-6">
            <div class="chart-card">
                <div class="card-header">
                    <h5><i class="fas fa-user-plus" style="background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;"></i> User Acquisition</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="usersChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Payments Chart with gradient
    const paymentsCtx = document.getElementById('paymentsChart').getContext('2d');
    const paymentGradient = paymentsCtx.createLinearGradient(0, 0, 0, 300);
    paymentGradient.addColorStop(0, 'rgba(57, 61, 114, 0.3)');
    paymentGradient.addColorStop(1, 'rgba(254, 56, 115, 0.1)');
    
    new Chart(paymentsCtx, {
        type: 'line',
        data: {
            labels: @json($paymentMonths),
            datasets: [{
                label: 'Revenue',
                data: @json($paymentAmounts),
                backgroundColor: paymentGradient,
                borderColor: 'var(--primary)',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: 'var(--dark)',
                pointBorderColor: '#fff',
                pointHoverRadius: 8,
                pointRadius: 5,
                pointHoverBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'var(--accent)',
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 12
                    },
                    padding: 12,
                    cornerRadius: 12,
                    usePointStyle: true
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false,
                        color: 'rgba(0, 0, 0, 0.03)'
                    },
                    ticks: {
                        color: '#6c757d',
                        padding: 10
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#6c757d',
                        padding: 10
                    }
                }
            }
        }
    });

    // Users Chart with gradient
    const usersCtx = document.getElementById('usersChart').getContext('2d');
    const userGradient = usersCtx.createLinearGradient(0, 0, 0, 300);
    userGradient.addColorStop(0, 'rgba(46, 204, 113, 0.3)');
    userGradient.addColorStop(1, 'rgba(46, 204, 113, 0.1)');
    
    new Chart(usersCtx, {
        type: 'bar',
        data: {
            labels: @json($userMonths),
            datasets: [{
                label: 'New Users',
                data: @json($userCounts),
                backgroundColor: userGradient,
                borderColor: '#27ae60',
                borderWidth: 0,
                borderRadius: 8,
                hoverBackgroundColor: '#27ae60',
                barThickness: 'flex',
                maxBarThickness: 30
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'var(--accent)',
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 12
                    },
                    padding: 12,
                    cornerRadius: 12
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false,
                        color: 'rgba(0, 0, 0, 0.03)'
                    },
                    ticks: {
                        color: '#6c757d',
                        padding: 10
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#6c757d',
                        padding: 10
                    }
                }
            }
        }
    });
});
</script>

@endsection