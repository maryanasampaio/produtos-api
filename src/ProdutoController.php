<?php
//lógica de negócio da api. processa os dados antes de envia-los para o usuário

class ProdutoController {

    public static function listar($pdo) { //recebe o banco
    
    $stmt = $pdo->query('SELECT * FROM produtos'); //roda comando no banco para selecionar todos os produtos 
    
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC)); // converte o retorno da consulta para um json 
    }

    public static function criar($pdo){
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        // verifica se está recebendo os dados via POST
        if (isset($data['nome']) && isset($data['descricao']) && isset($data['preco'])) {
            // executando comando para inserir dados na tabela
            $stmt = $pdo->prepare('INSERT INTO produtos (nome, descricao, preco) VALUES (:nome, :descricao, :preco)');
            
            // determina que os valores da tabela serão os mesmos preenchidos por parâmetro
            $stmt->bindParam(':nome', $data['nome']);
            $stmt->bindParam(':descricao', $data['descricao']);
            $stmt->bindParam(':preco', $data['preco']);
            
            // Executando a query e verificando se foi bem-sucedida
            if ($stmt->execute()) {
                echo json_encode(['status' => 'sucesso', 'message' => 'Produto criado com sucesso']);
                http_response_code(200);

            } else {
                echo json_encode(['status' => 'erro', 'message' => 'Erro ao criar produto']);
                http_response_code(200);
            }
        } elseif($data['nome'] === null) {
            echo json_encode(['status' => 'erro', 'message' => 'O campo de nome está vazio']);
            http_response_code(200);
        }elseif($data['preco']<= 0 || $data['preco'] === null){
            echo json_encode(['status' => 'erro', 'message' => 'Insira um valor ao produto']);
            http_response_code(200);
        }

       




    }
    
       public static function atualizar($pdo){
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        //verifica se o ID do produto e os dados a serem atualizados foram recebidos via POST, pois como vamos atualizar dados inexistentes?
        if (isset($data['nome']) && isset($data['descricao']) && isset($data['preco'])) {
                                    
                                   //atualize a tabela produtos pegando ... do produto especifico
            $stmt = $pdo->prepare('UPDATE produtos SET nome = :nome, descricao = :descricao, preco = :preco WHERE id = :id');
      
        // determina que os valores da tabela serão os mesmos preenchidos por parâmetro
        $stmt->bindParam(':nome', $data['nome']);
        $stmt->bindParam(':descricao', $data['descricao']);
        $stmt->bindParam(':preco', $data['preco']);
        $stmt->bindParam(':id', $data['id']);

        //executa a query e verifica se foi bem sucedida
        if($stmt->execute()){
            echo json_encode(['status' => 'sucesso', 'message' => 'Produto atualizado com sucesso']);
        }else{
            echo json_encode(['status' => 'erro', 'message' => 'Erro ao atualizar produto']);

        }

       }else{
        echo json_encode(['status' => 'erro', 'message' => 'Dados insuficientes']); //retorno em json para o cliente
       }
    }

    public static function deletar($pdo){
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        //verifica se contém esse produto
        if(isset($data['id'])) {
        $stmt = $pdo->prepare('DELETE FROM produtos WHERE id = :id');   
        $stmt->bindParam(':id', $data['id']); 
            //executa a query e verifica se a requisição ocorreu com sucesso
            if($stmt->execute()){
            echo json_encode(['status' => 'sucesso', 'message' => 'produto deletado com sucesso']);
            }else{
                echo json_encode([
                    'status' => 'erro',
                    'message' => 'Erro ao tentar deletar produto'
                ]);
            }
        
        }else{
            echo json_encode([
                'status' => 'erro',
                'message' => 'ID do poroduto não informado'
            ]);
        }
    }
}
