<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require_once __DIR__ . '/vendor/autoload.php';

$pdo = null;

try {
    $pdo = criarConexao();
} catch ( PDOException $e ) {
    http_response_code( 500 );
    echo json_encode(['erro' => 'Erro na conexão com o banco']);
    exit;
}

$app = AppFactory::create();

$app->get( '/livros', function (Request $request, Response $response, array $args ) use ( $pdo ) {
    $controladora = new ControladoraLivro( $pdo, new VisaoLivro( $request, $response ) );
    $response = $controladora->listar();
    return $response;
});
$app->get( '/livros/{id}', function (Request $request, Response $response, array $args ) use ( $pdo ) {
    $controladora = new ControladoraLivro( $pdo, new VisaoLivro( $request, $response ) );
    $response = $controladora->listarPorId( $args[ 'id' ] );
    return $response;
});
$app->post( '/livros', function ($request, $response, array $args ) use ( $pdo ) {
    $controladora = new ControladoraLivro( $pdo, new VisaoLivro( $request, $response ) );
    $response = $controladora->adicionar();
    return $response;
});
$app->put( '/livros', function ( $request, $response, array $args ) use ( $pdo ) {
    $controladora = new ControladoraLivro( $pdo, new VisaoLivro( $request, $response ) );
    $response = $controladora->atualizar();
    return $response;
});
$app->delete( '/livros/{id}', function ($request, $response, array $args ) use ( $pdo ) {
    $controladora = new ControladoraLivro( $pdo, new VisaoLivro( $request, $response ) );
    $response = $controladora->remover( $args[ 'id' ] );
    return $response;
});

$app->run();