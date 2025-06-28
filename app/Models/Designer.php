<?php
// Define o modelo de Designer, que representa o profissional responsável por criar os projetos.
// Informações e regras sobre os designers.
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Designer extends Model
{
use HasFactory; // Permite criar funcionarios designers de teste facilmente
// Lista de informações que podem ser preenchidas de uma vez só ao criar ou editar um designer
protected $fillable = ['user_id', 'cargo', 'foto_perfil_path', 'custo_hora'];
/**
* Um perfil de Designer pertence a um Usuário.
* Cada designer está ligado a um usuário do sistema.
*/
//Vai Corinthians
public function projetos()
{
return $this->belongsToMany(Projeto::class, 'designer_projeto');
}
/**
* Um Designer pode ter vários registros de horas trabalhadas.
*/
public function registrosHoras()
{
return $this->hasMany(RegistroHoras::class);
}
/**
* Um Designer pode estar associado a vários Projetos.
* Pode trabalhar em vários projetos diferentes.
*/
public function user()
{
return $this->belongsTo(User::class);
}
}