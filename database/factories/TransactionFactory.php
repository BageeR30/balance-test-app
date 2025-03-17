<?php

namespace Database\Factories;

use App\Constants\TransactionStatusConstants;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'amount' => $this->faker->randomFloat(2, 1, 100),
            'description' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(TransactionStatusConstants::LIST),
        ];
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => TransactionStatusConstants::PENDING,
        ]);
    }

    public function success(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => TransactionStatusConstants::SUCCESS,
        ]);
    }

    public function failed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => TransactionStatusConstants::FAILED,
        ]);
    }
}
