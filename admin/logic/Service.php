<?php

require_once('model/RawGalleryData.php');
require_once('model/GalleryData.php');
require_once('model/Image.php');

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
        return $rawGalleryData;
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

    public function createPublicGallery(RawGalleryData $rawGalleryData) {
        $this->repository->createPublicGallery($rawGalleryData->name);
        $galleryData = $this->parseRawGalleryData($rawGalleryData->name, $rawGalleryData->data);
        $this->saveGallery($galleryData);
        return $galleryData;
    }

    private function saveGallery(GalleryData $galleryData) {
        $count = count($galleryData->images);
        for ($i = 0, $index = 1; $i < $count; $i++, $index++) {
            $this->saveImage($galleryData->name, $index, $count, $galleryData->images[$i]);
        }
    }

    private function saveImage($name, $index, $count, Image $image) {
        $imagePage = $this->view->render("template.html", array(
            'galleryName' => $name,
            'image' => $image,
            'index' => $index,
            'count' => $count
        ));
        $fileName = ($index == 1) ? "index" : $index;
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