<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        $user = auth()->user();

        return Inertia::render('Dashboard', [
            'balance' => $user->balance->amount,
            'transactions' => $user->transactions()->latest()->limit(5)->get(),
        ]);
    }
}
