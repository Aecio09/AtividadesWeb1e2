@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Usuários com Débitos</h1>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Voltar para Usuários
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($usersWithDebits->isEmpty())
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> Nenhum usuário com débitos pendentes.
        </div>
    @else
        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Débito</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($usersWithDebits as $user)
                            <tr>
                                <td>
                                    <a href="{{ route('users.show', $user) }}">
                                        {{ $user->name }}
                                    </a>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge bg-danger">
                                        R$ {{ number_format($user->debit, 2, ',', '.') }}
                                    </span>
                                </td>
                                <td>
                                    @can('update', $user)
                                        <form action="{{ route('users.clearDebit', $user) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-success btn-sm" 
                                                    onclick="return confirm('Confirma o pagamento e a quitação do débito de {{ $user->name }}?')">
                                                <i class="bi bi-check-circle"></i> Quitar Débito
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-3">
            <strong>Total de usuários com débito:</strong> {{ $usersWithDebits->count() }}
            <br>
            <strong>Valor total em débitos:</strong> R$ {{ number_format($usersWithDebits->sum('debit'), 2, ',', '.') }}
        </div>
    @endif
</div>
@endsection
