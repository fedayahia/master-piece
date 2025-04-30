@extends('admin.layouts.app')

@section('title', 'Coupon Details')

@section('content')
<style>
    .container {
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        margin-top: 20px;
        max-width: 100%;
    }
    
    h1 {
        color: var(--primary);
        margin-bottom: 20px;
        font-weight: 600;
        border-bottom: 2px solid var(--secondary);
        padding-bottom: 10px;
        font-size: 1.5rem;
    }
    
    .card {
        border: none;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    }
    
    .card-body {
        padding: 20px;
    }
    
    .detail-item {
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        display: flex;
        flex-wrap: wrap;
    }
    
    .detail-label {
        font-weight: 600;
        color: var(--accent);
        min-width: 150px;
        margin-bottom: 5px;
    }
    
    .detail-value {
        color: #212529;
        flex: 1;
    }
    
    .status-badge {
        display: inline-block;
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 600;
        border-radius: 0.25rem;
        text-transform: capitalize;
    }
    
    .status-active {
        background-color: var(--primary);
        color: white;
    }
    
    .status-inactive {
        background-color: var(--secondary);
        color: var(--primary);
    }
    
    .type-badge {
        display: inline-block;
        padding: 0.35em 0.65em;
        font-size: 0.75em;
        font-weight: 600;
        border-radius: 0.25rem;
    }
    
    .type-percentage {
        background-color: var(--dark);
        color: white;
    }
    
    .type-fixed {
        background-color: var(--accent);
        color: white;
    }
    
    .btn {
        padding: 10px 20px;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        white-space: nowrap;
    }
    
    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }
    
    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
        transform: translateY(-2px);
    }
    
    .action-buttons {
        display: flex;
        gap: 15px;
        margin-top: 25px;
        flex-wrap: wrap;
    }

    /* Responsive adjustments */
    @media (max-width: 1199.98px) {
        .container {
            padding: 20px;
        }
    }
    
    @media (max-width: 991.98px) {
        h1 {
            font-size: 1.4rem;
        }
        
        .detail-label {
            min-width: 120px;
        }
    }
    
    @media (max-width: 767.98px) {
        .container {
            padding: 15px;
        }
        
        h1 {
            font-size: 1.3rem;
            margin-bottom: 15px;
        }
        
        .card-body {
            padding: 15px;
        }
        
        .detail-item {
            flex-direction: column;
        }
        
        .detail-label {
            min-width: 100%;
            margin-bottom: 5px;
        }
        
        .btn {
            padding: 8px 15px;
            width: 100%;
            justify-content: center;
        }
    }
    
    @media (max-width: 575.98px) {
        .container {
            padding: 15px;
        }
        
        h1 {
            font-size: 1.25rem;
            padding-bottom: 8px;
        }
        
        .detail-item {
            padding: 10px 0;
            font-size: 0.95rem;
        }
        
        .btn {
            padding: 8px 12px;
            font-size: 0.9rem;
        }
        
        .btn i {
            margin-right: 5px !important;
        }
    }
</style>

<div class="container">
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
        <h1>Coupon Details</h1>
        <div class="mt-2 mt-sm-0">
            <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="btn btn-primary">
                <i class="fas fa-edit me-1"></i> <span class="d-none d-sm-inline">Edit Coupon</span>
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="detail-item">
                <span class="detail-label">Code:</span>
                <span class="detail-value"><strong>{{ $coupon->code }}</strong></span>
            </div>
            
            <div class="detail-item">
                <span class="detail-label">Discount Amount:</span>
                <span class="detail-value">
                    {{ $coupon->discount_amount }}
                    @if($coupon->discount_type == 'percentage')
                        %
                    @else
                        {{ config('settings.currency_symbol') }}
                    @endif
                </span>
            </div>
            
            <div class="detail-item">
                <span class="detail-label">Discount Type:</span>
                <span class="detail-value">
                    <span class="type-badge type-{{ $coupon->discount_type }}">
                        {{ ucfirst($coupon->discount_type) }}
                    </span>
                </span>
            </div>
            
            <div class="detail-item">
                <span class="detail-label">Status:</span>
                <span class="detail-value">
                    <span class="status-badge status-{{ $coupon->status }}">
                        {{ ucfirst($coupon->status) }}
                    </span>
                </span>
            </div>
            
            <div class="detail-item">
                <span class="detail-label">Course:</span>
                <span class="detail-value">{{ $coupon->course->title ?? 'All Courses' }}</span>
            </div>
            
            <div class="detail-item">
                <span class="detail-label">Created At:</span>
                <span class="detail-value">{{ $coupon->created_at->format('M d, Y h:i A') }}</span>
            </div>
            
            <div class="detail-item" style="border-bottom: none;">
                <span class="detail-label">Expires At:</span>
                <span class="detail-value">
                    @if($coupon->expires_at)
                        {{ $coupon->expires_at->format('M d, Y h:i A') }}
                    @else
                        Never expires
                    @endif
                </span>
            </div>
        </div>
    </div>

    <div class="action-buttons">
        <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Coupons
        </a>
        
        <form action="{{ route('admin.coupons.destroy', $coupon->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this coupon?')">
                <i class="fas fa-trash me-1"></i> Delete Coupon
            </button>
        </form>
    </div>
</div>
@endsection