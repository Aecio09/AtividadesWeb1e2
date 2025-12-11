<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Aluno;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Curso extends Model
{
    protected $fillable = ['nome', 'descricao'];

    function alunos()
    {
        return $this->belongsToMany(Aluno::class, 'cursos_alunos', 'curso_id', 'aluno_id')->withTimestamps();
    }
}
