<?php

class Livro {

    public $id = 0;
    public $autor = '';
    public $ano = '';
    public $categoria = '';

    public function __construct( $id = 0, $autor = '', $ano = '', $categoria = '' ) {
        $this->id = $id;
        $this->autor = $autor;
        $this->ano = $ano;
        $this->categoria = $categoria;
    }

    public function validar() {
    $problemas = [];

    if ( empty( $this->autor ) ) {
        $problemas[] = 'Autor é obrigatório.';
    }

    if ( empty( $this->ano) || ! preg_match('/^\d{4}$/', $this->ano ) ) {
        $problemas[] = 'Ano inválido. Use o formato AAAA.';
    }

    if ( empty( $this->categoria ) ) {
        $problemas[] = 'Categoria é obrigatória.';
    }

    return $problemas;
}
}