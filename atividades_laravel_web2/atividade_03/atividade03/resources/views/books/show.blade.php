@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Detalhes do Livro</h1>

    <div class="card">
        <div class="card-header">
            <strong>Título:</strong> {{ $book->title }}
        </div>
        <div class="card-body">
            <!-- Exibir imagem da capa (se existir) -->
            @if($book->cover_image)
                <div class="mb-3">
                    <img src="{{ asset('storage/'.$book->cover_image) }}" alt="Capa de {{ $book->title }}" style="max-width:300px; height:auto; border:1px solid #ddd; padding:4px;">
                </div>
                @else
                    <img src="{{ asset('storage/images/default-cover.png') }}" alt="Capa padrão" style="width:60px; height:auto; border:1px solid #ddd; padding:2px;">
            @endif

            <p><strong>Autor:</strong>
                <a href="{{ route('authors.show', $book->author->id) }}">
                    {{ $book->author->name }}
                </a>
            </p>
            <p><strong>Editora:</strong>
                <a href="{{ route('publishers.show', $book->publisher->id) }}">
                    {{ $book->publisher->name }}
                </a>
            </p>
            <p><strong>Categoria:</strong>
                <a href="{{ route('categories.show', $book->category->id) }}">
                    {{ $book->category->name }}
                </a>
            </p>
        </div>
    </div>

    <a href="{{ route('books.index') }}" class="btn btn-secondary mt-3">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>

    @can('update', $book)
        <a href="{{ route('books.edit', $book) }}" class="btn btn-primary mt-3">
            <i class="bi bi-pencil"></i> Editar
        </a>
    @endcan

@can('create', App\Models\Book::class)
<!-- Formulário para Empréstimos -->
<div class="card mb-4">
    <div class="card-header">Registrar Empréstimo</div>
    <div class="card-body">
        <form action="{{ route('books.borrow', $book) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="user_id" class="form-label">Usuário</label>
                <select class="form-select" id="user_id" name="user_id" required>
                    <option value="" selected>Selecione um usuário</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success">Registrar Empréstimo</button>
        </form>
    </div>
</div>
@endcan

<!-- Histórico de Empréstimos -->
<div class="card">
    <div class="card-header">Histórico de Empréstimos</div>
    <div class="card-body">
        @if($book->users->isEmpty())
            <p>Nenhum empréstimo registrado.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Usuário</th>
                        <th>Data de Empréstimo</th>
                        <th>Data de Devolução</th>
                        @can('create', App\Models\Book::class)
                            <th>Ações</th>
                        @endcan
                    </tr>
                </thead>
                <tbody>
    @foreach($book->users as $user)
        <tr>
            <td>
                <a href="{{ route('users.show', $user->id) }}">
                    {{ $user->name }}
                </a>
            </td>
            <td>{{ $user->pivot->borrowed_at }}</td>
            <td>{{ $user->pivot->returned_at ?? 'Em Aberto' }}</td>
            @can('create', App\Models\Book::class)
                <td>
                    @if(is_null($user->pivot->returned_at))
                        <form action="{{ route('borrowings.return', $user->pivot->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-warning btn-sm">Devolver</button>
                        </form>
                    @endif
                </td>
            @endcan
        </tr>
    @endforeach
</tbody>
            </table>
        @endif
    </div>
</div>

</div>
@endsection

