<?php

require_once 'Livro.php';

interface RepositorioLivro {

    /**
     * Retorna todos os Livros
     * 
     * @return Livro[]
     * @throws RepositorioException
     */
    function listarTodos(): array;

    /**
     * Retorna um livro especifico
     * 
     * @param int $id
     * @return $livro Livro
     * @throws RepositorioException
     */
    function obterLivroPorId( int $id ): Livro; 

    /**
     * Adiciona um Livro
     * 
     * @param Livro $livro
     * @throws RepositorioException
     */
    function cadastrarLivro( Livro $livro ): void;

    /**
     * Atualiza um livro
     * 
     * @param Livro $livro
     * @throws RepositorioException
     */
    function atualizarLivro( Livro $livro ): void;

    /**
     * Remove um livro
     * 
     * @param int $id
     * @throws RepositorioException
     */
    function removerLivro( int $id ): void;
}