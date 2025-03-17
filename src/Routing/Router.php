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
        $this->routes['PUT']['/produtos'] = [$controller, 'atualizar'];
        $this->routes['DELETE']['/produtos'] = [$controller, 'excluir'];
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
