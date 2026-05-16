<?php

namespace Database\Factories;

use App\Models\StoreBalance;
use App\Models\StoreBalanceHistory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str; // Utility class for generating UUIDs

/**
 * @extends Factory<StoreBalanceHistory>
 */
class StoreBalanceHistoryFactory extends Factory
{
    protected $model = StoreBalanceHistory::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'store_balance_id' => StoreBalance::factory(),
            'type' => 'initial',
            'reference_id' => null,
            'reference_type' => null,
            'amount' => $this->faker->randomFloat(2, 0, 1000000),
            'remarks' => 'Pembuatan Store Baru'
        ];
    }

    /**
     * Configure the model factory lifecycle hook.
     * This force-injects the UUID string right before database execution.
     */
    public function configure(): static
    {
        return $this->afterMaking(function (StoreBalanceHistory $history) {
            if (empty($history->id)) {
                $history->id = (string) Str::uuid();
            }
        });
    }
}