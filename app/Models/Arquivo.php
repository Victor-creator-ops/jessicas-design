<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arquivo extends Model
{
    use HasFactory;
    protected $fillable = ['projeto_id', 'fase_id', 'nome_conceitual'];

    /**
     * O projeto ao qual o arquivo pertence.
     */
    public function projeto()
    {
        return $this->belongsTo(Projeto::class);
    }

    /**
     * A fase à qual o arquivo pertence.
     */
    public function fase()
    {
        return $this->belongsTo(Fase::class);
    }

    /**
     * Todas as versões deste arquivo, ordenadas da mais nova para a mais antiga.
     */
    public function versoes()
    {
        return $this->hasMany(VersaoArquivo::class)->orderBy('versao', 'desc');
    }

    /**
     * A versão mais recente deste arquivo.
     */
    public function ultimaVersao()
    {
        return $this->hasOne(VersaoArquivo::class)->latest('versao');
    }
}