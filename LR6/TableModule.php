<?php

class TableModule
{
    private $conn;

    public function __construct($connection)
    {
        $this->conn = $connection;
    }

    public function addData($img_path, $name, $description, $material, $cost)
    {
        $errors = [];

        if (!$this->isValidURL($img_path)) {
            $errors[] = "Ошибка: Некорректная ссылка на изображение.";
        }

        if (!$this->isValidHallNumber($cost)) {
            $errors[] = "Ошибка: Стоимость должна быть положительным целым числом, отличным от 0.";
        }

        if (!empty($errors)) {
            return ["success" => false, "errors" => $errors];
        }

        $img_path = $this->conn->real_escape_string($img_path);
        $name = $this->conn->real_escape_string($name);
        $description = $this->conn->real_escape_string($description);
        $material = $this->conn->real_escape_string($material);
        $cost = $this->conn->real_escape_string($cost);

        // Проверка существования материала
        $sql_check_material = "SELECT id FROM material WHERE material_name = ?";
        $stmt_check_material = $this->conn->prepare($sql_check_material);
        $stmt_check_material->bind_param("s", $material);
        $stmt_check_material->execute();
        $stmt_check_material->store_result();

        if ($stmt_check_material->num_rows > 0) {
            // Материал уже существует, получаем его id
            $stmt_check_material->bind_result($material_id);
            $stmt_check_material->fetch();
        } else {
            // Материал не существует, вставляем новый
            $sql_insert_material = "INSERT INTO material (material_name) VALUES (?)";
            $stmt_insert_material = $this->conn->prepare($sql_insert_material);
            $stmt_insert_material->bind_param("s", $material);

            if (!$stmt_insert_material->execute()) {
                return ["success" => false, "message" => "Ошибка при добавлении материала: " . $stmt_insert_material->error];
            }

            $material_id = $stmt_insert_material->insert_id;
            $stmt_insert_material->close();
        }

        // Вставка данных в таблицу 'earrings'
        $sql_earrings = "INSERT INTO earrings (img_path, name, description, material, cost) VALUES (?, ?, ?, ?, ?)";
        $stmt_earrings = $this->conn->prepare($sql_earrings);
        $stmt_earrings->bind_param("sssii", $img_path, $name, $description, $material_id, $cost);

        if ($stmt_earrings->execute()) {
            $stmt_earrings->close();
            $stmt_check_material->close();
            return ["success" => true];
        } else {
            $stmt_earrings->close();
            $stmt_check_material->close();
            return ["success" => false, "message" => "Ошибка при добавлении данных в таблицу 'earrings': " . $stmt_earrings->error];
        }
    }

    private function isValidURL($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL) !== false;
    }

    private function isValidHallNumber($cost)
    {
        return is_numeric($cost) && $cost > 0;
    }
}

?>
