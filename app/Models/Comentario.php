<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'conteudo', 'comentavel_id', 'comentavel_type'];

    /**
     * O usuário que escreveu o comentário.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtém o modelo pai que foi comentado (Projeto ou VersaoArquivo).
     */
    public function comentavel()
    {
        return $this->morphTo();
    }
}