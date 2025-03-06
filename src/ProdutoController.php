<?php
//lógica de negócio da api. processa os dados antes de envia-los para o usuário

class ProdutoController {

    public static function listar($pdo) {
    
    $stmt = $pdo->query('SELECT * FROM produtos');
    
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
    
    }
    }