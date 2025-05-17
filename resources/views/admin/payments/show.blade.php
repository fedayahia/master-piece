@extends('admin.layouts.app')

@section('title', 'Payment Details')

@section('content')
<style>
    :root {
        --primary: #393D72;
        --secondary: rgba(254, 56, 115, 0.3);
        --accent: #1A1C2E;
        --dark: #ff2f6e;
        --light: #F8F9FA;
    }

    /* Main Container */
    .payment-container {
        background-color: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08);
        margin: 1.5rem auto;
        max-width: 100%;
    }

    /* Header */
    .payment-header {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid rgba(57, 61, 114, 0.1);
    }

    @media (min-width: 768px) {
        .payment-header {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
    }

    .payment-title {
        color: var(--primary);
        font-weight: 700;
        margin: 0;
        font-size: 1.75rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .payment-title i {
        font-size: 1.5rem;
    }

    /* Card Styling */
    .payment-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.06);
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .payment-card-header {
        background-color: var(--primary);
        color: white;
        padding: 1.25rem 1.5rem;
        font-weight: 600;
        font-size: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .payment-card-body {
        padding: 1.75rem;
    }

    /* Detail Items Grid */
    .details-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }

    @media (min-width: 768px) {
        .details-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    .detail-section {
        margin-bottom: 1.5rem;
    }

    .section-title {
        color: var(--primary);
        font-weight: 600;
        font-size: 1.1rem;
        margin-bottom: 1.25rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid rgba(57, 61, 114, 0.1);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .detail-item {
        display: flex;
        margin-bottom: 1.25rem;
    }

    @media (max-width: 575px) {
        .detail-item {
            flex-direction: column;
        }
    }

    .detail-label {
        font-weight: 600;
        color: var(--primary);
        min-width: 180px;
        padding-right: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .detail-value {
        color: #495057;
        flex: 1;
        word-break: break-word;
    }

    /* Status Badges */
    .badge {
        padding: 0.5em 0.8em;
        font-size: 0.8em;
        font-weight: 600;
        border-radius: 6px;
        text-transform: capitalize;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    .badge-completed {
        background-color: #28a745;
        color: white;
    }

    .badge-pending {
        background-color: #ffc107;
        color: #212529;
    }

    .badge-failed {
        background-color: #dc3545;
        color: white;
    }

    /* Buttons */
    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        flex-wrap: wrap;
    }

    .btn {
        padding: 0.875rem 1.75rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        font-size: 0.95rem;
        border: none;
        cursor: pointer;
    }

    .btn-primary {
        background-color: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background-color: #2a2d55;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(57, 61, 114, 0.3);
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        transform: translateY(-2px);
    }

    /* Responsive Adjustments */
    @media (max-width: 767px) {
        .payment-container {
            padding: 1.5rem;
        }
        
        .payment-title {
            font-size: 1.5rem;
        }
        
        .payment-card-body {
            padding: 1.5rem;
        }
    }

    @media (max-width: 575px) {
        .payment-container {
            padding: 1.25rem;
        }
        
        .payment-title {
            font-size: 1.3rem;
        }
        
        .btn {
            padding: 0.75rem 1.25rem;
            font-size: 0.9rem;
        }
        
        .detail-label {
            min-width: 100%;
            margin-bottom: 0.25rem;
        }
    }
</style>

<div class="payment-container">
    <div class="payment-header">
        <h1 class="payment-title">
            <i class="fas fa-receipt"></i>
            Payment Details #{{ $payment->id }}
        </h1>
    </div>

    <div class="payment-card">
        <div class="payment-card-header">
            <i class="fas fa-info-circle"></i>
            Payment Information
        </div>
        <div class="payment-card-body">
            <div class="details-grid">
                <div class="detail-section">
                    <h3 class="section-title">
                        <i class="fas fa-user"></i>
                        User Details
                    </h3>
                    
                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-user-tag"></i>
                            User:
                        </span>
                        <span class="detail-value">{{ $payment->user_name }}</span>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-envelope"></i>
                            Email:
                        </span>
                        <span class="detail-value">{{ $payment->user_email }}</span>
                    </div>
               
                
                <div class="detail-section">
                    <h3 class="section-title">
                        <i class="fas fa-money-bill-wave"></i>
                        Transaction Details
                    </h3>
                    
                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-tag"></i>
                            Type:
                        </span>
                        <span class="detail-value">{{ $payment->payment_type }}</span>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-cube"></i>
                            Item:
                        </span>
                        <span class="detail-value">{{ $payment->item_name }}</span>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-dollar-sign"></i>
                            Amount:
                        </span>
                        <span class="detail-value">JOD{{ number_format($payment->amount, 2) }}</span>
                    </div>
                </div>
            
                    
                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-wallet"></i>
                            Method:
                        </span>
                        <span class="detail-value">{{ ucwords(str_replace('_', ' ', $payment->method)) }}</span>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-id-card"></i>
                            Transaction ID:
                        </span>
                        <span class="detail-value">{{ $payment->transaction_id }}</span>
                    </div>
                </div>
                
                <div class="detail-section">
                    <h3 class="section-title">
                        <i class="fas fa-calendar-check"></i>
                        Status & Timing
                    </h3>
                    
                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-info-circle"></i>
                            Status:
                        </span>
                        <span class="detail-value">
                            <span class="badge badge-{{ $payment->status }}">
                                <i class="fas fa-{{ $payment->status === 'completed' ? 'check-circle' : ($payment->status === 'pending' ? 'clock' : 'times-circle') }}"></i>
                                {{ ucfirst($payment->status) }}
                            </span>
                        </span>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="fas fa-calendar-alt"></i>
                            Paid At:
                        </span>
                        <span class="detail-value">
                            {{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('M d, Y h:i A') : '-' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="action-buttons">
        <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Payments
        </a>
        
        <button onclick="window.print()" class="btn btn-primary">
            <i class="fas fa-print"></i> Print Receipt
        </button>
    </div>
</div>

<script>
</script>
@endsection