<?php

class ControladoraLivro {

    private $repositorio = null;
    private $visao = null;

    public function __construct( PDO $pdo, VisaoLivro $visao ) {
        $this->repositorio = new RepositorioLivroEmBDR( $pdo );
        $this->visao = $visao;
    }

    public function listar() {
        try {
            $produtos = $this->repositorio->listarTodos();
            return $this->visao->exibirMensagem( $produtos, 200 );
        } catch ( RepositorioException $e  ) {
            return $this->visao->exibirMensagemErro( $e->getMessage(), 400 );
        }
    }

    public function listarPorId( int $id ) {
        try {
            $produto = $this->repositorio->obterLivroPorId( $id );
            return $this->visao->exibirMensagem( $produto, 200 );
        } catch ( RepositorioException $e  ) {
            return $this->visao->exibirMensagemErro( $e->getMessage(), 400 );
        }
    }

    public function adicionar() {
        $dados = $this->visao->obterdados();
        $livro = new Livro( 
            0,
            $dados[ 'autor' ],
            (int) $dados[ 'ano' ],
            $dados[ 'categoria' ]
        );

        $problemas = $livro->validar();

        if ( count( $problemas ) > 0 ) {
            return $this->visao->exibirMensagemErro( $problemas, 400 );
        }

        try {
            $this->repositorio->cadastrarLivro( $livro );
            return $this->visao->exibirMensagem( 'Livro adicionado com sucesso', 201 );
        } catch ( RepositorioException $e  ) {
            return $this->visao->exibirMensagemErro( $e->getMessage(), 400 );
        }
    }

    public function atualizar() {
        $dados = $this->visao->obterdados();
        $livro = new Livro( 
            (int) $dados[ 'id' ],
            $dados[ 'autor' ],
            (int) $dados[ 'ano' ],
            $dados[ 'categoria' ]
        );

        $problemas = $livro->validar();
        if ( count( $problemas ) > 0 ) {
            return $this->visao->exibirMensagemErro( $problemas, 400 );
        }

        try {
            $this->repositorio->atualizarLivro( $livro );
            return $this->visao->exibirMensagem( 'Livro atualizado com sucesso', 200 );
        } catch ( RepositorioException $e  ) {
            return $this->visao->exibirMensagemErro( $e->getMessage(), 400 );
        }
    }

    function remover( int $id ) {
        try {
            $this->repositorio->removerLivro( $id );
            return $this->visao->exibirMensagem( 'Livro removido com sucesso', 200 );
        } catch ( RepositorioException $e  ) {
            return $this->visao->exibirMensagemErro( $e->getMessage(), 400 );
        }
    }
}