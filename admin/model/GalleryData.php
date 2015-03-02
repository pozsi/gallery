<?php

class GalleryData {

    public $name;
    public $media;

    public function __construct($name, Array $media) {
        $this->name = $name;
        $this->media = $media;
    }

} 