<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Curso;
use App\Models\Aluno;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cursos = Curso::with('alunos')->get();
        return view('cursos.index', compact('cursos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $alunos = Aluno::all();
        return view('cursos.create', compact('alunos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $curso = Curso::create($request->only('nome', 'descricao'));
        $curso->alunos()->attach($request->input('alunos', []));
        return redirect()->route('cursos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Curso $curso)
    {
        $curso->load('alunos');
        return view('cursos.show', compact('curso'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Curso $curso)
    {
        $alunos = Aluno::all();
        $curso->load('alunos');
        return view('cursos.edit', compact('curso', 'alunos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Curso $curso)
    {
        $curso->update($request->only('nome', 'descricao'));
        $curso->alunos()->sync($request->input('alunos', []));
        return redirect()->route('cursos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Curso $curso)
    {
        $curso->delete();
        return redirect()->route('cursos.index');
    }
}
