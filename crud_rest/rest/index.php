<?php
require_once '../vendor/autoload.php';
require_once "../classes/materials.php";
require_once "../classes/earrings.php";
$app = new Silex\Application();

$app->after(function ($request, $response) {
    $response->headers->set('Access-Control-Allow-Origin', '*');
    $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
    $response->headers->set('Access-Control-Allow-Headers', 'Origin, Content-Type, X-Auth-Token');
});

//для материалов:
$app->get('/materials/list.json', function () use ($app){
    $materials = new Materials;
    $list = $materials->read();
    return $app->json($list);
});

$app->post('/materials/add-item', function () use ($app){
    if (strlen($_POST['material_name']) ) {//
        $name = $_POST['material_name'];//

        $materials = new Materials;
        try {
            $materials->create(array("material_name" => $name));//
            $lastid = $materials->lastID();
            return $app->json(array("create-materials" => "yes", "create-id" => $lastid));
        } catch (PDOException $e) {
            return $app->json(array("error" => $e->getMessage(), "create-materials" => "no"));
        }
    } else {
        return $app->json(array("create-materials" => "no"));
    }
});
$app->post('/materials/update-item', function ()use ($app) {
    $materials = new Materials;
    $id = intval($_POST["id"]);
    $name = $_POST["material_name"];//

    if ($materials->exists($id) && strlen($name)) {
        try {
            $materials->update(array( "id" => $id, "material_name" => $name));//
            return $app->json(array("update-materials" => "yes", "id_update" => $id));
        } catch (PDOException $e) {
            return $app->json(array("error" => $e->getMessage(), "update-materials" => "no"));
        }
    } else {
        return $app->json(array("update-materials" => "no"));
    }
});

$app->options('/materials/delete-item', function () use ($app) {
    $response = new \Symfony\Component\HttpFoundation\Response();
    $response->headers->set('Access-Control-Allow-Origin', '*');
    $response->headers->set('Access-Control-Allow-Methods', 'POST');
    $response->headers->set('Access-Control-Allow-Headers', 'Content-Type');
    return $response;
});


$app->post('/materials/delete-item', function () use ($app) {
    $id = isset($_POST["id"]) ? intval($_POST["id"]) : null;
    $materials = new Materials;
    if ($materials->exists($id)) {
        try {
            $materials->delete($id);
            $response = $app->json(array("delete-materials" => "yes", "id_delete" => $id));
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'POST');
            $response->headers->set('Access-Control-Allow-Headers', 'Origin, Content-Type, X-Auth-Token');
            return $response;
        } catch (PDOException $e) {
            $response = $app->json(array("error" => $e->getMessage(), "delete-materials" => "no"));
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'POST');
            $response->headers->set('Access-Control-Allow-Headers', 'Origin, Content-Type, X-Auth-Token');
            return $response;
        }
    } else {
        $response = $app->json(array("delete-materials" => "no"));
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'POST');
        $response->headers->set('Access-Control-Allow-Headers', 'Origin, Content-Type, X-Auth-Token');
        return $response;
    }
});

//для драгоценностей:

$app->get('/earrings/list.json', function () use ($app){
    $earring = new Earrings();
    $list = $earring->read();
    return $app->json($list);
});
$app->post('/earrings/add-item', function () use ($app) {
    $name = $_POST["name"];
    $material = $_POST['id_material'];
    $description = $_POST['description'];
    $cost = $_POST['cost'];


    // Добавьте обработку загруженного файла
    if (isset($_FILES['img_path']) && $_FILES['img_path']['error'] === UPLOAD_ERR_OK) {
        $tempFilePath = $_FILES['img_path']['tmp_name'];
        $img_name = uniqid('img_') . '_' . $_FILES['img_path']['name'];
        $newFilePath = 'C:/xampp/htdocs/lab2.2/src/assets/img/' . $img_name;

        if (!move_uploaded_file($tempFilePath, $newFilePath)) {
            // Если не удалось переместить файл, отправьте сообщение об ошибке
            $errorMessage = 'Ошибка при перемещении файла';
            return $app->json(array("error" => $errorMessage, "create-earring" => "no"));
        }
        $img_path =$img_name ;  // Теперь $newFilePath содержит путь к загруженному изображению, который можно с
        //      охранить в базе данных
    }

    $earring = new Earrings();
    try {
        $earring->create(array('name' => $name, "id_material" => $material, "description" => $description, "cost" => $cost, "img_path" => $img_path), $_FILES);
        return $app->json(array("create-earring" => "yes"));
    } catch (PDOException $e) {
        return $app->json(array("error" => $e->getMessage(), "create-earring" => "no"));
    }
});

$app->post('/earrings/update-item', function () use ($app){
    $id= $_POST['id'];
    $name = $_POST['name'];
    $material = $_POST['id_material'];
    $description = $_POST['description'];
    $cost = $_POST['cost'];
    // Добавьте обработку загруженного файла
    if (isset($_FILES['img_path']) && $_FILES['img_path']['error'] === UPLOAD_ERR_OK) {
        $tempFilePath = $_FILES['img_path']['tmp_name'];
        $img_name = uniqid('img_') . '_' . $_FILES['img_path']['name'];
        $newFilePath = 'C:/xampp/htdocs/lab2.2/src/assets/img/' . $img_name; // Укажите путь соответственно

// Переместите загруженный файл в папку проекта
        if (!move_uploaded_file($tempFilePath, $newFilePath)) {
            // Если не удалось переместить файл, отправьте сообщение об ошибке
            $errorMessage = 'Ошибка при перемещении файла';
            return $app->json(array("error" => $errorMessage, "create-earring" => "no"));
        }
        $img_path =$img_name ;
        // Теперь $newFilePath содержит путь к загруженному изображению, который можно сохранить в базе данных
    }
    $earring = new Earrings();
    if ($earring->exists($id) && strlen($name)) {
        try {
            $earring->update(array(
                "id" => $id,
                'name' => $name,
                "id_material" => $material,
                "description" => $description,
                "cost" => $cost,
                "img_path" => $img_path
            ));
            return $app->json(array("update-earring" => "yes", "id_update" => $id));
        } catch (PDOException $e) {
            return $app->json(array("error" => $e->getMessage(), "update-earring" => "no"));
        }
    } else {
        return $app->json(array("update-earring" => "no"));
    }
});

$app->post('/earrings/delete-item', function () use ($app) {
    $id = intval($_POST["id"]);

    $earring = new Earrings();
    if ($earring->exists($id)) {
        try {
            // Получаем информацию о драгоценности
            $earringInfo = $earring->get($id);
            $img_path = 'C:/xampp/htdocs/lab2.2/src/assets/img/' . $earringInfo['img_path']; // Получаем путь к изображению

            // Удаляем запись из базы данных
            $earring->delete($id);

            // Удаляем файл изображения, если он существует
            if (!empty($img_path) && file_exists($img_path)) {
                unlink($img_path); // Удаляем файл
            }

            return $app->json(array("delete-earring" => "yes", "id_delete" => $id));
        } catch (PDOException $e) {
            return $app->json(array("error" => $e->getMessage(), "delete-earring" => "no"));
        }
    } else {
        return $app->json(array("delete-earring" => "no"));
    }
});

$app->get('/earrings/SelectByID', function () use ($app){
    $material = intval($_GET['id_material']);//
    $fields = array(); // Добавьте дополнительные поля для фильтрации, если необходимо
    $earring = new Earrings();
    $list = $earring->getRecordsByFilter('id_material', $material, $fields); // Используйте поле id_material для фильтрации
    return $app->json($list);
});

$app->run();