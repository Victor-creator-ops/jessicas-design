<?php

// Este arquivo define o modelo de Fase, que representa as etapas de um projeto (Ex.: planejamento, execução, finalização)
// Aqui ficam as informações e regas sobre as fases dos projetos
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Fase extends Model
{
    use HasFactory; // Permite criar fases de teste facilmente
    public $timestamps = false; // Não precisa guardar datas de criação/ atualização para fases
    // Lista de informações que podem ser preenchidas de uma vez só ao criar ou editar uma fase
    protected $fillable = ['nome','ordem'];

    
    /**
    * Uma fase pode ter muitos projetos ligados a ela
    */
    public function projetos()
    {
        return $this->hasMany(Projeto::class);
    }
}
