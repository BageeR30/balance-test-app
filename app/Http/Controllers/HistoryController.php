<?php

namespace App\Http\Controllers;

use App\Http\Requests\TableRequest;
use App\Models\Transaction;
use Inertia\Inertia;
use Inertia\Response;

class HistoryController extends Controller
{
    public function index(TableRequest $request): Response
    {
        return Inertia::render('History', [
            'items' => Transaction
                ::where('user_id', $request->user()->id)
                ->search($request->search)
                ->orderBy($request->sort ?? 'created_at', $request->order ?? 'desc')
                ->paginate($request->per_page ?? 10),
        ]);
    }
}
