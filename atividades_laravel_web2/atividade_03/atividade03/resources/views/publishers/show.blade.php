@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center my-4">
        <h1>Detalhes da Editora</h1>
        <div>
            @can('update', $publisher)
                <a href="{{ route('publishers.edit', $publisher) }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-pencil"></i> Editar
                </a>
            @endcan
            <a href="{{ route('publishers.index') }}" class="btn btn-sm btn-secondary">
                <i class="bi bi-arrow-left"></i> Voltar
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h4 class="card-title mb-3">{{ $publisher->name }}</h4>

            <p><strong>Endereço:</strong><br>
                @if($publisher->address)
                    {!! nl2br(e($publisher->address)) !!}
                @else
                    -
                @endif
            </p>

            <div class="mt-3 text-muted">
                <small>Criado em: {{ optional($publisher->created_at)->format('d/m/Y H:i') ?? '-' }}</small><br>
                <small>Atualizado em: {{ optional($publisher->updated_at)->format('d/m/Y H:i') ?? '-' }}</small>
            </div>
        </div>
    </div>
</div>
@endsection