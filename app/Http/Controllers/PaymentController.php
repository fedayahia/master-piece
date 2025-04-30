<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Payment;
use Stripe\Stripe;
use Stripe\PaymentIntent;


class PaymentController extends Controller
{
    public function paypalPayment(Request $request) {
        $booking = Booking::find(session('current_booking_id'));
        
        // Verify PayPal payment
        $paymentStatus = $this->verifyPayPalPayment($request->payment_id);
        
        if($paymentStatus === 'COMPLETED') {
            // Create payment record
            Payment::create([
                'booking_id' => $booking->id,
                'amount' => session('course_price'),
                'payment_method' => 'paypal',
                'transaction_id' => $request->payment_id,
                'status' => 'completed'
            ]);
            
            // Update booking status
            $booking->update(['status' => 'confirmed']);
            
            // Clear session
            session()->forget(['current_booking_id', 'course_id', 'course_title', 'course_price']);
            
            return redirect()->route('checkout.complete');
        }
        
        return back()->with('error', 'Payment failed. Please try again.');
    }
    
    public function stripePayment(Request $request) {
        $booking = Booking::find(session('current_booking_id'));
        $amount = (session('course_price') - (session('coupon_discount') ?? 0)) * 100;
        
        try {
            $charge = \Stripe\Charge::create([
                'amount' => $amount,
                'currency' => 'usd',
                'source' => $request->stripeToken,
                'description' => 'Payment for course: ' . session('course_title'),
            ]);
            
            // Create payment record
            Payment::create([
                'booking_id' => $booking->id,
                'amount' => session('course_price'),
                'payment_method' => 'stripe',
                'transaction_id' => $charge->id,
                'status' => 'completed'
            ]);
            
            // Update booking status
            $booking->update(['status' => 'confirmed']);
            
            // Clear session
            session()->forget(['current_booking_id', 'course_id', 'course_title', 'course_price']);
            
            return redirect()->route('checkout.complete');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
