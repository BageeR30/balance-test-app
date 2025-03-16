<?php

namespace Tests\Unit;

use App\Jobs\ProcessTransaction;
use App\Models\Balance;
use App\Models\User;
use App\Services\TransactionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_transactions_balance()
    {
        $user = User::factory()->create();

        $transactions = [
            ['amount' => 30.00, 'description' => 'Transaction 1'],
            ['amount' => -20.00, 'description' => 'Transaction 2'],
            ['amount' => 15.00, 'description' => 'Transaction 3'],
        ];

        $service = app(TransactionService::class);

        foreach ($transactions as $data) {
            $transaction = $service->createPending($user, $data['amount'], $data['description']);

            $job = new ProcessTransaction($transaction);
            $job->handle();
        }

        $this->assertEquals(25.00, Balance::find($user->id)->amount);
    }

    //TODO: more tests
}
