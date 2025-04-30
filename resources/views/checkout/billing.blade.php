@extends('layouts.master')

@section('content')
<?php use Carbon\Carbon; ?>

<style>
    :root {
        --primary: #393D72;
        --secondary: rgba(255, 157, 186, 0.3);
        --accent: #1A1C2E;
        --dark: #ff2f6e;
        --light: #F8F9FA;
    }

    .checkout-container {
        background-color: var(--light);
        padding: 2rem 0;
    }
    
    .card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        margin-bottom: 2rem;
        overflow: hidden;
    }
    
    .card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .card-header.bg-primary {
        background-color: var(--secondary) !important;
        color: var(--light) !important;
    }
    
    .card-header.bg-secondary {
        background-color: var(--secondary) !important;
        color: var(--accent);
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    .form-control {
        border: 1px solid #ced4da;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        height: 50px;
        transition: all 0.3s;
    }
    
    .form-control:focus {
        border-color: var(--dark);
        box-shadow: 0 0 0 0.2rem rgba(255, 47, 110, 0.25);
    }
    
    .table {
        width: 100%;
        margin-bottom: 1.5rem;
        border-collapse: collapse;
    }
    
    .table th, .table td {
        padding: 0.75rem;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
    }
    
    .table thead th {
        vertical-align: bottom;
        border-bottom: 2px solid #dee2e6;
        background-color: var(--light);
        color: var(--accent);
    }
    
    .table tbody tr:last-child td {
        border-bottom: 2px solid #dee2e6;
    }
    
    .btn-primar {
        background-color: var(--primary);
        border-color: var(--primary);
        padding: 0.75rem 1.5rem;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s;
        color: #ffffff;
    }
    
    .btn-primar:hover {
        border-color: var(--accent);
        transform: translateY(-2px);
        color: #ffffff;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    
    .coupon-section {
        background-color: var(--light);
        border-radius: 8px;
        padding: 1.5rem;
        margin-top: 1.5rem;
        border: 1px dashed var(--dark);
    }
    
    .coupon-input-group {
        display: flex;
    }
    
    .coupon-input-group .form-control {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        height: 50px;
    }
    
    .coupon-input-group .btn {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        height: 50px;
        white-space: nowrap;
        background-color: var(--dark);
        border-color: var(--dark);
    }
    
    .coupon-message {
        margin-top: 0.5rem;
        font-size: 0.9rem;
    }
    
    .coupon-message.success {
        color: #28a745;
    }
    
    .coupon-message.error {
        color: #dc3545;
    }
    
    .wow {
        visibility: hidden;
    }
    
    @media (max-width: 767.98px) {
        .card {
            margin-bottom: 1.5rem;
        }
        
        .coupon-input-group {
            flex-direction: column;
        }
        
        .coupon-input-group .form-control {
            border-radius: 8px;
            margin-bottom: 0.5rem;
        }
        
        .coupon-input-group .btn {
            border-radius: 8px;
            width: 100%;
        }
    }
    
    /* Additional styles for debugging */
    .debug-session {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 9999;
    }
</style>

<div class="checkout-container py-5">
    <div class="container">
        @if(!isset($item) || !isset($type))
            <div class="alert alert-danger">
                Missing booking information. Please start the booking process again.
            </div>
        @else
        <div class="row">
            <!-- Billing Information -->
            <div class="col-lg-7">
                <div class="card wow fadeIn" data-wow-delay="0.1s">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Billing Information</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('checkout.processBilling') }}" method="POST" id="billing-form">
                            @csrf
                            <input type="hidden" name="booking_type" value="{{ $type }}">
                            <input type="hidden" name="item_id" value="{{ $item->id }}">
                            
                            @if($type === 'private')
                                <input type="hidden" name="session_time" value="{{ $session_time }}">
                                @if(isset($special_requests))
                                    <input type="hidden" name="special_requests" value="{{ $special_requests }}">
                                @endif
                            @endif
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Full Name</label>
                                        <input type="text" name="billing_name" class="form-control" 
                                               value="{{ auth()->user()->name }}" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="billing_email" class="form-control"
                                               value="{{ auth()->user()->email }}" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Phone Number</label>
                                        <input type="tel" name="billing_phone" class="form-control"
                                               value="{{ auth()->user()->phone_number ?? '' }}" required
                                               pattern="[0-9]{10,15}">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primar mt-3 w-100">
                                Continue to Payment
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Booking Summary -->
            <div class="col-lg-5">
                <div class="card wow fadeIn" data-wow-delay="0.2s">
                    <div class="card-header bg-secondary">
                        <h4 class="mb-0">Your Booking Summary</h4>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>{{ $type === 'course' ? 'Course' : 'Private Session' }}</th>
                                    <th>Details</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $item->title }}</td>
                                    <td>
                                        @if($type === 'course')
                                            <div class="mb-1">Duration: {{ $item->duration }} hours</div>
                                            <div class="mb-1">Instructor: {{ $item->instructor->name ?? 'Multiple Instructors' }}</div>
                                        @else
                                            <div class="mb-1">With: {{ $item->instructor->name }}</div>
                                            <div class="booking-summary">
                                                @if(session('current_booking.available_time_id'))
                                                    @php
                                                        $timeSlot = \App\Models\AvailableTime::find(session('current_booking.available_time_id'));
                                                    @endphp
                                                    
                                                    @if($timeSlot)
                                                        <p>Selected Time: {{ Carbon::parse($timeSlot->available_date)->format('h:i A - Y/m/d') }}</p>
                                                    @endif
                                                @endif
                                            </div>
                                            <div class="mb-1">Duration: {{ $item->duration }} minutes</div>
                                            @if(isset($special_requests))
                                                <div class="mt-2">
                                                    <strong>Special Requests:</strong>
                                                    <p>{{ $special_requests }}</p>
                                                </div>
                                            @endif
                                        @endif
                                    </td>
                                    <td>${{ number_format($item->price, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2"><strong>Subtotal:</strong></td>
                                    <td><strong>${{ number_format($item->price, 2) }}</strong></td>
                                </tr>
                                <tr class="discount-row" style="display: none;">
                                    <td colspan="2"><strong>Discount:</strong></td>
                                    <td class="discount-amount">- $0.00</td>
                                </tr>
                                <tr>
                                    <td colspan="2"><strong>Total:</strong></td>
                                    <td class="total-amount"><strong>${{ number_format($item->price, 2) }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <!-- Coupon Section -->
                        <div class="coupon-section">
                            <label for="coupon_code" class="form-label">Have a Coupon Code?</label>
                            <div class="coupon-input-group">
                                <input type="text" class="form-control" id="coupon_code" placeholder="Enter coupon code">
                                <button type="button" class="btn btn-primary" id="apply_coupon">Apply</button>
                            </div>
                            <div id="coupon_message" class="coupon-message"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        
        {{-- @if(config('app.debug'))
        <div class="debug-session">
            <button class="btn btn-sm btn-danger" onclick="alert(JSON.stringify(@json(session()->all())))">
                Debug Session
            </button>
        </div>
        @endif --}}
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Apply Coupon Functionality
    const applyCoupon = document.getElementById('apply_coupon');
    const couponCode = document.getElementById('coupon_code');
    const couponMessage = document.getElementById('coupon_message');

    if (applyCoupon && couponCode && couponMessage) {
        applyCoupon.addEventListener('click', function() {
            if (!couponCode.value) {
                couponMessage.textContent = 'Please enter a coupon code';
                couponMessage.className = 'coupon-message error';
                return;
            }

            // Show loading state
            applyCoupon.disabled = true;
            applyCoupon.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Applying...';

            // Make the fetch request
            fetch('{{ route("checkout.apply-coupon") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    coupon_code: couponCode.value,
                    item_id: {{ $item->id }},
                    booking_type: '{{ $type }}'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update UI with discount
                    document.querySelector('.discount-row').style.display = '';
                    document.querySelector('.discount-amount').textContent = '- $' + data.discount.toFixed(2);
                    document.querySelector('.total-amount').innerHTML = '<strong>$' + data.total.toFixed(2) + '</strong>';

                    // Add hidden input for coupon code
                    let existingInput = document.querySelector('input[name="applied_coupon"]');
                    if (!existingInput) {
                        let couponInput = document.createElement('input');
                        couponInput.type = 'hidden';
                        couponInput.name = 'applied_coupon';
                        couponInput.value = couponCode.value;
                        document.getElementById('billing-form').appendChild(couponInput);
                    }

                    couponMessage.textContent = data.message;
                    couponMessage.className = 'coupon-message success';
                } else {
                    document.querySelector('.discount-row').style.display = 'none';
                    document.querySelector('.discount-amount').textContent = '- $0.00';
                    document.querySelector('.total-amount').innerHTML = '<strong>${{ number_format($item->price, 2) }}</strong>';
                    couponMessage.textContent = data.message || 'Coupon is not valid';
                    couponMessage.className = 'coupon-message error';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                couponMessage.textContent = 'An error occurred. Please try again.';
                couponMessage.className = 'coupon-message error';
                document.querySelector('.discount-row').style.display = 'none';
                document.querySelector('.total-amount').innerHTML = '<strong>${{ number_format($item->price, 2) }}</strong>';
            })
            .finally(() => {
                applyCoupon.disabled = false;
                applyCoupon.innerHTML = 'Apply';
            });
        });
    }
    
    // Display appropriate fields based on booking type
    @if($type === 'course')
        document.querySelectorAll('.private-only').forEach(el => {
            el.style.display = 'none';
        });
    @else
        document.querySelectorAll('.course-only').forEach(el => {
            el.style.display = 'none';
        });
    @endif
});

document.getElementById('billing-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // جمع بيانات الفاتورة
    const formData = new FormData(this);
    
    // إرسال البيانات عبر AJAX
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // الانتقال إلى صفحة الدفع
            window.location.href = "{{ route('checkout.payment') }}";
        } else {
            alert(data.message || 'Error processing billing information');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    });
});
</Script>
@endsection