<?php

require_once 'src/livro/ControladoraLivro.php';
require_once 'src/livro/VisaoLivro.php';
require_once 'src/livro/RepositorioException.php';
require_once 'src/infra/conexao.php';

$pdo = null;

try {
    $pdo = criarConexao();
} catch ( PDOException $e ) {
    http_response_code( 500 );
    echo json_encode(['erro' => 'Erro na conexão com o banco']);
    exit;
}

$metodo = $_SERVER[ 'REQUEST_METHOD' ];
$url = str_replace( dirname( $_SERVER[ 'PHP_SELF' ] ),
        '',
        $_SERVER[ 'REQUEST_URI' ] );

$regex = '/^\/livros\/?$/';
$regexId = '/^\/livros\/([0-9]+)$/';
$casamentos = [];

if ( $metodo == 'GET' && preg_match( $regex, $url ) ) {
    $controladora = new ControladoraLivro( $pdo, new VisaoLivro() );
    $controladora->listar();
} else if ( $metodo == 'GET' && preg_match( $regexId, $url, $casamentos ) ) {
    [ , $id ] = $casamentos;
    $controladora = new ControladoraLivro( $pdo, new VisaoLivro() );
    $controladora->listarPorId( $id );
} else if ( $metodo == 'POST' && preg_match( $regex, $url) ) {
    $controladora = new ControladoraLivro( $pdo, new VisaoLivro() );
    $controladora->adicionar();
} else if ( $metodo == 'PUT' && preg_match( $regex, $url) ) {
    $controladora = new ControladoraLivro( $pdo, new VisaoLivro() );
    $controladora->atualizar();
} else if ( $metodo == 'DELETE' && preg_match( $regexId, $url, $casamentos ) ) {
    [ , $id ] = $casamentos;
    $controladora = new ControladoraLivro( $pdo, new VisaoLivro() );
    $controladora->remover( $id );
}