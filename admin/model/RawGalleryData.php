<?php

class RawGalleryData {

    public $name;
    public $data;

    public function __construct($name, $data) {
        $this->name = $name;
        $this->data = $data;
    }

} 