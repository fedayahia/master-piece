<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\UserController as UserControllerMain;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController ;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\ReviewController as UserReviewController;
// use App\Http\Controllers\InstructorController;
use App\Http\Controllers\Instructor\ReviewController as InstructorReviewController;
use App\Http\Controllers\Instructor\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController as FrontPaymentController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Instructor\CourseController as InstructorCourseController;
use App\Http\Controllers\Admin\CourseSessionController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Instructor\CourseSessionController as InstructorCourseSessionController ;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Instructor\InstructorController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Instructor\ParentController;
use App\Http\Controllers\LiveSessionController;
use App\Http\Controllers\PrivateSessionController;
use App\Models\Coupon;
use App\Http\Controllers\Instructor\PrivateSessionController as InstructorPrivateSessionController;



use App\Http\Controllers\Admin\PrivateSessionController as AdminPrivateSessionController;

use App\Http\Controllers\Instructor\AvailableTimeController;

use App\Http\Controllers\EventController;
use App\Http\Controllers\Admin\EventController as AdminEventController ;

use App\Http\Controllers\InstructorDashboardController;
use App\Http\Controllers\Instructor\ProfileController as InstructorProfileController;


    // Routes for Available Time Management


// Private Sessions Routes


Route::get('/instructor/dashboard', [InstructorDashboardController::class, 'showDashboard'])->name('instructor.dashboard');

Route::get('/private-sessions', [PrivateSessionController::class, 'index'])->name('private-sessions.index');

Route::get('/private-sessions/{sessionId}/book', [PrivateSessionController::class, 'showBookingForm'])->name('private-sessions.book');

Route::post('/private-sessions/store-time', [PrivateSessionController::class, 'storeSelectedTime'])
     ->name('private-sessions.storeSelectedTime');Route::post('/private-sessions/process-booking', [PrivateSessionController::class, 'processBooking'])->name('private-sessions.processBooking');
 
            Route::get('/payment', [PrivateSessionController::class, 'showPaymentForm'])->name('private-sessions.payment');
    Route::post('/payment', [PrivateSessionController::class, 'processPayment'])->name('private-sessions.process-payment');
    Route::get('/confirmation', [PrivateSessionController::class, 'confirmation'])->name('private-sessions.confirmation');

    Route::get('/private-sessions/{session}/book', [PrivateSessionController::class, 'showBookingForm'])
     ->name('private-sessions.book');

Route::get('/private-sessions/{session}', [PrivateSessionController::class, 'show'])
     ->name('private-sessions.show');

//FRONT
Route::get('/', [UserControllerMain::class, 'team'])->name('home');
Route::get('/about', function () { return view('about'); })->name('about');
Route::get('/service', function () { return view('service'); })->name('service');
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{id}', [CourseController::class, 'show'])->name('courses.show');
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/blog', function () { return view('blog'); })->name('blog');
Route::get('/team', [TeamController::class, 'index'])->name('team');
Route::get('/testimonial', function () { return view('testimonial'); })->name('testimonial');
Route::get('/404', function () { return view('404'); })->name('notfound');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::resource('live_sessions', LiveSessionController::class);
Route::post('/live-sessions/{id}/join', [LiveSessionController::class, 'join'])->name('live_sessions.join');

