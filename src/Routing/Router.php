<?php
namespace Src\Routing; // Definindo o namespace Src\Routing

use Src\Controllers\ProdutoController;

class Router {
    private $routes = [];

    public function __construct() {
        $this->registerRoutes();
    }

    private function registerRoutes() {
        $controller = new ProdutoController();

        $this->routes['GET']['/produtos'] = [$controller, 'listar'];
        $this->routes['POST']['/produtos'] = [$controller, 'criar'];
        $this->routes['PUT']['/produtos/(\d+)'] = [$controller, 'atualizar'];
        $this->routes['DELETE']['/produtos/(\d+)'] = [$controller, 'excluir'];
    }

    public function handleRequest(string $method, string $uri) {
        header("Content-Type: application/json");
    
        foreach ($this->routes[$method] ?? [] as $route => $handler) {
            if (preg_match("#^$route$#", $uri, $matches)) {
                array_shift($matches); // Remove o primeiro item que é a string completa da correspondência
    
                // Se a requisição for PUT ou DELETE, passar o ID extraído corretamente
                if ($method === 'PUT' || $method === 'DELETE') {
                    call_user_func($handler, ...$matches);
                } else {
                    call_user_func($handler);
                }
                return;
            }
        }
    
        http_response_code(404);
        echo json_encode(['erro' => 'Rota não encontrada']);
    }
    
}
?>
