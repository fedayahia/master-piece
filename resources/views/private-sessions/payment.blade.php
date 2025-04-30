@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Complete Payment</h4>
                </div>
                
                <div class="card-body">
                    <div class="alert alert-info">
                        <h5 class="alert-heading">{{ $booking->bookable->title }}</h5>
                        <p class="mb-2">
                            <i class="far fa-calendar-alt"></i> 
                            {{ $booking->booking_date->format('l, F j, Y \a\t h:i A') }}
                        </p>
                        <p class="mb-0">
                            <i class="fas fa-user-tie"></i> 
                            Instructor: {{ $booking->bookable->instructor->name }}
                        </p>
                    </div>
                    
                    <div class="border p-3 rounded mb-4">
                        <h5 class="text-center mb-3">Payment Summary</h5>
                        <table class="table table-borderless">
                            <tr>
                                <th>Session Price</th>
                                <td class="text-end">{{ number_format($booking->bookable->price, 2) }} JD</td>
                            </tr>
                            <tr class="fw-bold">
                                <th>Total Amount</th>
                                <td class="text-end">{{ number_format($booking->bookable->price, 2) }} JD</td>
                            </tr>
                        </table>
                    </div>
                    
                    <form id="payment-form" action="{{ route('private-sessions.process-payment') }}" method="POST">
                        @csrf
                        <div id="card-element" class="mb-3 p-3 border rounded"></div>
                        <div id="card-errors" role="alert" class="alert alert-danger d-none"></div>
                        
                        <button id="submit-button" class="btn btn-primary btn-lg w-100 py-2">
                            <span id="button-text">Pay Now</span>
                            <span id="button-spinner" class="spinner-border spinner-border-sm d-none"></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe = Stripe('{{ $stripeKey }}');
    const elements = stripe.elements();
    const card = elements.create('card', {
        style: {
            base: {
                fontSize: '16px',
                color: '#32325d',
            }
        }
    });
    
    card.mount('#card-element');
    
    const form = document.getElementById('payment-form');
    const submitButton = document.getElementById('submit-button');
    const buttonText = document.getElementById('button-text');
    const buttonSpinner = document.getElementById('button-spinner');
    const cardErrors = document.getElementById('card-errors');
    
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        submitButton.disabled = true;
        buttonText.classList.add('d-none');
        buttonSpinner.classList.remove('d-none');
        cardErrors.classList.add('d-none');
        
        const {error, paymentMethod} = await stripe.createPaymentMethod({
            type: 'card',
            card: card,
        });
        
        if (error) {
            cardErrors.textContent = error.message;
            cardErrors.classList.remove('d-none');
            
            submitButton.disabled = false;
            buttonText.classList.remove('d-none');
            buttonSpinner.classList.add('d-none');
        } else {
            const hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', paymentMethod.id);
            form.appendChild(hiddenInput);
            
            form.submit();
        }
    });
</script>
@endsection