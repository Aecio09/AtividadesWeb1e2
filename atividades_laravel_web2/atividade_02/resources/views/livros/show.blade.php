<head></head>
<body>
    
    <h1>Detalhes do Livro</h1>        
        <div>
            <p><strong>ID:</strong> {{ $livro->id }}</p>
            <p><strong>Título:</strong> {{ $livro->titulo }}</p>
            <p><strong>Descrição:</strong> {{ $livro->descricao }}</p>
            <p><strong>Lançamento:</strong> {{ $livro->lancamento }}</p>
            <p><strong>Estoque:</strong> {{ $livro->estoque }}</p>
        </div>
        
        <div style="margin-top: 20px;">
            <a href="{{ route('livros.index') }}" class="btn btn-secondary">Voltar</a>
            <a href="{{ route('livros.edit', $livro->id) }}" class="btn btn-primary">Editar</a>
        </div>
</body>