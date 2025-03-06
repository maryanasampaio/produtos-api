<?php

//recebe as requisiçoes http e controla seus direcionamentos

require '../config.php'; //permite para o acesso ao banco/dados/tabelas
require '../routes/produtos.php'; //necessário para o acesso das funções de redirecionamento

$method = $_SERVER['REQUEST_METHOD']; //verifica o tipo de requisição 
$path = $_SERVER['REQUEST_URI']; //identifica o que a requisição deve fornecer (qual função/redirecionamento)

if ($path === '/produtos' && $method === 'GET') {  //verifica se é para buscar todos os produtos

listarProdutos($pdo); //chama a função que retorna a lista de produtos (acessivel após a importação de routes)

} elseif ($path === '/produtos' && $method === 'POST') { //verfica se é para criar um novo produto

// criarProduto($pdo); //chama função que cria um novo produto no banco 
}else {

http_response_code(404);  // caso não haja nenhuma requisição, exibir erro do cliente 

echo json_encode(['erro' => 'Rota não encontrada']);

}
