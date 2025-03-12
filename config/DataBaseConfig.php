<?php
//armazena a conexão com o postgre (banco de dados)

// $host = 'localhost'; //endereço de ip
// $dbname = 'controle_de_estoque'; //nome do banco
// $user = 'postgres'; //nome do usuário
// $password = '123456'; //senha

// try { //armazena o que pode dar erro 

//     $pdo = new PDO("pgsql:host=$host;port=5432;dbname=$dbname", $user, $password); //gera a conexão
//     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //pega os atributos e os valores 
//     echo "conexão bem-sucedida!";
// } catch (PDOException $e) { //trata o erro caso seja identificado
// die("Erro na conexão: " . $e->getMessage());
// }
class DatabaseConfig {
    private $pdo;

    public function __construct() {
        $host = 'localhost';
        $dbname = 'controle_de_estoque';
        $user = 'postgres';
        $password = '123456';
 
        try {
            $this->pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "conexão bem-sucedida!";
        } catch (PDOException $e) {
            die("Erro na conexão: " . $e->getMessage());
        }
    }
    public function getConnection(): PDO {
        return $this->pdo;
    }
}


$db = new DatabaseConfig();


?>

