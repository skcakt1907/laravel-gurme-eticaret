<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

/* ---------------- Vitrin ---------------- */
Route::get('/', [HomeController::class, 'index'])->name('home');

/* ---------------- Dil değiştir (TR/EN) ---------------- */
Route::get('/lang/{locale}', function (string $locale) {
    if (in_array($locale, ['tr', 'en'], true)) {
        session(['locale' => $locale]);
    }
    return redirect()->back();
})->name('lang.switch');

Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/product/{product}', [ShopController::class, 'show'])->name('product');

Route::get('/why-aegea', [PageController::class, 'services'])->name('services');
Route::get('/why-aegea/{service}', [PageController::class, 'serviceShow'])->name('service.show');
Route::get('/journal', [PageController::class, 'blog'])->name('blog');
Route::get('/journal/{post}', [PageController::class, 'blogShow'])->name('blog.show');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'contactStore'])->middleware('spam')->name('contact.store');
Route::post('/trade-request', [PageController::class, 'appointment'])->middleware('spam')->name('appointment');

/* ---------------- Legal pages ---------------- */
Route::get('/page/{slug}', [LegalController::class, 'show'])->name('legal');

/* ---------------- Sitemap ---------------- */
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

/* ---------------- Sepet (katalog modunda 'satis' middleware'i kapatır) ---------------- */
Route::middleware('satis')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    /* ---------------- Checkout ---------------- */
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{order:order_no}', [CheckoutController::class, 'success'])->name('checkout.success');
});
Route::match(['get', 'post'], '/checkout/callback/{order:order_no}', [CheckoutController::class, 'callback'])->name('checkout.callback');

/* ---------------- Membership ---------------- */
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('spam');

    // Forgot / reset password
    Route::get('/forgot-password', [PasswordResetController::class, 'showRequest'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendLink'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showReset'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'reset'])->name('password.update');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/* ---------------- E-posta doğrulama (alışverişi engellemez, bilgilendirmedir) ---------------- */
Route::middleware('auth')->group(function () {
    Route::get('/verify-email', fn () => auth()->user()->hasVerifiedEmail()
        ? redirect()->route('account')
        : view('auth.verify-email'))->name('verification.notice');

    Route::get('/verify-email/{id}/{hash}', function (\Illuminate\Foundation\Auth\EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect()->route('account')->with('success', __('Your email address has been verified. Thank you!'));
    })->middleware('signed')->name('verification.verify');

    Route::post('/verify-email/send', function (\Illuminate\Http\Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    })->middleware('throttle:6,1')->name('verification.send');
});

/* ---------------- Account ---------------- */
Route::middleware('auth')->prefix('account')->name('account')->group(function () {
    Route::get('/', [AccountController::class, 'index']);
    Route::get('/orders', [AccountController::class, 'orders'])->name('.orders');
    Route::get('/order/{order:order_no}', [AccountController::class, 'orderShow'])->name('.order');
    Route::post('/update', [AccountController::class, 'update'])->name('.update');
});

/* ---------------- Admin ---------------- */
Route::middleware(['auth', 'admin'])->prefix('yonetim')->name('admin.')->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('products', Admin\ProductController::class)->except('show');
    Route::resource('categories', Admin\CategoryController::class)->except('show');

    Route::get('/orders', [Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [Admin\OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}', [Admin\OrderController::class, 'update'])->name('orders.update');

    Route::get('/settings', [Admin\SettingController::class, 'edit'])->name('settings.edit');
    Route::post('/settings', [Admin\SettingController::class, 'update'])->name('settings.update');

    Route::get('/profile', [Admin\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [Admin\ProfileController::class, 'update'])->name('profile.update');

    Route::get('/appointments', [Admin\AppointmentController::class, 'index'])->name('appointments.index');
    Route::patch('/appointments/{appointment}', [Admin\AppointmentController::class, 'update'])->name('appointments.update');

    Route::get('/messages', [Admin\ContactMessageController::class, 'index'])->name('messages.index');
    Route::patch('/messages/{message}', [Admin\ContactMessageController::class, 'update'])->name('messages.update');
    Route::delete('/messages/{message}', [Admin\ContactMessageController::class, 'destroy'])->name('messages.destroy');
});
