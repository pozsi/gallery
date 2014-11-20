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
            case "edit":
                $this->edit($params);
                break;
            case "save":
                $this->save($params);
                break;
            default: $this->form(array());
        }
    }

    private function form(array $params) {
        echo $this->view->render("form.php", $params);
    }

    private function save(array $params) {
        $this->service->saveRawGalleryData($params['name'], $params['data']);
        $this->service->createPublicGallery($params['name'], $params['data']);
        Header('Location: ' . $this->config->adminPath . '?op=edit&name='.$params['name']);
        exit;
    }

    private function edit(array $params) {
        $rawGalleryData = $this->service->loadGallery($params['name']);
        $existingGalleries = $this->service->getExistingGalleries();
        $this->view->render("form.php", array(
            "current" => $params['name'],
            "name" => $rawGalleryData->name,
            "data" => $rawGalleryData->data,
            "galleries" => $existingGalleries));
    }

}