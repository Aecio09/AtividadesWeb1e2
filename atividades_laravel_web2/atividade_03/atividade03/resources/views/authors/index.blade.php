@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center my-4">
        <h1>Autores</h1>
        <a href="{{ route('authors.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Novo Autor
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(isset($authors) && $authors->isNotEmpty())
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Data de Nascimento</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($authors as $author)
                        <tr>
                            <td>{{ $author->name }}</td>
                            <td>{{ $author->birth_date ? \Carbon\Carbon::parse($author->birth_date)->format('d/m/Y') : '-' }}</td>
                            <td class="text-end">
                                <a href="{{ route('authors.edit', $author) }}" class="btn btn-sm btn-secondary">
                                    <i class="bi bi-pencil"></i> Editar
                                </a>
                                <form action="{{ route('authors.destroy', $author) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirma exclusão?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i> Excluir
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>Nenhum autor encontrado.</p>
    @endif
</div>
@endsection