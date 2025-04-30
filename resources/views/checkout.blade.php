@extends('layouts.master')

@section('title', 'Checkout')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
@endsection

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Billing Form -->
            <div class="col-md-12 col-lg-7 mb-4">
                <div class="card p-4">
                    <h2 class="h4 mb-4">Billing Information</h2>
                    <form id="payment-form" method="POST" action="{{ route('checkout.processPayment') }}">
                        @csrf
                        <input type="hidden" name="booking_id" value="{{ $booking->id }}">

                        <div class="mb-3">
                            <label for="billing_name" class="form-label">Name: *</label>
                            <input type="text" class="form-control" id="billing_name" name="billing_name" value="{{ old('billing_name', $user->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="billing_email" class="form-label">Email Address: *</label>
                            <input type="email" class="form-control" id="billing_email" name="billing_email" value="{{ old('billing_email', $user->email) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="billing_phone" class="form-label">Phone Number: *</label>
                            <input type="text" class="form-control" id="billing_phone" name="billing_phone" value="{{ old('billing_phone', $user->phone_number) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Choose Payment Method</label>
                            <select name="payment_method" id="payment_method" class="form-control" required>
                                <option value="credit_card">Credit/Debit Card (Stripe)</option>
                                <option value="paypal">PayPal</option>
                            </select>
                        </div>

                        <!-- Stripe Card Element -->
                        <div id="credit_card_payment" class="payment-method">
                            <label for="card-element" class="form-label">Credit or Debit Card</label>
                            <div id="card-element" class="form-control p-2"></div>
                            <div id="card-errors" role="alert"></div>
                        </div>

                        <!-- PayPal Button -->
                        <div id="paypal-button-container" class="mt-3" style="display: none;"></div>

                        <button type="submit" class="btn btn-success w-100 mt-3" id="payment-submit">Proceed to Payment</button>
                    </form>
                </div>
            </div>

            <!-- Course Summary -->
            <div class="col-md-12 col-lg-5">
                <h2 class="h4 mb-4">Your Courses</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Course</th>
                            <th>Details</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courses as $course)
                        <tr>
                            <td>{{ $course->title }}</td>
                            <td>
                                Start Date: {{ optional($course->start_date)->format('F j, Y') ?? 'Not Set' }}<br>
                                Duration: {{ $course->duration }} Hours
                            </td>
                            <td>${{ number_format($course->price, 2) }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="2"><strong>Total:</strong></td>
                            <td><strong>${{ number_format($courses->sum('price'), 2) }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<!-- Stripe -->
<script src="https://js.stripe.com/v3/"></script>
<!-- PayPal -->
<script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_CLIENT_ID') }}&currency=USD"></script>

<script>
    const stripe = Stripe('{{ env("STRIPE_KEY") }}');
    const elements = stripe.elements();
    const card = elements.create('card');
    card.mount('#card-element');

    // Display error for Stripe
    card.on('change', function(event) {
        const displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    let paypalLoaded = false;

    const paymentSelect = document.getElementById('payment_method');
    const creditCardSection = document.getElementById('credit_card_payment');
    const paypalSection = document.getElementById('paypal-button-container');

    paymentSelect.addEventListener('change', function () {
        const method = this.value;

        if (method === 'credit_card') {
            creditCardSection.style.display = 'block';
            paypalSection.style.display = 'none';
        } else if (method === 'paypal') {
            creditCardSection.style.display = 'none';
            paypalSection.style.display = 'block';

            if (!paypalLoaded) {
                paypal.Buttons({
                    createOrder: function (data, actions) {
                        return actions.order.create({
                            purchase_units: [{
                                amount: {
                                    value: '{{ number_format($courses->sum('price'), 2) }}'
                                }
                            }]
                        });
                    },
                    onApprove: function (data, actions) {
                        return actions.order.capture().then(function (details) {
                            window.location.href = "{{ route('payment.success') }}";
                        });
                    },
                    onError: function (err) {
                        alert('Payment failed. Please try again.');
                        console.error(err);
                    }
                }).render('#paypal-button-container');
                paypalLoaded = true;
            }
        } else {
            creditCardSection.style.display = 'none';
            paypalSection.style.display = 'none';
        }
    });

    // Trigger initial change to set default display
    paymentSelect.dispatchEvent(new Event('change'));

    // Handle Stripe payment submission
    const submitButton = document.getElementById('payment-submit');
    submitButton.addEventListener('click', async function (event) {
        event.preventDefault(); // Prevent default form submission
        
        if (paymentSelect.value === 'credit_card') {
            const {token, error} = await stripe.createToken(card);

            if (error) {
                // Handle Stripe error
                alert(error.message);
            } else {
                // Create hidden input for Stripe token and submit form
                const form = document.getElementById('payment-form');
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'stripe_token';
                input.value = token.id;
                form.appendChild(input);
                form.submit(); // Submit the form with token to server
            }
        }
    });
</script>
@endsection
