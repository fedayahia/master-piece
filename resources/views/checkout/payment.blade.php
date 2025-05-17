@extends('layouts.master')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

@if(!session('billing_completed'))
    <div class="alert alert-danger">
        Please complete billing information first
    </div>
@endif

@if(!session('billing_completed'))
    <script>
        window.location.href = "{{ route('courses.index') }}";
    </script>
@endif
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Complete Your Payment</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Order Summary -->
                        <div class="col-md-6">
                            <h5>Order Summary</h5>
                            <ul class="list-group mb-4">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>{{ session('booking_type') === 'course' ? 'Course' : 'Private Session' }}:</span>
                                    <span>{{ session('item_title') }}</span>
                                </li>
                                
                                @if(session('booking_type') === 'course')
                                    <li class="list-group-item">
                                        <div>Duration: {{ $item->duration }} hours</div>
                                        <div>Instructor: {{ session('instructor_name') }}</div>
                                    </li>
                                @else
                                    <li class="list-group-item">
                                        <div>With: {{ session('instructor_name') }}</div>
                                        <div class="booking-summary">
                                            @if(session('booking_type') === 'private' && session('current_booking.session_date'))
                                                <p class="mb-1">
                                                    <strong>Selected Time:</strong> 
                                                    {{ \Carbon\Carbon::parse(session('current_booking.session_date'))->format('h:i A - M j, Y') }}
                                                </p>
                                            @endif
                                        </div>                                        <div>Duration: {{ $item->duration }} hours</div>
                                        @if(session('special_requests'))
                                            <div class="mt-2">
                                                <strong>Special Requests:</strong>
                                                <p>{{ session('special_requests') }}</p>
                                            </div>
                                        @endif
                                    </li>
                                @endif
                        
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Amount:</span>
                                    <span>${{ number_format(session('item_price'), 2) }}</span>
                                </li>

                                
                                @if(session()->has('coupon_applied'))
                                <li class="list-group-item d-flex justify-content-between text-success">
                                    <span>Discount ({{ session('coupon_code') }}):</span>
                                    <span>-{{ number_format(session('coupon_discount'), 2) }}$</span>
                                </li>
                            @endif
                                
                                <li class="list-group-item d-flex justify-content-between fw-bold">
                                    <span>Total:</span>
                                    <span>${{ number_format(session('item_price') - (session('coupon_discount') ?? 0), 2) }}</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Payment Options -->
                        <div class="col-md-6">
                            <h5>Payment Method</h5>
                            <div class="list-group">
                                <a href="#" class="list-group-item list-group-item-action active" id="stripe-btn">
                                    <i class="fab fa-cc-stripe me-2"></i> Pay with Credit Card
                                </a>
                            </div>

                            <!-- Stripe Form -->
                            <form id="stripe-payment-form" class="mt-3">
                                @csrf
                                <div class="mb-3">
                                    <label for="card-element" class="form-label">Credit or debit card</label>
                                    <div id="card-element" class="form-control"></div>
                                    <div id="card-errors" role="alert" class="text-danger mt-2"></div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100" id="stripe-payment-button">
                                    <span id="payment-button-text">Pay Now</span>
                                    <div id="payment-spinner" class="spinner-border spinner-border-sm d-none" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </button>
                            </form>

                            <!-- Cancel Button -->
                            <a href="{{ url('/') }}" class="btn btn-secondary w-100 mt-3" id="cancel-btn">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://js.stripe.com/v3/"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    
    // Initialize Stripe with error handling
    let stripe, elements, card;
    try {
        stripe = Stripe('{{ env("STRIPE_KEY") }}');
        elements = stripe.elements();
        card = elements.create('card');
        card.mount('#card-element');
        
        // Handle card errors
        card.addEventListener('change', function(event) {
            const displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
            } else {
                displayError.textContent = '';
            }
        });
    } catch (error) {
        console.error('Stripe initialization error:', error);
    }
    document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('apply_coupon').addEventListener('click', function() {
        const couponCode = document.getElementById('coupon_code').value;
        const courseId = {{ $item->id }};
        const btn = this;
        const messageEl = document.getElementById('coupon_message');

        if (!couponCode) {
            messageEl.textContent = 'Please enter coupon code';
            messageEl.className = 'coupon-message error';
            return;
        }

        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Applying...';
        messageEl.textContent = '';
        messageEl.className = 'coupon-message';

        fetch('{{ route("checkout.apply-coupon") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                coupon_code: couponCode,
                course_id: courseId
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                document.querySelector('.discount-row').style.display = '';
                document.querySelector('.discount-amount').textContent = `- $${data.discount_amount}`;
                document.querySelector('.total-amount').innerHTML = `$${data.total_amount}`;
                
                messageEl.textContent = 'Coupon applied successfully!';
                messageEl.className = 'coupon-message success';
                
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                throw new Error(data.message || 'Failed to apply coupon');
            }
        })
        .catch(error => {
            messageEl.textContent = error.message;
            messageEl.className = 'coupon-message error';
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = 'Apply';
        });
    });
    
    @if(session('coupon_discount'))
        document.querySelector('.discount-row').style.display = '';
        document.querySelector('.discount-amount').textContent = '- ${{ number_format(session('coupon_discount'), 2) }}';
        document.querySelector('.total-amount').innerHTML = '${{ number_format(session('course_price') - session('coupon_discount'), 2) }}';
    @endif
});

    // Stripe payment form submission
    document.getElementById('stripe-payment-form').addEventListener('submit', async function(e) {
        e.preventDefault();

        const button = document.getElementById('stripe-payment-button');
        const buttonText = document.getElementById('payment-button-text');
        const spinner = document.getElementById('payment-spinner');

        button.disabled = true;
        buttonText.classList.add('d-none');
        spinner.classList.remove('d-none');

        try {
            const {token, error} = await stripe.createToken(card);

            if (error) {
                throw new Error(error.message);
            }

            const response = await fetch("{{ route('stripe.payment') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    stripeToken: token.id,
                    amount: {{ session('course_price') - (session('coupon_discount') ?? 0) }},
                    course_id: {{ session('course_id') ?? 'null' }}
                })
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'Payment failed');
            }

            await Swal.fire({
                icon: 'success',
                title: 'Payment Completed!',
                text: data.message || 'Your payment was successful',
                confirmButtonText: 'Continue'
            });
            
            window.location.href = data.redirect_url || "{{ url('/') }}";

        } catch (err) {
            console.error('Payment error:', err);
            Swal.fire({
                icon: 'error',
                title: 'Payment Error',
                text: err.message || 'An error occurred during payment',
                footer: 'Please try again or contact support'
            });
        } finally {
            button.disabled = false;
            buttonText.classList.remove('d-none');
            spinner.classList.add('d-none');
        }
    });
</script>

<style>
    .StripeElement {
        box-sizing: border-box;
        height: 40px;
        padding: 10px 12px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        background-color: white;
    }

    .StripeElement--focus {
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    }

    .StripeElement--invalid {
        border-color: #fa755a;
    }

    .StripeElement--webkit-autofill {
        background-color: #fefde5 !important;
    }

    .swal2-popup {
        border-radius: 15px;
        padding: 2rem;
    }
    .swal2-title {
        color: #4d65f9;
    }
    .swal2-confirm {
        background-color: #4d65f9 !important;
    }
</style>
@endsection