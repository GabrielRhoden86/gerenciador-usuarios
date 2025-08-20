<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    protected $fillable = [
        'nome',
        'cpf',
        'data_nascimento',
        'turma',
        'status',
    ];

}
