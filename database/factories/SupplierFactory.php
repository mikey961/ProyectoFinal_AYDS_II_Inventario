<?php

namespace Database\Factories;

use App\Models\Identity;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'identity_id' => Identity::inRandomOrder()->value('id'),
            'document_number' => $this->faker->unique()->numerify('###########'),
            'name' => $this->faker->company(),
            'address' => $this->faker->address(),
            'email' => $this->faker->safeEmail(), 
            'phone' => $this->faker->phoneNumber()
        ];
    }
}
