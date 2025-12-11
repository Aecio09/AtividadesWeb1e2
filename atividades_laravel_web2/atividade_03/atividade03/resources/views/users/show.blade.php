@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Detalhes do Usuário</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            {{ $user->name }}
        </div>
        <div class="card-body">
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Papel:</strong> 
                <span class="badge bg-secondary">{{ ucfirst($user->role ?? 'cliente') }}</span>
            </p>
            <p><strong>Débito:</strong> 
                @if($user->debit > 0)
                    <span class="badge bg-danger">R$ {{ number_format($user->debit, 2, ',', '.') }}</span>
                    @can('update', $user)
                        <form action="{{ route('users.clearDebit', $user) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success btn-sm ms-2" 
                                    onclick="return confirm('Confirma a quitação do débito?')">
                                <i class="bi bi-check-circle"></i> Quitar
                            </button>
                        </form>
                    @endcan
                @else
                    <span class="badge bg-success">Sem débitos</span>
                @endif
            </p>
        </div>
    </div>

    <a href="{{ route('users.index') }}" class="btn btn-secondary mt-3">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>
<div class="card">
    <div class="card-header">Histórico de Empréstimos</div>
    <div class="card-body">
        @if($user->books->isEmpty())
            <p>Este usuário não possui empréstimos registrados.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Livro</th>
                        <th>Data de Empréstimo</th>
                        <th>Data de Devolução</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
    @foreach($user->books as $book)
        <tr>
            <td>
                <a href="{{ route('books.show', $book->id) }}">
                    {{ $book->title }}
                </a>
            </td>
            <td>{{ \Carbon\Carbon::parse($book->pivot->borrowed_at)->format('d/m/Y H:i') }}</td>
            <td>
                @if($book->pivot->returned_at)
                    {{ \Carbon\Carbon::parse($book->pivot->returned_at)->format('d/m/Y H:i') }}
                @else
                    <span class="badge bg-warning text-dark">Em Aberto</span>
                @endif
            </td>
            <td>
                @if(is_null($book->pivot->returned_at))
                    <form action="{{ route('borrowings.return', $book->pivot->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button class="btn btn-warning btn-sm">Devolver</button>
                    </form>
                @endif
            </td>
        </tr>
    @endforeach
</tbody>


            </table>
        @endif
    </div>
</div>

@if(auth()->user() && auth()->user()->role === 'admin')
    <div class="mb-3">
        <label for="role" class="form-label">Papel</label>
        <select name="role" id="role" class="form-select">
            <option value="cliente" {{ $user->role === 'cliente' ? 'selected' : '' }}>cliente</option>
            <option value="bibliotecario" {{ $user->role === 'bibliotecario' ? 'selected' : '' }}>bibliotecario</option>
            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>admin</option>
        </select>
    </div>
@endif

</div>
@endsection

