@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Lista de Livros</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @can('create', App\Models\Book::class)
        <a href="{{ route('books.create.id') }}" class="btn btn-success mb-3">
            <i class="bi bi-plus"></i> Adicionar Livro (Com ID)
        </a>
        <a href="{{ route('books.create.select') }}" class="btn btn-primary mb-3">
            <i class="bi bi-plus"></i> Adicionar Livro (Com Select)
        </a>
    @endcan

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Capa</th> <!-- NOVA COLUNA -->
                <th>Título</th>
                <th>Autor</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($books as $book)
                <tr>
                    <td>{{ $book->id }}</td>
                    <td>
                        @if($book->cover_image)
                            <img src="{{ asset('storage/'.$book->cover_image) }}" alt="Capa {{ $book->title }}" style="width:60px; height:auto; border:1px solid #ddd; padding:2px;">
                        @else
                            <img src="{{ asset('storage/images/default-cover.png') }}" alt="Capa padrão" style="width:60px; height:auto; border:1px solid #ddd; padding:2px;">
                        @endif
                    </td>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author->name }}</td>
                    <td>
                        <!-- Botão de Visualizar -->
                        <a href="{{ route('books.show', $book->id) }}" class="btn btn-info btn-sm">
                            <i class="bi bi-eye"></i> Visualizar
                        </a>

                        @can('update', $book)
                            <a href="{{ route('books.edit', $book->id) }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-pencil"></i> Editar
                            </a>
                        @endcan

                        @can('delete', $book)
                            <form action="{{ route('books.destroy', $book->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm" onclick="return confirm('Deseja excluir este livro?')">
                                    <i class="bi bi-trash"></i> Deletar
                                </button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Nenhum livro encontrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Controles de Paginação -->
    <div class="d-flex justify-content-center">
       {{ $books->links() }}
    </div>
</div>
@endsection