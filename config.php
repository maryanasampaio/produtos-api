<?php
//armazena a conexão com o postgre (banco de dados)

$host = 'localhost'; //endereço de ip
$dbname = 'controle_de_estoque'; //nome do banco
$user = 'postgres'; //nome do usuário
$password = '123456'; //senha

try { //armazena o que pode dar erro 

    $pdo = new PDO("pgsql:host=$host;port=8080;dbname=$dbname", $user, $password); //gera a conexão
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //pega os atributos e os valores 
    echo "conexão bem-sucedida!";
} catch (PDOException $e) { //trata o erro caso seja identificado
die("Erro na conexão: " . $e->getMessage());
}




?>