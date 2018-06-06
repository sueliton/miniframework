<?php

/**
 * @author Sueliton
 */

namespace Core;

use PDO;

abstract class BaseModel {

    //é passado pela classe que instanciar essa lá no controller.
    private $pdo;
    //é passado pela classe que instanciar essa lá no controller.
    protected $table;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    //lista todos os posts
    public function all() {
        $query = "SELECT * FROM {$this->table}";
        $stmt = $this->pdo->query($query);
        $stmt->execute();
        $result = $stmt->fetchAll();
        //fecha o ponteiro de conexão.
        $stmt->closeCursor();

        return $result;
    }

    public function find($id) {
        $query = "SELECT * FROM {$this->table} WHERE id=:id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(":id", $id);
        $stmt->execute();
        $result = $stmt->fetch();
        $stmt->closeCursor();

        return $result;
    }

    public function create(array $data) {
        $data = $this->prepareDataInsert($data);
        $query = "INSERT INTO {$this->table} ({$data[0]}) VALUES ($data[1])";
        $stmt = $this->pdo->prepare($query);
        for ($i = 0; $i < count($data[2]); $i++) {
            $stmt->bindValue("{$data[2][$i]}", $data[3][$i]);
        }
        $result = $stmt->execute();
        $stmt->closeCursor();

        return $result;
    }

    //prepara os dados para ser inseridos no formato do pdo.
    private function prepareDataInsert(array $data) {
        //variável que vai substituir os campos que iram receber a inserção de dados no banco.
        $strKeys = "";
        //variável que substitui o os apelidos/binds ex: :id na query.
        $strbinds = "";
        //vai substituir as binds no bindValue()
        $binds = [];
        //vai substituir os valores no bindValue()
        $values = [];

        foreach ($data as $key => $value) {
            $strKeys = "{$strKeys},{$key}";
            $strbinds = "{$strbinds},:{$key}";
            $binds[] = ":{$key}";
            $values[] = $value;
        }

        $strKeys = substr($strKeys, 1);
        $strbinds = substr($strbinds, 1);

        return [$strKeys, $strbinds, $binds, $values];
    }

    public function update(array $data, $id) {
        $data = $this->prepareDataUpdate($data);
        $query = "UPDATE {$this->table} SET {$data[0]} WHERE id =:id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(":id", $id);
        for ($i = 0; $i < count($data[1]); $i++) {
            $stmt->bindValue("{$data[1][$i]}", $data[2][$i]);
        }
        $result = $stmt->execute();
        $stmt->closeCursor();
        return $result;
    }

    private function prepareDataUpdate(array $data) {
        $strKeysBinds = "";
        $binds = [];
        $values = [];

        foreach ($data as $key => $value) {
            $strKeysBinds = "{$strKeysBinds},{$key}=:{$key}";
            $binds[] = ":{$key}";
            $values[] = $value;
        }

        $strKeysBinds = substr($strKeysBinds, 1);

        return [$strKeysBinds, $binds, $values];
    }

}
