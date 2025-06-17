<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projeto extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'descricao', 'cliente_id', 'fase_id', 'modalidade_cobranca', 'valor_contrato', 'data_inicio', 'cor_tema', 'status', 'area_m2', 'pacote_horas'];

    /**
     * Um projeto pertence a um Cliente.
     */
    public function cliente(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Um projeto pertence a uma Fase atual.
     */
    public function faseAtual()
    {
        return $this->belongsTo(Fase::class, 'fase_id');
    }

    /**
     * Um projeto pode ter vários Designers.
     */
    public function designers()
    {
        return $this->belongsToMany(Designer::class, 'designer_projeto');
    }

    /**
     * Um projeto possui vários "containers" de Arquivos.
     */
    public function arquivos()
    {
        return $this->hasMany(Arquivo::class);
    }

    /**
     * Um projeto pode ter vários Comentários.
     */
    public function comentarios()
    {
        return $this->morphMany(Comentario::class, 'comentavel');
    }

    /**
     * Um projeto possui vários Registros de Horas.
     */
    public function registrosHoras()
    {
        return $this->hasMany(RegistroHoras::class);
    }
}