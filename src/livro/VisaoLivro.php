<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class VisaoLivro {

    private $request;
    private $response;

    public function __construct( Request $request, Response $response ) {
        $this->request = $request;
        $this->response = $response;
    }

    public function obterdados() {
        $dados = json_decode( $this->request->getBody()->getContents(), true );

        if ( empty( $dados ) ) {
            $this->exibirMensagemErro( 'Dados nulos', 400 );
        }

        return $dados;
    }

    public function exibirMensagemErro( $mensagem, $codigo = 400 ) {
        $this->response = $this->response->withStatus( $codigo )
                        ->withHeader( 'Content-type', 'application/json' );
        $this->response->getBody()->write( json_encode( [ 'erro' => $mensagem ] ) );
        return $this->response;
    }

    public function exibirMensagem( $mensagem, $codigo = 200 ): Response {
        $this->response = $this->response->withStatus( $codigo )
                        ->withHeader( 'Content-type', 'application/json' );
        $this->response->getBody()->write( json_encode( $mensagem ) );
        return $this->response;
    }
}