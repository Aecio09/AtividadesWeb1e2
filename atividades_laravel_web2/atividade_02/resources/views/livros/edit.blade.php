<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Livro</title>
</head>
<body>
    <h1>Editar Livro</h1>

    <form action="{{ route('livros.update', $livro) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div>
            <label for="titulo">Título do livro:</label>
            <input type="text" id="titulo" name="titulo" value="{{ $livro->titulo }}" required>            
        </div>
        
        <div>
            <label for="descricao">Descrição do livro:</label>
            <input type="text" id="descricao" name="descricao" value="{{ $livro->descricao }}" required>            
        </div>

        <div>
            <label for="lancamento">Data de lançamento:</label>
            <input type="date" id="lancamento" name="lancamento" value="{{ $livro->lancamento }}" required>            
        </div>

        <div>
            <label for="estoque">Estoque:</label>
            <input type="number" id="estoque" name="estoque" value="{{ $livro->estoque }}" required>            
        </div>

        <div>
            <a href="{{ route('livros.index') }}">Cancelar</a>
            <button type="submit">Atualizar Livro</button>
        </div>
        
    </form>
</body>
</html>