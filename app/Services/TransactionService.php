<?php

namespace App\Services;

use App\Constants\TransactionStatusConstants;
use App\Models\Transaction;
use App\Models\User;

class TransactionService
{
    public function createPending(User $user, float $amount, string $description): Transaction
    {
        return $user->transactions()->create([
            'amount' => $amount,
            'description' => $description,
            'status' => TransactionStatusConstants::PENDING,
        ]);
    }

    public function process(Transaction $transaction): Transaction
    {
        $transaction->status = !$this->checkBalance($transaction->user, $transaction->amount)
            ? TransactionStatusConstants::FAILED
            : TransactionStatusConstants::SUCCESS;

        $transaction->status === TransactionStatusConstants::SUCCESS
            ? $transaction->save()
            : $transaction->saveQuietly();

        return $transaction;
    }

    public function checkBalance(User $user, float $amount): bool
    {
        $user->refresh();

        return $user->balance->amount + $amount >= 0;
    }
}
