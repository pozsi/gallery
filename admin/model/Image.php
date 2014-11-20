<?php

class Image {

    public $code;
    public $url;
    public $description;

    public function __construct($code, $url, $description) {
        $this->code = $code;
        $this->url = $url;
        $this->description = $description;
    }

} 