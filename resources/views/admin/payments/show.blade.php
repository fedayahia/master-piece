@extends('admin.layouts.app')

@section('title', 'Payment Details')

@section('content')
<style>
    /* Main Container */
    .container {
        background-color: white;
        padding: 1.5rem;
        border-radius: 10px;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.05);
        margin: 1.5rem auto;
        max-width: 100%;
    }

    /* Header */
    .page-header {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid var(--secondary);
    }

    @media (min-width: 768px) {
        .page-header {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
    }

    .page-header h1 {
        color: var(--primary);
        font-weight: 600;
        margin: 0;
        font-size: 1.5rem;
    }

    /* Card Styling */
    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.08);
        margin-bottom: 1.5rem;
    }

    .card-body {
        padding: 1.5rem;
    }

    /* Detail Items */
    .detail-item {
        display: flex;
        flex-direction: column;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    @media (min-width: 576px) {
        .detail-item {
            flex-direction: row;
        }
    }

    .detail-label {
        font-weight: 600;
        color: var(--primary);
        min-width: 150px;
        margin-bottom: 0.5rem;
    }

    @media (min-width: 576px) {
        .detail-label {
            margin-bottom: 0;
        }
    }

    .detail-value {
        color: #495057;
        flex: 1;
    }

    /* Status Badges */
    .badge {
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 600;
        border-radius: 0.25rem;
        text-transform: capitalize;
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
    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 0.375rem;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background-color: var(--primary);
        border-color: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background-color: #2a2d55;
        border-color: #2a2d55;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(57, 61, 114, 0.3);
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #5a6268;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
        flex-wrap: wrap;
    }

    /* Responsive Adjustments */
    @media (max-width: 767px) {
        .container {
            padding: 1rem;
        }
        
        .action-buttons .btn {
            flex: 1;
            min-width: 0;
        }
    }

    @media (max-width: 575px) {
        .page-header h1 {
            font-size: 1.25rem;
        }
        
        .btn {
            padding: 0.65rem 1rem;
            font-size: 0.875rem;
        }
    }
</style>

<div class="container">
    <div class="page-header">
        <h1>Payment Details #{{ $payment->id }}</h1>
     
    </div>

    <div class="card">
        <div class="card-body">
            <div class="detail-item">
                <span class="detail-label">User:</span>
                <span class="detail-value">{{ $payment->user->name ?? 'N/A' }}</span>
            </div>

            <div class="detail-item">
                <span class="detail-label">Item:</span>
                <span class="detail-value">
                    @if($payment->paymentable)
                        {{ $payment->paymentable instanceof \App\Models\Course ? $payment->paymentable->title : $payment->paymentable->title ?? 'N/A' }}
                        <small class="text-muted">({{ class_basename($payment->paymentable_type) }})</small>
                    @else
                        N/A
                    @endif
                </span>
            </div>

            <div class="detail-item">
                <span class="detail-label">Amount:</span>
                <span class="detail-value">${{ number_format($payment->amount, 2) }}</span>
            </div>

            <div class="detail-item">
                <span class="detail-label">Payment Method:</span>
                <span class="detail-value">{{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}</span>
            </div>

            <div class="detail-item">
                <span class="detail-label">Status:</span>
                <span class="detail-value">
                    <span class="badge badge-{{ $payment->status }}">
                        {{ ucfirst($payment->status) }}
                    </span>
                </span>
            </div>

            <div class="detail-item">
                <span class="detail-label">Transaction ID:</span>
                <span class="detail-value">{{ $payment->transaction_id }}</span>
            </div>

            <div class="detail-item">
                <span class="detail-label">Paid At:</span>
                <span class="detail-value">
                    {{ $payment->paid_at ? $payment->paid_at->format('M d, Y h:i A') : '-' }}
                </span>
            </div>

          
        </div>
    </div>

    <div class="action-buttons">
        <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Payments
        </a>

      
    </div>
</div>
@endsection
