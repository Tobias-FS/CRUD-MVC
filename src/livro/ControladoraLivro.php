<?php

require_once 'Livro.php';
require_once 'RepositorioException.php';
require_once 'RepositorioLivroEmBDR.php';

class ControladoraLivro {

    private $repositorio = null;
    private $visao = null;

    public function __construct( PDO $pdo, VisaoLivro $visao ) {
        $this->respositorio = new RepositorioLivroEmBDR( $pdo );
        $this->visao = $visao;
    }

    public function listar() {
        try {
            $produtos = $this->repositorio->listarTodos();
            $this->visao->exibirMensagem( $produtos, 200 );
        } catch ( RepositorioException $e  ) {
            $this->visao->exibirMensagemErro( $e->getMessage(), 400 );
        }
    }

    public function listarPorId( int $id ) {
        try {
            $produto = $this->repositorio->obterLivroPorId( $id );
            $this->visao->exibirMensagem( $produto, 200 );
        } catch ( RepositorioException $e  ) {
            $this->visao->exibirMensagemErro( $e->getMessage(), 400 );
        }
    }

    public function adicionar() {
        $dados = $this->visão->obterdados();
        $livro = new Livro( 
            0,
            $dados[ 'autor' ],
            $dados[ 'ano' ],
            $dados[ 'categoria' ]
        );

        $problemas = $livro->validar();

        if ( count( $problemas ) > 0 ) {
            $this->visao->exibirMensagemErro( $problemas, 400 );
            return;
        }

        try {
            $this->repositorio->cadastrarLivro( $livro );
            $this->visao->exibirMensagem( 'Livro adicionado com sucesso', 201 );
        } catch ( RepositorioException $e  ) {
            $this->visao->exibirMensagemErro( $e->getMessage(), 400 );
        }
    }

    public function atualizar() {
        $dados = $this->visao->obterdados();
        $livro = new Livro( 
            $dados[ 'id' ],
            $dados[ 'autor' ],
            $dados[ 'ano' ],
            $dados[ 'categoria' ]
        );

        $problemas = $livro->validar();
        if ( count( $problemas ) > 0 ) {
            $this->visao->exibirMensagemErro( $problemas, 400 );
            return;
        }

        try {
            $this->repositorio->atualizarLivro( $livro );
            $this->visao->exibirMensagem( 'Livro atualizado com sucesso', 200 );
        } catch ( RepositorioException $e  ) {
            $this->visao->exibirMensagemErro( $e->getMessage(), 400 );
        }
    }

    function remover( int $id ) {
        try {
            $this->repositorio->removerLivro( $id );
            $this->visao->exibirMensagem( 'Livro removido com sucesso', 200 );
        } catch ( RepositorioException $e  ) {
            $this->visao->exibirMensagemErro( $e->getMessage(), 400 );
        }
    }
}