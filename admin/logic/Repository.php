<?php

class Repository {

    private $config;

    public function __construct(Config $config) {
        $this->config = $config;
    }

    public function save(RawGalleryData $rawGalleryData) {
        file_put_contents($this->config->galleryDataPath . $rawGalleryData->name . ".txt", $rawGalleryData->data);
    }

    public function createPublicGallery($name) {
        mkdir($this->config->appPath . $name . "/");
    }

    public function savePublicImagePage($galleryName, $fileName, $content) {
        file_put_contents($this->config->appPath . $galleryName . "/" . $fileName . ".html", $content);
    }

    public function getGalleryList()
    {
        $galleries = array();
        if ($handle = opendir($this->config->galleryDataPath)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    $parts = explode(".", $entry, 2);
                    $galleries[] = $parts[0];
                }
            }
        }
        return $galleries;
    }

    public function loadRawGallery($name) {
        return file_get_contents($this->config->galleryDataPath . $name . '.txt');
    }
}
