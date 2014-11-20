<?php

require_once('../model/RawGalleryData.php');
require_once('../model/GalleryData.php');
require_once('../model/Image.php');

class Service {

    private $config;
    private $repository;
    private $view;

    public function __construct(Config $config, Repository $repository, View $view) {
        $this->config = $config;
        $this->repository = $repository;
        $this->view = $view;
    }

    public function saveRawGalleryData($name, $data) {
        $rawGalleryData = new RawGalleryData($name, $data);
        $this->repository->save($rawGalleryData);
    }

    public function parseRawGalleryData($name, $data) {
        $items = explode("\n", $data);
        $result = array();
        foreach ($items as $item) {
            $item = explode(" ", $item, 3);
            $result[] = new Image($item[0], $item[1], $item[2]);
        }
        return new GalleryData($name, $result);
    }

    public function createPublicGallery($name, $data) {
        $this->repository->createPublicGallery($name);
        $galleryData = $this->parseRawGalleryData($name, $data);
        $this->saveGallery($galleryData);
    }

    public function saveGallery(GalleryData $galleryData) {
        for ($i = 0; $i < count($galleryData->images); $i++) {
            $this->saveImage($galleryData->name, $i + 1, $galleryData->images[$i]);
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
        $data = $this->repository->loadRawGallery($name);
        return new RawGalleryData($name, $data);
    }

    public function getExistingGalleries() {
        return $this->repository->getGalleryList();
    }

} 