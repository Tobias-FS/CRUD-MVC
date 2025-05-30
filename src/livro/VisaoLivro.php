<?php

class VisaoLivro {

    public function obterdados() {
        $dadosJson = file_get_contents( 'php://input' );
        $arrayDados = (array) json_decode( $dadosJson );

        if ( empty( $arrayDados ) ) {
            $this->exibirMensagemErro( 'Dados nulos', $codigo = 400 );
        }

        return $arrayDados;
    }

    public function exibirMensagemErro( $mensagem, $codigo = 400 ) {
        http_response_code( $codigo );
        header( 'Content-Type: application/json' );
        echo json_encode( [ 'erro' => $mensagem ] );
        exit;
    }

    public function exibirMensagem( $mensagem, $codigo = 200 ) {
        http_response_code( $codigo );
        header( 'Content-Type: application/json' );
        echo json_encode( [ 'mensagem' => $mensagem ] );
        exit; 
    }
}