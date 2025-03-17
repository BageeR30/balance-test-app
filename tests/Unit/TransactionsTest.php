<?php

namespace Tests\Unit;

use App\Constants\TransactionStatusConstants;
use App\Jobs\ProcessTransaction;
use App\Models\Balance;
use App\Models\Transaction;
use App\Models\User;
use App\Services\TransactionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransactionsTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function test_balance_creation_with_user()
    {
        $user = User::factory()->create();

        $this->assertNotNull(Balance::find($user->id));
        $this->assertEquals(0, Balance::find($user->id)->amount);
    }

    public function test_transactions_balance()
    {
        $user = User::factory()->create();

        $transactions = [
            ['amount' => 30.00, 'description' => $this->faker->sentence()],
            ['amount' => -20.00, 'description' => $this->faker->sentence()],
            ['amount' => 15.00, 'description' => $this->faker->sentence()],
        ];

        $service = app(TransactionService::class);

        foreach ($transactions as $data) {
            $transaction = $service->createPending($user, $data['amount'], $data['description']);

            $job = new ProcessTransaction($transaction);
            $job->handle();
        }

        $this->assertEquals(25.00, Balance::find($user->id)->amount);
    }

    public function test_transactions_balance_with_negative_amount()
    {
        $user = User::factory()->create();

        $service = app(TransactionService::class);

        $transaction = $service->createPending($user, -10.00, $this->faker->sentence());

        $job = new ProcessTransaction($transaction);
        $job->handle();

        $this->assertEquals(0, Balance::find($user->id)->amount);
        $this->assertEquals(TransactionStatusConstants::FAILED, Transaction::find($transaction->id)->status);
    }

    //TODO: more tests
}
