<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    UserController,
    ServiceController,
    AvailabilityController,
    BookingController,
    ReviewController,
    CommunicationController,
    AdminDashboardController,
    AdminBookingController,
    AddOnController,
    ChatController,
    SmsController,
    PaymentController
};

// Public routes
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login'])->name('login');

// Public routes for Add-Ons
Route::get('/add_ons', [AddOnController::class, 'index']);
Route::get('/add_ons/{id}', [AddOnController::class, 'show']);

// Protected routes
Route::middleware(['auth:sanctum'])->group(function() {
    // Logout route
    Route::post('/logout', [UserController::class, 'logout']);

        // Service routes
        Route::get('/services', [ServiceController::class, 'index']);
        Route::get('/services/{id}', [ServiceController::class, 'show']);
        Route::post('/services', [ServiceController::class, 'store']);
        Route::put('/services/{id}', [ServiceController::class, 'update']);
        Route::delete('/services/{id}', [ServiceController::class, 'destroy']);

        // Availability routes
        Route::get('/availabilities', [AvailabilityController::class, 'index'])->middleware('throttle:60,1');
        Route::post('/availabilities', [AvailabilityController::class, 'store']);
        Route::delete('/availabilities/{date}', [AvailabilityController::class, 'destroy'])->middleware('role:Admin');

        // Payment routes
        Route::post('/payment/initiate', [PaymentController::class, 'initiatePayment']);
        Route::post('/payment/confirm', [PaymentController::class, 'confirmPayment']);
        Route::post('/create-payment-source', [PaymentController::class, 'createPaymentSource']);

        // Booking routes
        Route::get('/bookings', [BookingController::class, 'index']);
        Route::get('/bookings/{id}', [BookingController::class, 'show']);
        Route::post('/bookings', [BookingController::class, 'store']);
        Route::put('/bookings/{id}', [BookingController::class, 'update']);
        Route::delete('/bookings/{id}', [BookingController::class, 'destroy']);
        Route::put('/bookings/confirm/{id}', [BookingController::class, 'confirm']);
        Route::post('/bookings/{id}/initiate-payment', [BookingController::class, 'initiatePayment']);
        Route::post('/payment/callback', [BookingController::class, 'handlePaymentCallback']);
        Route::post('/create-payment-request', [BookingController::class, 'createPaymentRequest']);

        // Review routes
        Route::get('/reviews', [ReviewController::class, 'index']);
        Route::get('/reviews/{id}', [ReviewController::class, 'show']);
        Route::post('/reviews', [ReviewController::class, 'store']);
        Route::put('/reviews/{id}', [ReviewController::class, 'update']);
        Route::delete('/reviews/{id}', [ReviewController::class, 'destroy']);

        // Communication routes
        Route::get('/communications', [CommunicationController::class, 'index']);
        Route::get('/communications/{id}', [CommunicationController::class, 'show']);
        Route::post('/communications', [CommunicationController::class, 'store']);
        Route::put('/communications/{id}', [CommunicationController::class, 'update']);
        Route::delete('/communications/{id}', [CommunicationController::class, 'destroy']);

        // Sms routes
        Route::post('/send-sms', [SmsController::class, 'sendSms']);

        // Message routes
        Route::get('/current-user', [UserController::class, 'currentUser']);
        Route::get('/messages', [ChatController::class, 'fetchMessages']);
        Route::post('/messages', [ChatController::class, 'sendMessage']);

        // Admin-specific routes
        Route::middleware(['role:Admin'])->group(function () {
        
        // AdminDashboard routes
        Route::get('/admin-dashboards', [AdminDashboardController::class, 'index']);
        Route::get('/admin-dashboards/{id}', [AdminDashboardController::class, 'show']);
        Route::post('/admin-dashboards', [AdminDashboardController::class, 'store']);
        Route::put('/admin-dashboards/{id}', [AdminDashboardController::class, 'update']);
        Route::delete('/admin-dashboards/{id}', [AdminDashboardController::class, 'destroy']);

        // Admin Booking routes
        Route::get('/admin/bookings', [AdminBookingController::class, 'index']);
        Route::put('/admin/bookings/{id}', [AdminBookingController::class, 'update']);
        Route::delete('/admin/bookings/{id}', [AdminBookingController::class, 'destroy']);

        // Admin registration route
        Route::post('/register-admin', [UserController::class, 'registerAdmin']);
    });

        // Protected Add-On routes
            Route::post('/add_ons', [AddOnController::class, 'store'])->middleware('role:Admin');
            Route::put('/add_ons/{id}', [AddOnController::class, 'update'])->middleware('role:Admin');
            Route::delete('/add_ons/{id}', [AddOnController::class, 'destroy'])->middleware('role:Admin');
        });

        // Add the broadcasting routes here
        Broadcast::routes(['middleware' => ['auth:sanctum']]);
        Broadcast::channel('chat', function ($user) {
            return Auth::check();
        });
