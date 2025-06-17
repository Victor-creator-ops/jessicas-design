<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogAtividade extends Model
{
    use HasFactory;
    protected $table = 'logs_atividade'; // Especifica o nome da tabela
    protected $fillable = ['user_id', 'descricao'];

    /**
     * O usuário que realizou a ação.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}