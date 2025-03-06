<?php
//armazena a conexão com o postgre (banco de dados)

$host = 'localhost'; //endereço de ip
$dbname = 'controle_de_estoque'; //nome do banco
$user = 'postgres'; //nome do usuário
$password = '123456'; //senha

try { //armazena o que pode dar erro 

    $pdo = new PDO("pgsql:host=$host;port=8080;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) { //trata o erro caso seja identificado
die("Erro na conexão: " . $e->getMessage());
}




?>