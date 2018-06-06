<?php
/**
 * @author Sueliton
 */

namespace Core;

use PDO;
use PDOException;

class DataBase {

    //verifica qual database se conecta
    public static function getDatabase() {
        //recebe um array vindo do include do arquivo com as configurações respectivo de cada banco.
        $conf = include_once __DIR__ . '/../App/database.php';

        //se o driver passado nas config for sqlite executa essas configurações do PDO
        if ($conf['driver'] == "sqlite") {
            //inclue o arquivo da base de dados
            $sqlite = __DIR__ . "/../storage/database/" . $conf['sqlite']['host'];
            //renomeia o arquivo para que seja conectados passado nosparametros de conexão do PDO.
            $sqlite = "sqlite:" . $sqlite;

            try {
                $pdo = new PDO($sqlite);
                //config para que seja exibido execeções em caso de erro
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //config para que retorne um array de objetos dos resultados de consultas.
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
                //retorna obj conexão
                return $pdo;
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        } else if ($conf['driver'] == "mysql") {
            $host = $conf['mysql']['host'];
            $db = $conf['mysql']['database'];
            $user = $conf['mysql']['user'];
            $pass = $conf['mysql']['pass'];
            $charset = $conf['mysql']['charset'];
            $collation = $conf['mysql']['collation'];

            try {
                $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass);
                //config para que seja exibido execeções em caso de erro
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //config para setar o charset e a collection do banco.
                $pdo->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES '$charset' COLLATE '$collation'");
                //config para que retorne um array de objetos dos resultados de consultas.
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
                //retorna obj conexão
                return $pdo;
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }

}
