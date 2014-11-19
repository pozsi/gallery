<?php

class Controller {

    private $config;
    private $service;
    private $view;

    public function __construct(Config $config, Service $service, View $view) {
        $this->config = $config;
        $this->service = $service;
        $this->view = $view;
    }

    public function dispatch($op, array $params) {
        switch($op) {
            case "": $this->form($params);
        }
    }

    public function form(array $params) {
        $this->view->render("form.php", $params);
    }

} 