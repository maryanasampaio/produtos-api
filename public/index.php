<?php

//recebe as requisiçoes http e controla seus direcionamentos

require '../Config/config.php';//permite para o acesso ao banco/dados/tabelas
require '../src\Routing\Router.php'; //necessário para o acesso das funções de redirecionamento

$method = $_SERVER['REQUEST_METHOD']; //verifica o tipo de requisição 
$path = $_SERVER['REQUEST_URI']; //identifica o que a requisição deve fornecer (qual função/redirecionamento)

if ($path === '/produtos' && $method === 'GET') {
    listarProdutos($pdo); // Retorna todos os produtos
} elseif ($path === '/produtos' && $method === 'POST') {
    criarProduto($pdo); // Cria um novo produto
} elseif ($path === '/produtos' && $method === 'PUT') {
    atualizarProduto($pdo); // Atualiza um produto
} elseif ($path === '/produtos' && $method === 'DELETE') {
    deletarProduto($pdo); // Deleta um produto
} else {
    http_response_code(404); // Caso a rota não seja encontrada
    echo json_encode(['erro' => 'Rota não encontrada']);
}