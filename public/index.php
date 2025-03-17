<?php
require_once '../config/DatabaseConfig.php';
require_once '../src/Services/ProdutoService.php';
require_once '../src/Controllers/ProdutoController.php';
require_once '../src/Routing/Router.php';

use Src\Routing\Router;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Content-Type: application/json");

$router = new Router();
$router->handleRequest($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
?>
