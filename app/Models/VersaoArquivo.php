<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VersaoArquivo extends Model
{
    use HasFactory;
    protected $table = 'versoes_arquivo'; // Especifica o nome da tabela
    protected $fillable = ['arquivo_id', 'user_id', 'versao', 'path_arquivo', 'descricao', 'status'];

    /**
     * O "container" de arquivo ao qual esta versão pertence.
     */
    public function arquivo()
    {
        return $this->belongsTo(Arquivo::class);
    }

    /**
     * O usuário que fez o upload desta versão.
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Os comentários feitos especificamente nesta versão.
     */
    public function comentarios()
    {
        return $this->morphMany(Comentario::class, 'comentavel');
    }
}