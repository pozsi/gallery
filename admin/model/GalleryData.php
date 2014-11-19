<?php

class GalleryData {

    public $name;
    public $images;

    public function __construct($name, Array $images) {
        $this->name = $name;
        $this->images = $images;
    }

} 