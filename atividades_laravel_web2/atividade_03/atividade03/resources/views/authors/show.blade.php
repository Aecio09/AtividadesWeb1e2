@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center my-4">
        <h1>Detalhes do Autor</h1>
        <div>
            <a href="{{ route('authors.edit', $author) }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-pencil"></i> Editar
            </a>
            <a href="{{ route('authors.index') }}" class="btn btn-sm btn-secondary">
                <i class="bi bi-arrow-left"></i> Voltar
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title mb-3">{{ $author->name }}</h4>

            <p><strong>Data de Nascimento:</strong><br>
                @if($author->birth_date)
                    {{ \Carbon\Carbon::parse($author->birth_date)->format('d/m/Y') }}
                @else
                    -
                @endif
            </p>

            <div class="mt-3 text-muted">
                <small>Criado em: {{ optional($author->created_at)->format('d/m/Y H:i') ?? '-' }}</small><br>
                <small>Atualizado em: {{ optional($author->updated_at)->format('d/m/Y H:i') ?? '-' }}</small>
            </div>
        </div>
    </div>
</div>
@endsection