@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center my-4">
        <h1>Editora</h1>
        @can('create', App\Models\Publisher::class)
            <a href="{{ route('publishers.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Nova Editora
            </a>
        @endcan
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(isset($publishers) && $publishers->isNotEmpty())
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Endereço</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($publishers as $publisher)
                        <tr>
                            <td>{{ $publisher->name }}</td>
                            <td>{{ $publisher->address ?? '-' }}</td>
                            <td class="text-end">
                                <a href="{{ route('publishers.show', $publisher) }}" class="btn btn-info btn-sm">
                                    <i class="bi bi-eye"></i> Visualizar
                                </a>

                                @can('update', $publisher)
                                    <a href="{{ route('publishers.edit', $publisher) }}" class="btn btn-sm btn-secondary">
                                        <i class="bi bi-pencil"></i> Editar
                                    </a>
                                @endcan

                                @can('delete', $publisher)
                                    <form action="{{ route('publishers.destroy', $publisher) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirma exclusão?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="bi bi-trash"></i> Excluir
                                        </button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p>Nenhuma editora encontrada.</p>
    @endif
</div>
@endsection