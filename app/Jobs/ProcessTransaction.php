<?php

namespace App\Jobs;

use App\Models\Transaction;
use App\Services\TransactionService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessTransaction implements ShouldQueue
{
    use Queueable;

    public function __construct(private Transaction $transaction)
    {
    }


    public function handle(): void
    {
        app(TransactionService::class)->process($this->transaction);
    }
}
