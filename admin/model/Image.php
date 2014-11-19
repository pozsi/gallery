<?php

class Image {

    public $code;
    public $url;
    public $description;

    public function __construct($code, String $url, String $description) {
        $this->code = $code;
        $this->url = $url;
        $this->description = $description;
    }

} 