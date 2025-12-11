<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Curso;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Aluno extends Model
{
    protected $fillable = ['nome', 'idade'];

    function cursos()
    {
        return $this->belongsToMany(Curso::class, 'cursos_alunos', 'aluno_id', 'curso_id')->withTimestamps();
    }
}
