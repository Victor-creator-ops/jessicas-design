<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroHoras extends Model
{
    use HasFactory;
    protected $table = 'registros_horas'; // Especifica o nome da tabela
    protected $fillable = ['projeto_id', 'designer_id', 'horas_gastas', 'data', 'descricao_atividade'];

    /**
     * O projeto ao qual este registro de horas pertence.
     */
    public function projeto()
    {
        return $this->belongsTo(Projeto::class);
    }

    /**
     * O designer que registrou as horas.
     */
    public function designer()
    {
        return $this->belongsTo(Designer::class);
    }
}