<?php

// Este arquivo define o modelo de Arquivo, que representa um conjunto de arquivos enviados para um projeto. 
// Aqui ficam as informações e regras sobre os arquivos dos projetos. 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arquivo extends Model
{
    use HasFactory; // Permite criar arquivos de teste facilmente 
    // Lista de informações que podem ser preenchidas de uma vez só ao criar ou editar um arquivo 
    protected $fillable = ['projeto_id', 'fase_id', 'nome_conceitual'];

    /** 
     * O projeto ao qual o arquivo pertence. 
     * Ou seja, cada arquivo está ligado a um projeto. 
     */
    public function projeto()
    {
        return $this->belongsTo(Projeto::class);
    }

    /** 
     * A fase à qual o arquivo pertence. 
     * Exemplo: planejamento, execução, etc. 
     */
    public function fase()
    {
        return $this->belongsTo(Fase::class);
    }

    /** 
     * Todas as versões deste arquivo, da mais nova para a mais antiga. 
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
