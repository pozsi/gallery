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
        $count = count($galleryData->images);
        for ($i = 0, $index = 1; $i < $count; $i++, $index++) {
            $this->saveImage($galleryData->name, $index, $index < $count, $galleryData->images[$i]);
        }
    }

    public function saveImage($name, $index, $hasMore, Image $image) {
        $imagePage = $this->view->render("template.html", array(
            'image' => $image,
            'index' => $index,
            'hasMore' => $hasMore
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