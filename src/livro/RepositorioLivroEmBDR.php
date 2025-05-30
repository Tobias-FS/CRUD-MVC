<?php

require_once 'Livo.php';
require_once 'RepositorioLivro.php';
require_once 'RepositorioException.php';

class RepositorioLivroEmBDR implements RepositorioLivro {

    private $pdo = null;

    public function __construct( PDO $pdo ) {
        $this->pdo = $pdo;
    }

    public function listarTodos(): array {
        $livros = [];
        try {
            $sql = 'SELECT id, autor, ano, categoria FROM livro';
            $ps = $this->pdo->prepare( $sql );
            $ps->execute();
            $dados = $ps->fetchAll( PDO::FETCH_ASSOC );

            foreach ( $dados as $d ) {
                $livros []= new Livro (
                    $d[ 'id' ],
                    $d[ 'autor' ],
                    $d[ 'ano' ],
                    $d[ 'categoria' ]
                );
            }
        } catch( PDOException $e ) {
            throw new RepositorioException( 'Erro ao listar livros', $e->getCode(), $e );
        }

        return $livros;
    }

    public function obterLivroPorId( int $id ): Livro {
        try {
            $sql = 'SELECT id, autor, ano, categoria FROM livro WHERE id = :id';
            $ps = $this->pdo->prepare( $sql );
            $ps->execute( [ 'id' => $id ] );
            $livro = $ps->fetch( PDO::FETCH_ASSOC );

            return new Livro( 
                $livro[ 'id' ], 
                $livro[ 'autor'], 
                $livro[ 'ano' ],
                $livro[ 'categoria' ] );
        } catch ( PDOException $e ) {
            throw new RepositorioException( 'Erro ao obter livro', $e->getCode(), $e );
        }
    }

    function cadastrarLivro( Livro $livro ): void {
        try {
            $sql = 'INSERT INTO livro ( autor, ano, categoria ) VALUES ( :autor, :ano, :categoria )';
            $ps = $this->pdo->prepare( $sql );
            $ps->execute( [
                'autor' => $livro->autor,
                'ano' => $livro->ano,
                'categoria' => $livro->categoria
            ] );
        } catch ( PDOException $e ) {
            throw new RepositorioException( 'Erro ao cadastrar livro', $e->getCode(), $e );
        }
    }

    function atualizarLivro( Livro $livro ): void {
        try {
            $sql = 'UPDATE livro SET autor = :autor, ano = :ano, categoria = :categoria WHERE id = :id';
            $ps = $this->pdo->prepare( $sql );
            $ps->execute( [
                'id' => $livro->id,
                'autor' => $livro->autor,
                'ano' => $livro->ano,
                'categoria' => $livro->categoria
            ] );
        } catch ( PDOException $e ) {
            throw new RepositorioException( 'Erro ao atualizar livro', $e->getCode(), $e );
        }
    }

    function removerLivro( int $id ): void {
        try {
            $sql = 'DELETE FROM livro WHERE id = :id';
            $ps = $this->pdo->prepare( $sql );
            $ps->execute( [ 'id' => $id ] );
        } catch ( PDOException $e ) {
            throw new RepositorioException( 'Erro ao remover livro', $e->getCode(), $e );
        }
    }
}