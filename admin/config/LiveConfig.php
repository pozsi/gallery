<?php

require_once('Config.php');

class LiveConfig extends Config {

    public $appPath = '/www/pozsi.com/gallery2/';
    public $appUrl = 'http://pozsi.com/gallery2/';

    function __construct() {
        $this->adminPath = $this->appPath . 'admin/';
        $this->adminUrl = $this->appUrl . 'admin/';
        $this->galleryDataPath = $this->adminPath . "galleries/";
        $this->templatePath = $this->adminPath . 'templates/';
    }

}
