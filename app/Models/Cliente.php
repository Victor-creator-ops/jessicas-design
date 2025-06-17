<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'cpf_cnpj', 'telefone', 'endereco'];

    /**
     * Um perfil de Cliente pertence a um Usuário.
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Um Cliente pode ter vários Projetos.
     */
    public function projetos()
    {
        return $this->hasMany(Projeto::class);
    }
}