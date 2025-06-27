<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cliente>
 */
class ClienteFactory extends Factory
{
    protected $model = Cliente::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create(['role' => 'cliente']);

        return [
            'user_id' => $user->id,
            'cpf_cnpj' => $this->faker->numerify('###.###.###-##'),
            'telefone' => $this->faker->phoneNumber,
            'endereco' => $this->faker->address,
        ];
    }
}
