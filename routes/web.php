<?php

use App\Http\Controllers\Customer\AuthController;
use App\Http\Controllers\Customer\DashboardController;
use App\Http\Controllers\Customer\EventController;
use App\Http\Controllers\Invitation\InvitationController;
use App\Http\Controllers\Invitation\RsvpController;
use App\Http\Controllers\Invitation\WishController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Middleware\CustomerMiddleware;
use App\Http\Middleware\InvitationPasswordMiddleware;
use App\Models\Event;
use Illuminate\Support\Facades\Route;

// ─── PUBLIC WEBSITE ───────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/templates', [HomeController::class, 'templates'])->name('templates.index');
Route::get('/templates/{template}/preview', [HomeController::class, 'preview'])->name('templates.preview');
Route::get('/templates/{template}/preview-frame', [HomeController::class, 'previewFrame'])->name('templates.preview-frame');

// ─── GUEST AUTH ───────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',    [AuthController::class, 'login']);
    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ─── CUSTOMER DASHBOARD ───────────────────────────────────────────────────────
Route::middleware([CustomerMiddleware::class])
    ->prefix('dashboard')
    ->name('customer.')
    ->group(function () {
        Route::get('/',                                     [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/events/create',                        [EventController::class, 'create'])->name('events.create');
        Route::get('/events/{event}',                       [EventController::class, 'show'])->name('events.show');
        Route::get('/events/{event}/edit',                  [EventController::class, 'edit'])->name('events.edit');
        Route::put('/events/{event}',                       [EventController::class, 'update'])->name('events.update');
        Route::patch('/events/{event}/wishes/{wish}/approve', [EventController::class, 'approveWish'])->name('events.wishes.approve');
        Route::delete('/events/{event}/wishes/{wish}',       [EventController::class, 'deleteWish'])->name('events.wishes.delete');
        Route::get('/events/{event}/qr',                     [EventController::class, 'qrCode'])->name('events.qr');
        Route::get('/events/{event}/rsvp/export',            [EventController::class, 'exportRsvp'])->name('events.rsvp.export');
        Route::post('/events/{event}/gallery',               [\App\Http\Controllers\Customer\GalleryController::class, 'store'])->name('events.gallery.store');
        Route::delete('/events/{event}/gallery/{gallery}',   [\App\Http\Controllers\Customer\GalleryController::class, 'destroy'])->name('events.gallery.destroy');
    });

// ─── INVITATION (Subdomain) ───────────────────────────────────────────────────
Route::domain('{subdomain}.' . parse_url(config('app.url'), PHP_URL_HOST))
    ->middleware(['web'])
    ->group(function () {
        Route::match(['GET','POST'], '/', function (string $subdomain) {
            $event = Event::where('subdomain', $subdomain)->firstOrFail();
            return app(InvitationController::class)->show($event);
        })->middleware(InvitationPasswordMiddleware::class)->name('invitation.show.subdomain');

        Route::post('/wishes', function (string $subdomain, \Illuminate\Http\Request $request) {
            $event = Event::where('subdomain', $subdomain)->firstOrFail();
            return app(WishController::class)->store($request, $event);
        })->name('invitation.wishes.subdomain');

        Route::post('/rsvp', function (string $subdomain, \Illuminate\Http\Request $request) {
            $event = Event::where('subdomain', $subdomain)->firstOrFail();
            return app(RsvpController::class)->store($request, $event);
        })->name('invitation.rsvp.subdomain');
    });

// ─── INVITATION (Local /i/{event}) ────────────────────────────────────────────
Route::prefix('i')->name('invitation.')->group(function () {
    Route::match(['GET','POST'], '/{event}', [InvitationController::class, 'show'])->middleware(InvitationPasswordMiddleware::class)->name('show');
    Route::post('/{event}/wishes',[WishController::class, 'store'])->name('wishes');
    Route::post('/{event}/rsvp',  [RsvpController::class, 'store'])->name('rsvp');
});