//REGISTER & LOGIN
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//ADMIN
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/profile/edit', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/show', [AdminProfileController::class, 'show'])->name('user.profile');
    Route::resource('private-sessions', AdminPrivateSessionController::class);
    Route::get('events', [AdminEventController::class, 'index'])->name('events.index');

    Route::get('events/create', [AdminEventController::class, 'create'])->name('events.create');

    Route::post('events', [AdminEventController::class, 'store'])->name('events.store');

    Route::get('events/{event}', [AdminEventController::class, 'show'])->name('events.show');

    Route::get('events/{event}/edit', [AdminEventController::class, 'edit'])->name('events.edit');

    Route::put('events/{event}', [AdminEventController::class, 'update'])->name('events.update');

    Route::delete('events/{event}', [AdminEventController::class, 'destroy'])->name('events.destroy');
    Route::get('/reviews', [App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('reviews.index');
    Route::delete('/reviews/{id}', [App\Http\Controllers\Admin\ReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::resource('courses', AdminCourseController::class);
    Route::resource('users', AdminUserController::class);
    Route::resource('enrollments', EnrollmentController::class);
    Route::resource('payments', AdminPaymentController::class);
    Route::get('payments/{payment}/print', [AdminPaymentController::class, 'print'])->name('payments.print');
    Route::resource('lessons', LessonController::class);
    Route::resource('course-sessions', CourseSessionController::class);
    Route::resource('bookings', AdminBookingController::class);
    Route::resource('contact', ContactMessageController::class)->only(['index', 'show', 'destroy']);
    Route::resource('coupons', CouponController::class);
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
});

// Instructor
Route::prefix('instructor')->middleware(['auth', 'role:instructor'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('instructor.profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('instructor.profile.edit');
    
    Route::put('/profile', [ProfileController::class, 'update'])->name('instructor.profile.update');
    Route::get('/parent-courses', [ParentController::class, 'parentCourses'])
    ->name('instructor.parents.index');
    Route::get('available_times', [AvailableTimeController::class, 'index'])->name('instructor.available_times.index');
    Route::get('available_times/create', [AvailableTimeController::class, 'create'])->name('instructor.available_times.create');
    Route::post('available_times', [AvailableTimeController::class, 'store'])->name('instructor.available_times.store');
    Route::delete('available_times/{id}', [AvailableTimeController::class, 'destroy'])->name('instructor.available_times.destroy');

    Route::get('private-sessions', [InstructorPrivateSessionController::class, 'index'])->name('instructor.private-sessions.index');
    Route::get('private-sessions/create', [InstructorPrivateSessionController::class, 'create'])->name('instructor.private-sessions.create');
    Route::post('private-sessions', [InstructorPrivateSessionController::class, 'store'])->name('instructor.private-sessions.store');
    Route::get('private-sessions/{privateSession}', [InstructorPrivateSessionController::class, 'show'])->name('instructor.private-sessions.show');
    Route::get('private-sessions/{privateSession}/edit', [InstructorPrivateSessionController::class, 'edit'])->name('instructor.private-sessions.edit');
    Route::put('private-sessions/{privateSession}', [InstructorPrivateSessionController::class, 'update'])->name('instructor.private-sessions.update');
    Route::delete('private-sessions/{privateSession}', [InstructorPrivateSessionController::class, 'destroy'])->name('instructor.private-sessions.destroy');
Route::get('/parent-courses/{course}/details', [ParentController::class, 'courseParentsDetails'])
    ->name('instructor.parent-courses.details');
    Route::get('/reviews', [InstructorReviewController::class, 'index'])->name('instructor.reviews.index');
    Route::get('/reviews/{course}', [InstructorReviewController::class, 'show'])->name('instructor.reviews.show');
    // Route::get('/students', [InstructorController::class, 'students'])->name('instructor.students');
    Route::get('/students/{enrollment}', [InstructorController::class, 'showStudent'])->name('instructor.students.show');
    // Route::get('/dashboard', [InstructorDashboardController::class, 'index'])->name('instructor.dashboard');
   
    Route::get('/courses', [InstructorController::class, 'index'])->name('instructor.courses.index');
    Route::get('/courses/create', [InstructorCourseController::class, 'create'])->name('instructor.courses.create');
Route::post('/courses', [InstructorCourseController::class, 'store'])->name('instructor.courses.store');
Route::post('/courses/{id}', [InstructorCourseController::class, 'show'])->name('instructor.courses.show');
Route::get('/courses/{id}/edit', [InstructorCourseController::class, 'edit'])->name('instructor.courses.edit');
Route::put('/courses/{id}', [InstructorCourseController::class, 'update'])->name('instructor.courses.update');
Route::delete('/courses/{id}', [InstructorCourseController::class, 'destroy'])->name('instructor.courses.destroy');
    Route::get('course_sessions', [InstructorCourseSessionController::class, 'index'])->name('instructor.course_sessions.index');
    
    Route::get('course_sessions/create', [InstructorCourseSessionController::class, 'create'])->name('instructor.course_sessions.create');
    
    Route::post('course_sessions', [InstructorCourseSessionController::class, 'store'])->name('instructor.course_sessions.store');
    
    Route::get('course_sessions/{course_session}', [InstructorCourseSessionController::class, 'show'])->name('instructor.course_sessions.show');
    
    Route::get('course_sessions/{course_session}/edit', [InstructorCourseSessionController::class, 'edit'])->name('instructor.course_sessions.edit');
    
    Route::put('course_sessions/{course_session}', [InstructorCourseSessionController::class, 'update'])->name('instructor.course_sessions.update');
    


    Route::delete('course_sessions/{course_session}', [InstructorCourseSessionController::class, 'destroy'])->name('instructor.course_sessions.destroy');
 

});



Route::middleware('auth')->prefix('instructor')->name('instructor.')->group(function() {
    Route::resource('private-sessions', \App\Http\Controllers\Instructor\PrivateSessionController::class);

});



// User
Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserControllerMain::class, 'show'])->name('user.profile');
    Route::get('/profile/edit', [UserControllerMain::class, 'edit'])->name('user.edit');
    Route::match(['put', 'post'], '/profile/update', [UserControllerMain::class, 'update'])->name('user.update');
});


