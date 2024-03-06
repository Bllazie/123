<?php require_once "db_connection.php"?>
<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="//volgu.ivsupport.ru/script.php?<?=time()?>"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css">
    <link rel="icon" href="https://pertsi.ru/themes/site/img/logo-peppers.svg" type="image/x-icon">
    <title>Ювелирный магазин - Соколов </title>
</head>
<body>
<header>

    <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
        <div class="container-fluid">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav me-auto mb-2 mb-md-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Ювелирный Магазин</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="earrings_list.php">Список драгоценностей</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="material_list.php">Список материалов</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>