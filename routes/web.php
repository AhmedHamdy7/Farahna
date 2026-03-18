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
Route::get('/templates/{template}/preview-frame', function (\App\Models\Template $template) {
    $isAr = app()->isLocale('ar');
    $dummyEvent = new \App\Models\Event([
        'groom_name'    => $isAr ? 'أحمد'                          : 'James',
        'bride_name'    => $isAr ? 'سارة'                          : 'Emily',
        'event_date'    => now()->addMonths(3),
        'event_time'    => '20:00',
        'venue_name'    => $isAr ? 'قاعة الأميرة – فندق الشيراتون' : 'The Grand Ballroom – Sheraton Hotel',
        'venue_address' => $isAr ? 'القاهرة، مصر الجديدة'          : 'Cairo, Egypt',
        'venue_map_link'=> null,
        'subdomain'     => null,
        'is_published'  => true,
        'custom_data'   => null,
    ]);
    $dummyEvent->setRelation('template', $template);
    $dummyEvent->setRelation('gallery', collect());
    $dummyEvent->setRelation('approvedWishes', collect($isAr ? [
        (object)['guest_name' => 'محمد علي',    'message' => 'ألف مبروك! ربنا يتمم عليكم بالسعادة 💕', 'created_at' => now()->subHours(2)],
        (object)['guest_name' => 'فاطمة أحمد', 'message' => 'يارب يكون زواجكم مبارك 🌸',              'created_at' => now()->subHours(5)],
    ] : [
        (object)['guest_name' => 'Sarah & Tom',  'message' => 'Wishing you a lifetime of love and happiness! 💕', 'created_at' => now()->subHours(2)],
        (object)['guest_name' => 'The Johnsons', 'message' => 'So happy for you both! Congrats 🌸',               'created_at' => now()->subHours(5)],
    ]));
    $dummyEvent->setRelation('rsvpResponses', collect());

    return view("templates.website.{$template->slug}.index", [
        'event'      => $dummyEvent,
        'isPreview'  => true,
    ]);
})->name('templates.preview-frame');

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
