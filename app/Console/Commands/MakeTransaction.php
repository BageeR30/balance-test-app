<?php

namespace App\Console\Commands;

use App\Jobs\ProcessTransaction;
use App\Models\User;
use App\Services\TransactionService;
use Illuminate\Console\Command;

class MakeTransaction extends Command
{
    protected $signature = 'app:make-transaction';

    protected $description = 'Create transaction';

    public function handle(): void
    {
        $email = $this->ask('Login:');
        $amount = $this->ask('Amount:');
        $description = $this->ask('Description:');

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error('User not found');
            return;
        }

        $service = app(TransactionService::class);

        if (!$service->checkBalance($user, $amount)) {
            $this->error('Insufficient balance');
            return;
        }

        $transaction = app(TransactionService::class)->createPending($user, $amount, $description);

        ProcessTransaction::dispatch($transaction);

        $this->info('Transaction dispatched');
    }
}
