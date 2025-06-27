<?php

// tests/Unit/ProjetoTest.php

use App\Models\Cliente;
use App\Models\Projeto;

it('belongs to a cliente', function () {
    // 1. Arrange: Create a Cliente and a Projeto associated with it.
    $cliente = Cliente::factory()->create();
    $projeto = Projeto::factory()->create(['cliente_id' => $cliente->id]);

    // 2. Act & Assert: Check if the relationship exists and is an instance of the Cliente class.
    expect($projeto->cliente)->toBeInstanceOf(Cliente::class)
        ->and($projeto->cliente->id)->toBe($cliente->id);
});
