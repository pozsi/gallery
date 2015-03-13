<?php

require_once('model/RawGalleryData.php');
require_once('model/GalleryData.php');
require_once('model/Media.php');

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
            if ($item[0] == "|") {
                $item = ltrim($item, '|');
                $separator = "|";
            } else {
                $separator = " ";
            }
            $item = explode($separator, $item, 3);
            if (strpos($item[1], "http") === 0) {
                $mediaType = "image";
            } else {
                $mediaType = "embed";
            }
            if ($item[2][0] == "*") {
                $item[0] = "018";
                $item[2] = ltrim($item[2], "*");
            }
            if (!empty($item[1])) {
                $result[] = new Media($item[0], $item[1], $item[2], $mediaType);
            }
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
        $count = count($galleryData->media);
        $this->saveIndexPage($galleryData->name);
        for ($i = 0, $index = 1; $i < $count; $i++, $index++) {
            $this->saveMedia($galleryData->name, $index, $count, $galleryData->media[$i]);
        }
    }

    private function saveMedia($name, $index, $count, Media $media) {
        $mediaPage = $this->view->render("template.html", array(
            'galleryName' => $name,
            'media' => $media,
            'index' => $index,
            'count' => $count
        ));
        $this->repository->savePublicMediaPage($name, $index, $mediaPage);
    }

    private function saveIndexPage($name) {
        $indexPage = $this->view->render("index.html", array());
        $this->repository->savePublicIndexPage($name, $indexPage);
        
    }
    
    public function loadGallery($name) {
        $data = $this->repository->loadRawGallery($name);
        return new RawGalleryData($name, $data);
    }

    public function getExistingGalleries() {
        return $this->repository->getGalleryList();
    }

} 