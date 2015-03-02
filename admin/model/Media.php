<?php

class Media {

    public $code;
    public $url;
    public $description;

    public function __construct($code, $url, $description, $mediaType) {
        $this->code = $code;
        $this->media = $url;
        $this->description = $description;
        $this->mediaType = $mediaType;
    }

} 