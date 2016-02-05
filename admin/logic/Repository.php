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

    public function savePublicMediaPage($galleryName, $fileName, $content) {
        file_put_contents($this->config->appPath . $galleryName . "/" . $fileName . ".html", $content);
    }

    public function savePublicIndexPage($galleryName, $content)
    {
        file_put_contents($this->config->appPath . $galleryName . "/index.html", $content);
    }

    public function getGalleryList()
    {
        $galleries = array();
        if ($handle = opendir($this->config->galleryDataPath)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    $parts = explode(".", $entry, 2);
                    $mtime = date("Y-m-d H:i:s", filemtime($this->config->galleryDataPath . $entry));
                    $galleries[] = array($parts[0], $mtime);
                    $sorter[] = $parts[0];
                }
            }
        }
        array_multisort($sorter, $galleries);
        return $galleries;
    }

    public function loadRawGallery($name) {
        return file_get_contents($this->config->galleryDataPath . $name . '.txt');
    }

    public function loadLatestFeed($host) {
        return file_get_contents($this->config->blogUrls[$host]);
    }
}
