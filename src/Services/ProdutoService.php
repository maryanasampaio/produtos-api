<?php
namespace Src\Services; // Definindo o namespace Src\Services

use PDO;
use PDOException;

class ProdutoService {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function listarProdutos() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM produtos");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ["erro" => "Erro ao buscar produtos: " . $e->getMessage()];
        }
    }

    public function criarProduto($dados) {
        if (empty($dados['nome']) || empty($dados['preco']) || $dados['preco'] <= 0) {
            http_response_code(400);
            return ["erro" => "Nome e preço são obrigatórios e o preço deve ser maior que zero"];
        }

        try {
            $stmt = $this->pdo->prepare("INSERT INTO produtos (nome, preco, descricao) VALUES (:nome, :preco, :descricao)");
            $stmt->bindValue(':nome', $dados['nome']);
            $stmt->bindValue(':preco', $dados['preco']);
            $stmt->bindValue(':descricao', $dados['descricao'] ?? null);
            $stmt->execute();

            http_response_code(201);
            return ["status" => "sucesso", "mensagem" => "Produto criado!"];
        } catch (PDOException $e) {
            return ["erro" => "Erro ao criar produto: " . $e->getMessage()];
        }
    }

    public function atualizarProduto($id, $dados) {
        if (empty($dados['nome']) || empty($dados['preco']) || $dados['preco'] <= 0) {
            http_response_code(400);
            return ["erro" => "Nome e preço são obrigatórios e o preço deve ser maior que zero"];
        }

        try {
            $stmt = $this->pdo->prepare("UPDATE produtos SET nome = :nome, preco = :preco, descricao = :descricao WHERE id = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->bindValue(':nome', $dados['nome']);
            $stmt->bindValue(':preco', $dados['preco']);
            $stmt->bindValue(':descricao', $dados['descricao'] ?? null);
            $stmt->execute();

            if ($stmt->rowCount() === 0) {
                http_response_code(404);
                return ["erro" => "Produto não encontrado"];
            }

            return ["status" => "sucesso", "mensagem" => "Produto atualizado!"];
        } catch (PDOException $e) {
            return ["erro" => "Erro ao atualizar produto: " . $e->getMessage()];
        }
    }

    public function excluirProduto($id) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM produtos WHERE id = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() === 0) {
                http_response_code(404);
                return ["erro" => "Produto não encontrado"];
            }

            return ["status" => "sucesso", "mensagem" => "Produto excluído!"];
        } catch (PDOException $e) {
            return ["erro" => "Erro ao excluir produto: " . $e->getMessage()];
        }
    }
}
?>
