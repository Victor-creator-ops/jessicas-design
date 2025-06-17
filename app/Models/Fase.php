<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fase extends Model
{
    use HasFactory;
    public $timestamps = false; // As fases não precisam de created_at/updated_at
    protected $fillable = ['nome', 'ordem'];

    /**
     * Uma fase pode ter muitos projetos.
     */
    public function projetos()
    {
        return $this->hasMany(Projeto::class);
    }
}