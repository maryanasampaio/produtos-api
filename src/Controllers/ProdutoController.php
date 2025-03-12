
<?php

// class ProdutoController {

// private static function dadosDaRequesicao() {
//     return json_decode(file_get_contents('php://input'), true); //converte os dados recebidos para um array 
// }

// public static function listar($pdo) {
//     $stmt = $pdo->query('SELECT * FROM produtos');
//     echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC)); // converte  os dados recebidos do banco para um json
// }

// public static function criar($pdo, $data) {
//     $data = self::dadosDaRequesicao(); //converte os dados para um array 
    
//     //etapa 1: valida dados e verifica se os campos obrigatórios estão vazios 
//     if (empty($data['nome']) || empty($data['descricao']) || empty($data['preco']) || $data['preco'] <= 0) {
//         http_response_code(422);
//         echo json_encode(['status' => 'erro', 'message' => 'Dados inválidos']); //caso os dados estiverem vazios 
//         return;
//     }

//     //etapa 2: apos passar pela validação, prepara o comando 
//     $stmt = $pdo->prepare('INSERT INTO produtos (nome, descricao, preco) VALUES (:nome, :descricao, :preco)');
//     $stmt->bindParam(':nome', $data['nome']);
//     $stmt->bindParam(':descricao', $data['descricao']); //o valor dos campos vazios da tabela serão preenchidos por esses colocados no parâmetro da request
//     $stmt->bindParam(':preco', $data['preco']);

//      //executa e verifica se a requisição foi feita com sucesso ou erro.
//     if ($stmt->execute()) {
//         http_response_code(201);
//         echo json_encode(['status' => 'sucesso', 'message' => 'Produto criado']);
//     } else {
//         http_response_code(500);
//         echo json_encode(['status' => 'erro', 'message' => 'Erro ao criar produto']);
//     }
// }

// public static function atualizar($pdo, $data) {
//     $data = self::dadosDaRequesicao(); //converte os dados recebidos para um array
    
//     //etapa 1: verifica campos vazios
//     if (empty($data['id']) || empty($data['nome']) || empty($data['descricao']) || empty($data['preco']) || $data['preco'] <= 0) {
//         http_response_code(422);
//         echo json_encode(['status' => 'erro', 'message' => 'Dados inválidos']);
//         return;
//     }

//      //etapa 2: prepara comando
//     $stmt = $pdo->prepare('UPDATE produtos SET nome = :nome, descricao = :descricao, preco = :preco WHERE id = :id');
//     $stmt->bindParam(':nome', $data['nome']);
//     $stmt->bindParam(':descricao', $data['descricao']);
//     $stmt->bindParam(':preco', $data['preco']);  //define valores que campos vazios da tabeça irão receber
//     $stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);

//      //etapa 3: executa e verifica sucesso ou erro da requisição
//     if ($stmt->execute()) {
//         http_response_code(200);
//         echo json_encode(['status' => 'sucesso', 'message' => 'Produto atualizado']);
//     } else {
//         http_response_code(500);
//         echo json_encode(['status' => 'erro', 'message' => 'Erro ao atualizar produto']);
//     }
// }

// public static function deletar($pdo, $data) {
//     $data = self::dadosDaRequesicao(); //converte dados para array
    
//     //etapa 1: verifica se o campo está preenchido 
//     if (empty($data['id'])) {
//         http_response_code(422);
//         echo json_encode(['status' => 'erro', 'message' => 'ID do produto não informado']); //converte para json 
//         return;
//     }
//     // etapa 2: prepara comando
//     $stmt = $pdo->prepare('DELETE FROM produtos WHERE id = :id');
//     $stmt->bindParam(':id', $data['id'], PDO::PARAM_INT); //determina que o valor do parâmetro da requisição será o mesmo que do campo na tabela

//     //executa comando e valida o retorno final da requisição 
//     if ($stmt->execute()) {
//         http_response_code(200);
//         echo json_encode(['status' => 'sucesso', 'message' => 'Produto deletado']);
//     } else {
//         http_response_code(500);
//         echo json_encode(['status' => 'erro', 'message' => 'Erro ao deletar produto']);
//     }
// }
// }

// use Src\Services\ProdutoService;

class ProdutoController {
    private $service;

    public function __construct() {
        $config = new \DatabaseConfig();
        // $repository = new \Src\Repositories\ProdutoRepository($config->getConnection());
        // $this->service = new ProdutoService($repository);
    }
    public function listar() {
        echo json_encode($this->service->listar());
    }
}






?>