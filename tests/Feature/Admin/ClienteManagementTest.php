<?php
// tests/Feature/Admin/ClienteManagementTest.php

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use function Pest\Laravel\{actingAs, post};

it('allows an admin to create a new client', function () {
    // 1. Arrange: Create an admin user to perform the action.
    $admin = User::factory()->create(['role' => 'admin']);

    Validator::extend('dns', function ($attribute, $value, $parameters, $validator) {
        return true;
    });

    // The data for the new client.
    $clientData = [
        'name' => 'New Client Name',
        'email' => 'newclient@example.com',
        'cpf_cnpj' => '123.456.789-00', // This will also be the initial password
        'telefone' => '(19) 99999-8888',
        'endereco' => '123 Main St',
    ];

    // 2. Act: Simulate the admin making a POST request to the store route.
    $response = actingAs($admin)->post(route('admin.clientes.store'), $clientData);

    // 3. Assert: Check if everything went as expected.
    $response
        ->assertRedirect(route('admin.clientes.index')) // Was the user redirected correctly?
        ->assertSessionHas('success'); // Was there a success message?

    // Check if the new user and client exist in the database.
    $this->assertDatabaseHas('users', [
        'name' => 'New Client Name',
        'email' => 'newclient@example.com',
        'role' => 'cliente'
    ]);

    $this->assertDatabaseHas('clientes', [
        'cpf_cnpj' => '123.456.789-00'
    ]);
});
