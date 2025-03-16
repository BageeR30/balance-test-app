<?php

namespace App\Observers;

use App\Models\Transaction;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Cache;

class TransactionObserver implements ShouldHandleEventsAfterCommit
{
    public function updating(Transaction $transaction): void
    {
        Cache::lock($this->getLockName($transaction), 10)->get();
    }

    public function updated(Transaction $transaction): void
    {
        $transaction
            ->balance()
            ->increment('amount', $transaction->amount);

        Cache::lock($this->getLockName($transaction))->forceRelease();
    }

    private function getLockName(Transaction $transaction): string
    {
        return 'balance_' . $transaction->user_id;
    }
}
