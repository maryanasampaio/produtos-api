<?php
// //armazena todas as rotas relacionadas a produtos

// require '../src/Controllers/ProdutoController.php';

// $json = file_get_contents('php://input');
// $data  = json_decode($json, true);



// function listarProdutos($pdo) {
//     $stmt = $pdo->query('SELECT * FROM produtos'); //executa um select na tabela produtos 
//     echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC)); // converte o retorno em json 
// }


// function criarProduto($pdo) {
//     global $data; //converte dados para um array

//     if (isset($data['nome']) && isset($data['descricao']) && isset($data['preco'])) { //garante a existencia desses campos no array
//         ProdutoController::criar($pdo, $data); // cria o produto e retorna resultado em json 
//     } else {
//         echo json_encode(['status' => 'erro', 'message' => 'Dados insuficientes']); //caso os dados não estiverem preenchidos corretamente
//     }
// }

// function atualizarProduto($pdo) {
//     global $data; //converte dados para um array

//     //verifica se os campos obirgatórios estão inseridos (devem ser igual aos da tabela)
//     if (isset($data['id']) && isset($data['nome']) && isset($data['descricao']) && isset($data['preco'])) {
//         ProdutoController::atualizar($pdo, $data); //atualiza o produto, retornando o resultado como json 
//     } else {
//         echo json_encode(['status' => 'erro', 'message' => 'Dados insuficientes']); //caso os dados não estiverem preenchidos corretamente
//     }
// }

// function deletarProduto($pdo){
//     global $data;

//     if(isset($data['id'])){
//         ProdutoController::deletar($pdo, $data['id']);
//     }else{
//         echo json_encode(['status' => 'erro', 'message' => 'Dados insuficientes']);
//     }
// }

require '../Controllers/ProdutoController.php';

class Router {
    private $routes = [];

    public function __construct() {
        $this->registerRoutes();
    }
    private function registerRoutes() {
        $controller = new ProdutoController();
        $this->routes['GET']['/produtos'] = [$controller, 'listar'];
        $this->routes['POST']['/produtos'] = [$controller, 'criar'];
    }
    public function handleRequest(string $method, string $uri) {
        header("Content-Type: application/json");
        foreach ($this->routes[$method] ?? [] as $route => $handler) {
            if (preg_match("#^$route$#", $uri)) {
                call_user_func($handler);
                return;
            }
        }
        http_response_code(404);
        echo json_encode(['erro' => 'Rota não encontrada']);
    }
}
?>