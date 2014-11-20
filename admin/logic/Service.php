<?php

class Service {

    private $config;
    private $repository;
    private $view;

    public function __construct(Config $config, Repository $repository, View $view) {
        $this->config = $config;
        $this->repository = $repository;
        $this->view = $view;
    }

    public function saveRawGalleryData($name, array $data) {
        $rawGalleryData = new RawGalleryData($name, $data);
        $this->repository->save($rawGalleryData);
    }

    public function parseRawGalleryData($data) {
        $items = explode("\n", $data);
        $result = array();
        foreach ($items as $item) {
            $item = explode(" ", $item, 3);
            $result[] = new Image($item[0], $item[1], $item[2]);
        }
        return $result;
    }

    public function createPublicGallery($name, $data) {
        $this->repository->createPublicGallery($name);
        $images = $this->parseRawGalleryData($data);
        for($i = 0; $i < count($images); $i++) {
            $this->saveImage($name, $i + 1, $images[$i]);
        }
    }

    public function saveImage($name, $index, Image $image) {
        $imagePage = $this->view->render("template.html", array('image' => $image));
        if ($index == 1) {
            $fileName = "index";
        } else {
            $fileName = $index;
        }
        $this->repository->savePublicImagePage($name, $fileName, $imagePage);
    }

    public function loadGallery($name) {
        $data = $this->repository->loadGallery($name);
        return new RawGalleryData($name, $data);
    }

    public function getExistingGalleries() {
        return $this->repository->getGalleryList();
    }

} 