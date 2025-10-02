<body>
    <h1 class="my-4">Adicionar livro</h1>
    <form action="{{ route('livros.store') }}" method="POST">
        @csrf
        <div>
            <label for="titulo">Nome do livro</label> 
            <input type="text" id="titulo" name="titulo" required> 
        </div> 
        <div>
            <label for="descricao">Descrição do livro:</label>
            <input type="text" id="descricao" name="descricao" required>            
        </div>

        <div>
            <label for="lancamento">Lançamento:</label>
            <input type="date" id="lancamento" name="lancamento" required>            
        </div>

        <div>
            <label for="estoque">Estoque:</label>
            <input type="number" id="estoque" name="estoque" required>            
        </div>

        <button type="submit" class="btn btn-success">
            <i class="bi bi-save"></i> Salvar
        </button>
        
    </form>
</body>