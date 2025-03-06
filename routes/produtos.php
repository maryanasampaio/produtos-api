<?php
//armazena todas as rotas relacionadas a produtos

require '../src/ProdutoController.php';

function listarProdutos($pdo) { // função que será exibida na requisição get (vai receber por parametro o banco)

$stmt = $pdo->query('SELECT * FROM produtos'); //permite a manipulação. executa o comando select, para exibir todos os produtos  presentes na tabela

$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC); //converte os resultados da consulta em um array associativo, onde os nomes das colunas viram as chaves do array.

echo json_encode($produtos); //transforma o array associativo em uma string no formato JSON e imprime o resultado, que será enviado como resposta para quem fez a requisição.

}

// function criarProduto($pdo){
     
//     $stmt = $pdo->query('INSERT into produtos');
    
//     $produtos = $stmt->fetch
// }