<?php

class Livro {

    public $id = 0;
    public $autor = '';
    public $ano = 0;
    public $categoria = '';

    public function __construct( $id = 0, $autor = '', $ano = 0, $categoria = '' ) {
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

    if ( empty( $this->ano ) || ! is_numeric( $this->ano ) ) {
        $problemas[] = 'Ano inválido, deve ser um numero.';
    }

    if ( empty( $this->categoria ) ) {
        $problemas[] = 'Categoria é obrigatória.';
    }

    return $problemas;
}
}