<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Livros</title>
</head>
<body>
    
    <h1>Lista de Livros</h1>        
    
    <a href="{{ route('livros.create') }}">Adicionar Novo Livro</a>
       
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Descrição</th>
            <th>Lançamento</th>
            <th>Estoque</th>
            <th>Ações</th>
        </tr>
        @foreach($livros as $livro)
        <tr>
            <td>{{ $livro->id }}</td>
            <td>{{ $livro->titulo }}</td>
            <td>{{ $livro->descricao }}</td>
            <td>{{ $livro->lancamento }}</td>
            <td>{{ $livro->estoque }}</td>
            <td>
                
                <a href="{{ route('livros.show', $livro) }}">
                    Visualizar
                </a>

                <a href="{{ route('livros.edit', $livro) }}">
                    Editar
                </a>

                <form action="{{ route('livros.destroy', $livro) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Deseja excluir este livro?')">
                        Excluir
                    </button>
                </form>

            </td>
        </tr>
        @endforeach
      
    </table>   

</body>
</html>