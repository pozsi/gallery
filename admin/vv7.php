<?php

    require_once("config/LiveConfig.php");
    require_once("logic/Repository.php");
    require_once("logic/View.php");
    require_once("logic/Service.php");
    require_once("logic/Controller.php");

    $host = basename($_SERVER["SCRIPT_FILENAME"], '.php');
    $config = new LiveConfig($host);
    $repository = new Repository($config);
    $view = new View($config);
    $service = new Service($config, $repository, $view);
    $controller = new Controller($config, $service, $view);

    $op = isset($_GET['op']) ? $_GET['op'] : '';
    $params = $_POST + $_GET;

    $controller->dispatch($op, $params);
    $a = 7;
