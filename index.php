<?php

require_once 'ControladoraLivro.php';
require_once 'RepositorioException.php';
require_once '../infra/concexao.php';

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
    $controladora = new ControladoraLivro( $pdo, new VisãoLivro() );
    $controladora->listar();
} else if ( $metodo == 'GET' && preg_match( $regexId, $url, $casamentos ) ) {
    [ , $id ] = $casamentos;
    $controladora = new ControladoraLivro( $pdo, new VisãoLivro() );
    $controladora->listarPorId( $id );
} else if ( $metodo == 'POST' && preg_match( $regexId, $url) ) {
    $controladora = new ControladoraLivro( $pdo, new VisãoLivro() );
    $controladora->adicionar();
} else if ( $metodo == 'PUT' && preg_match( $regexId, $url) ) {
    $controladora = new ControladoraLivro( $pdo, new VisãoLivro() );
    $controladora->atualizar();
} else if ( $metodo == 'DELETE' && preg_match( $regexId, $url, $casamentos ) ) {
    [ , $id ] = $casamentos;
    $controladora = new ControladoraLivro( $pdo, new VisãoLivro() );
    $controladora->remover( $id );
}