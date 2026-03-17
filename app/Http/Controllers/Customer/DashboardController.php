<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $events = auth()->user()
            ->events()
            ->with('template')
            ->latest()
            ->get();

        return view('customer.dashboard', compact('events'));
    }
}
