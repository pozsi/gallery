<?php

require_once('Config.php');

class LiveConfig extends Config {

    function __construct($host) {
        $this->appPath = '/www/b4.hu/';
        $this->appUrl = 'http://' . $host . '.b4.hu/';
        $this->hostDir = $host . '/';
        $this->adminPath = $this->appPath . 'admin/';
        $this->adminUrl = $this->appUrl . 'admin/';
        $this->galleryDataPath = $this->adminPath . $this->hostDir ."galleries/";
        $this->templatePath = $this->adminPath . 'view/';
        $this->customTemplatePath = $this->adminPath . 'view/' . $this->hostDir;
    }

}
