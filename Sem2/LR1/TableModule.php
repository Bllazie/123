<?php

require_once 'db_connection.php';

class TableModule {
    private $conn;
    private $table_name;

    public function __construct($table_name) {

        $this->conn = DBConnection::getInstance();
        // Установка имени таблицы
        $this->table_name = $table_name;
    }


    private function cleanInput($data) {
        if (is_array($data)) {
            foreach ($data as $key => $value) {

                $data[$key] = $this->cleanInput($value);
            }
        } else {

            $data = htmlspecialchars(strip_tags($data));
        }
        return $data;
    }

    public function insert($data) {

        $data = $this->cleanInput($data);


        if(isset($data['id']) && $data['id'] !== "") {



            $set = [];
            foreach ($data as $key => $value) {
                if ($key !== 'id') {
                    $set[] = "$key = :$key";
                }
            }
            $set = implode(", ", $set);
            $query = "UPDATE $this->table_name SET $set WHERE id = :id";


            return $this->executeQuery($query, $data);
        } else {



            $columns = implode(', ', array_keys($data));
            $placeholders = implode(', ', array_map(function($key) { return ":$key"; }, array_keys($data)));


            $query = "INSERT INTO $this->table_name ($columns) VALUES ($placeholders)";


            return $this->executeQuery($query, $data);
        }
    }

    public function delete($id) {

        $id = $this->cleanInput($id);

        $query = "DELETE FROM $this->table_name WHERE id = ?";
        $params = array($id);

        return $this->executeQuery($query, $params);
    }

    public function getById($id) {

        $id = $this->cleanInput($id);


        $query = "SELECT * FROM $this->table_name WHERE id = ?";


        return $this->executeQuery($query, [$id], true);
    }

    public function getAll() {
        try {

            $query = "SELECT * FROM " . $this->table_name;


            $stmt = $this->conn->prepare($query);
            $stmt->execute();


            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        } catch (PDOException $e) {

            die("Error: " . $e->getMessage());
        }
    }

    public function getAllByFilter($filter = "", $params = []) {

        $filter = $this->cleanInput($filter);

        $query = "SELECT * FROM $this->table_name";
        if (!empty($filter)) {
            $query .= " WHERE $filter";
        }

        return $this->executeQuery($query, $params);
    }

    private function executeQuery($query, $params = [], $single = false) {
        $stmt = $this->conn->prepare($query);
        if ($stmt === false) {
            die("Error in query preparation: " . $this->conn->errorInfo()[2]);
        }

        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $stmt->bindValue(":param$key", $value);
            }
        }


        if ($stmt->execute($params) === false) {
            die("Error in query execution: " . $stmt->errorInfo()[2]);
        }

        if ($single) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $result;
    }
}

?>
