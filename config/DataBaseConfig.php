<?php
namespace Config; 

use PDO;
use PDOException;

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
            // echo "conexão bem-sucedida!"; //mensagem de teste de conexão
        } catch (PDOException $e) {
            die("Erro na conexão: " . $e->getMessage());
        }
    }

    public function getConnection(): PDO {
        return $this->pdo;
    }
}
$db = new DatabaseConfig();
$pdo = $db->getConnection();


?>
