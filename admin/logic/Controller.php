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
            case "genall":
                $this->generateAllGalleries();
                break;
            default: $this->form(array());
        }
    }

    private function form(array $params) {
        $existingGalleries = $this->service->getExistingGalleries();
        echo $this->view->render("form.php", array("galleries" => $existingGalleries));
    }

    private function save(array $params) {
        $rawGalleryData  = $this->service->saveRawGalleryData($params['name'], $params['data']);
        $galleryData = $this->service->createPublicGallery($rawGalleryData);
        Header('Location: ' . $this->config->adminUrl . $this->config->host . '.php?op=edit&name='.$galleryData->name);
        exit;
    }

    private function edit(array $params) {
        $rawGalleryData = $this->service->loadGallery($params['name']);
        $existingGalleries = $this->service->getExistingGalleries();
        echo $this->view->render("form.php", array(
            "current" => $params['name'],
            "name" => $rawGalleryData->name,
            "data" => $rawGalleryData->data,
            "galleries" => $existingGalleries));
    }

    private function generateAllGalleries() {
        $existingGalleries = $this->service->getExistingGalleries();
        foreach($existingGalleries as $gallery) {
            $rawGalleryData = $this->service->loadGallery($gallery[0]);
            $this->service->createPublicGallery($rawGalleryData);
        }
        Header('Location: ' . $this->config->adminUrl . $this->config->host . ".php");
    }

}