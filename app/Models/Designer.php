<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designer extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'cargo', 'foto_perfil_path', 'custo_hora'];

    /**
     * Um perfil de Designer pertence a um Usuário.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Um Designer pode estar associado a vários Projetos.
     */
    public function projetos()
    {
        return $this->belongsToMany(Projeto::class, 'designer_projeto');
    }

    /**
     * Um Designer pode ter vários registros de horas.
     */
    public function registrosHoras()
    {
        return $this->hasMany(RegistroHoras::class);
    }
}