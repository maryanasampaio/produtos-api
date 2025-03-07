<?php
//armazena todas as rotas relacionadas a produtos

require '../src/ProdutoController.php';

$json = file_get_contents('php://input');



function listarProdutos($pdo) { // função que será exibida na requisição get (vai receber por parametro o banco)

$stmt = $pdo->query('SELECT * FROM produtos'); //permite a manipulação. executa o comando select, para exibir todos os produtos  presentes na tabela

$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC); //converte os resultados da consulta em um array associativo, onde os nomes das colunas viram as chaves do array.

echo json_encode($produtos); //transforma o array associativo em uma string no formato JSON e imprime o resultado, que será enviado como resposta para quem fez a requisição.

}

function criarProduto($pdo) {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    if (isset($data['nome']) && isset($data['descricao']) && isset($data['preco'])) {
        // Chama o método do controller para criar o produto 
        error_log("passou aqui");
        ProdutoController::criar($pdo);  // Aqui, a lógica de criação é delegada ao controller
    } else {
        echo json_encode(['status' => 'erro', 'message' => 'Dados insuficientes']);
    }
}

function atualizarProduto($pdo) {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    if (isset($data['id']) && isset($data['nome']) && isset($data['descricao']) && isset($data['preco'])) {
        // Chama o método do controller para atualizar o produto
        ProdutoController::atualizar($pdo);
    } else {
        echo json_encode(['status' => 'erro', 'message' => 'Dados insuficientes']);
    }
}

function deletarProduto($pdo){
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    //verifica se o arquivo a ser deletado existe na tabela
    if(isset($data['id'])){
        ProdutoController::deletar($pdo);
    }else{

        echo json_encode([
        'status' => 'erro',
        'message' => 'ID do produto não informado'
        ]);
    }
}
