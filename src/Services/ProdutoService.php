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

    public function consultarProduto($id){
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM produtos WHERE id = :id");
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $produto = $stmt->fetch(PDO::FETCH_ASSOC);

            if(!$produto){
            http_response_code(404);
            return ["erro" => "Produto não encontrado"];
        }

        return $produto;

        } catch (PDOException $e) {
            http_response_code(500);
            return ["erro" => "Erro ao buscar produto: " . $e->getMessage()];
        }

    }

    public function criarProduto($dados) {
        //etapa 1 do processamento  de dados recebidos: validar os dados obrigatórios
        if (empty($dados['nome']) || empty($dados['preco']) || $dados['preco'] <= 0) {
            http_response_code(400);
            return ["erro" => "Nome e preço são obrigatórios e o preço deve ser maior que zero"];
        }
        //etapa 2 do processamento de dados recebidos: prepara comando  
        try {
            $stmt = $this->pdo->prepare("INSERT INTO produtos (nome, preco, descricao) VALUES (:nome, :preco, :descricao)");
       
        //etapa 2: determina que os dados recebidos serão encaminhados para as colunas da tabela do banco
            $stmt->bindValue(':nome', $dados['nome']);
            $stmt->bindValue(':preco', $dados['preco']);
            $stmt->bindValue(':descricao', $dados['descricao'] ?? null);
           
        //etapa 3: executa comando
            $stmt->execute();

        //etapa 4: verificar reposta da requisição
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

    public function excluirTodos(){
        try{
        $stmt = $this->pdo->prepare('DELETE FROM produtos');
        $stmt->execute();
         http_response_code(200);
         return json_encode(["status" => "sucesso", "message" => "Todos os produtos foram deletados!"]);

        }catch(PDOException){
            return json_encode(
                [
                    "status" => "erro", "message" => "erro ao deletar os produtos"
                ]
            );
        }
    }
}
?>