// Reviews

Route::middleware('auth')->group(function () {
    Route::post('/reviews/store', [UserReviewController::class, 'store'])->name('reviews.store');  
    Route::get('/reviews/{course}', [UserReviewController::class, 'show'])->name('reviews.show');  
});

// المسارات الخاصة بالـ Bookings
// Route::get('/checkout/{booking}', [CheckoutController::class, 'index'])->name('checkout.index');
// Route::post('/checkout/process', [CheckoutController::class, 'processPayment'])->name('checkout.processPayment');
// Route::get('/payment/success', [CheckoutController::class, 'paymentSuccess'])->name('payment.success');
// Route::get('/payment/cancel', [CheckoutController::class, 'paymentCancel'])->name('payment.cancel');



// use App\Http\Controllers\InstructorDashboardController;



// Checkout Process
// Checkout Routes

    


// Checkout Routes

    

Route::middleware(['auth'])->group(function () {
    // Booking Routes
    Route::resource('bookings', BookingController::class)->only(['index', 'store']);
    Route::get('/courses/{course_id}/booking', [BookingController::class, 'create'])->name('booking.create');
    
    // Checkout Process
    Route::prefix('checkout')->group(function () {
Coupon::whereNotNull('applicable_id')->update(['applicable_type' => 'App\Models\Course']);
        // Billing
  

Route::get('/checkout/billing', [CheckoutController::class, 'billing'])
     ->name('checkout.billing');
                        // Route::get('/checkout/billing/{type}/{id}', [CheckoutController::class, 'billing'])->name('checkout.billing');
  Route::post('/checkout/process-billing', [CheckoutController::class, 'processBilling'])->name('checkout.processBilling');
  Route::get('/checkout/payment', [CheckoutController::class, 'payment'])->name('checkout.payment');
Route::post('/payment/stripe', [CheckoutController::class, 'handleStripe'])
    ->name('stripe.payment');
        // Route::post('/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('checkout.apply-coupon');
        
        // Payment Processing
        Route::post('/paypal/payment', [CheckoutController::class, 'handlePaypal'])->name('paypal.payment');
        
        // Completion
        Route::get('/complete', [CheckoutController::class, 'complete'])->name('checkout.complete');
    });
});

 // COUPON
Route::post('/checkout/apply-coupon', [CheckoutController::class, 'applyCoupon'])
->middleware('auth')
->name('checkout.apply-coupon');

Route::post('/checkout/remove-coupon', [CheckoutController::class, 'removeCoupon'])
->middleware('auth')
->name('checkout.remove-coupon');

