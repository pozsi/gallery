<?php

require_once('Config.php');

class LiveConfig extends Config {

    public $appPath = '/www/b4.hu/';
    public $appUrl = 'http://b4.hu/';

    function __construct() {
        $this->adminPath = $this->appPath . 'admin/';
        $this->adminUrl = $this->appUrl . 'admin/';
        $this->galleryDataPath = $this->adminPath . "galleries/";
        $this->templatePath = $this->adminPath . 'view/';
    }

}
