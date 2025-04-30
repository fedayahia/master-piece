<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;

class CoursePaymentController extends Controller
{
    public function checkout()
    {
        return view('course_checkout');
    }

    public function stripePayment(Request $request)
    {
        \Stripe\Stripe::setApiKey('your_stripe_secret_key');
        
        try {
            $charge = \Stripe\Charge::create([
                'amount' => $request->amount * 100,
                'currency' => 'usd',
                'description' => 'Courses Payment',
                'source' => $request->stripeToken,
            ]);
            
            
            return redirect()->route('payment.success');
            
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function paymentSuccess()
    {
        session()->forget('cart_course_id');
        
        return view('payment_success');
    }

public function processCheckout(Request $request)
{
    $validated = $request->validate([
        'billing_name' => 'required',
        'billing_email' => 'required|email',
        'billing_phone' => 'required',
        'payment_method' => 'required'
    ]);
    
    if ($request->payment_method == 'paypal') {
        return $this->processPaypalPayment();
    } else {
        return $this->processCreditCardPayment();
    }
}
}