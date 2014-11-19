<?php

    require_once("config/LiveConfig.php");
    require_once("service/Service.php");
    require_once("view/View.php");
    require_once("controller/Controller.php");

    $config = new LiveConfig();
    $service = new Service($config);
    $view = new View($config);
    $controller = new Controller($config, $service, $view);

    $op = isset($_GET['op']) ? $_GET['op'] : '';
    $params = $_POST;

    $controller->dispatch($op, $params);
