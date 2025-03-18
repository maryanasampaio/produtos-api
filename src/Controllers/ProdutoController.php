<?php
namespace Src\Controllers; 

use Src\Services\ProdutoService;
use Config\DatabaseConfig;

class ProdutoController {
    private $service;

    public function __construct() {
        $config = new DatabaseConfig();
        $this->service = new ProdutoService($config->getConnection());
    }

    public function listar() {
        echo json_encode($this->service->listarProdutos());
    }

    public function consultarProduto($id) {
        echo json_encode($this->service->consultarProduto($id));
    }
    

    public function criar() {
        $dados = json_decode(file_get_contents("php://input"), true);
        echo json_encode($this->service->criarProduto($dados));
    }

    public function atualizar($id) { 
        $dados = json_decode(file_get_contents("php://input"), true);
        echo json_encode($this->service->atualizarProduto($id, $dados));
    }

    public function excluir($id) {
        echo json_encode($this->service->excluirProduto($id));
    }

    public function excluirProdutos(){
        echo json_encode($this->service->excluirTodos());

    }
}
?>
