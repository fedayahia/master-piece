@extends('front.layout.app')

@section('main_content')
<script src="https://www.paypalobjects.com/api/checkout.js"></script>

<div class="page-top">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Payment for Course Enrollment</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4 checkout-left mb_30">
                <h4>Make Payment</h4>
                <select name="payment_method" class="form-control select2" id="paymentMethodChange">
                    <option value="">Select Payment Method</option>
                    <option value="PayPal">PayPal</option>
                    <option value="Stripe">Stripe</option>
                </select>

                <div class="paypal mt_20">
                    <h4>Pay with PayPal</h4>
                    <div id="paypal-button"></div>
                </div>

                <div class="stripe mt_20">
                    <h4>Pay with Stripe</h4>
                    @php
                    $cents = $total_price*100;
                    $customer_email = Auth::user()->email;
                    $stripe_publishable_key = env('STRIPE_PUBLISHABLE_KEY');
                    @endphp
                    <form action="{{ route('stripe.payment') }}" method="post">
                        @csrf
                        <input type="hidden" name="amount" value="{{ $total_price }}">
                        <script
                            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                            data-key="{{ $stripe_publishable_key }}"
                            data-amount="{{ $cents }}"
                            data-name="{{ env('APP_NAME') }}"
                            data-description="Course Enrollment"
                            data-image="{{ asset('stripe.png') }}"
                            data-currency="usd"
                            data-email="{{ $customer_email }}">
                        </script>
                    </form>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 checkout-right">
                <div class="inner">
                    <h4 class="mb_10">Billing Details</h4>
                    <div>Name: {{ session()->get('billing_name') }}</div>
                    <div>Email: {{ session()->get('billing_email') }}</div>
                    <!-- باقي بيانات الفاتورة -->
                </div>
            </div>

            <div class="col-lg-4 col-md-4 checkout-right">
                <div class="inner">
                    <h4 class="mb_10">Course Details</h4>
                    @php
                    $course = App\Models\Course::find(session()->get('cart_course_id')[0]);
                    $session = App\Models\CourseSession::find(session()->get('cart_session_id')[0] ?? null);
                    @endphp
                    
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>
                                        <strong>{{ $course->title }}</strong>
                                        @if($session)
                                        <br>Session: {{ $session->name }}
                                        @endif
                                    </td>
                                    <td class="p_price">${{ $course->price }}</td>
                                </tr>
                                @if(session()->has('coupon_discount'))
                                <tr>
                                    <td>Discount</td>
                                    <td class="p_price">-${{ session()->get('coupon_discount') }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td><b>Total:</b></td>
                                    <td class="p_price"><b>${{ $total_price }}</b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
paypal.Button.render({
    env: '{{ env('PAYPAL_ENVIRONMENT') }}',
    client: {
        sandbox: '{{ env('PAYPAL_SANDBOX_CLIENT_ID') }}',
        production: '{{ env('PAYPAL_LIVE_CLIENT_ID') }}'
    },
    locale: 'en_US',
    style: {
        size: 'medium',
        color: 'blue',
        shape: 'rect',
    },
    payment: function(data, actions) {
        return actions.payment.create({
            transactions: [{
                amount: {
                    total: '{{ $total_price }}',
                    currency: 'USD'
                },
                description: 'Payment for {{ $course->title }}'
            }]
        });
    },
    onAuthorize: function(data, actions) {
        return actions.payment.execute().then(function() {
            window.location.href = '{{ url("payment/paypal/process") }}?payment_id='+data.paymentID+'&token='+data.paymentToken+'&payerID='+data.payerID+'&amount={{ $total_price }}';
        });
    }
}, '#paypal-button');
</script>
@endsection