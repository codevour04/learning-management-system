<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'transaction_number' => fake()->iban(),
            'issued_at' => fake()->dateTime(),
            'status' => fake()->randomElement([10001, 10002, 10003]),
            'transaction_number' => fake()->iban(),
            'customers_id' => Customer::factory(),
            'sales_agent' => User::factory(),
            'pre_approver' => User::factory(),
            'pre_approved_at' => fake()->dateTime(),
            'final_approver' => User::factory(),
            'final_approved_at' => fake()->dateTime(),
        ];
    }
}
