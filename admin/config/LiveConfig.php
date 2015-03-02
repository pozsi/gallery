<?php

require_once('Config.php');

class LiveConfig extends Config {

    function __construct($host) {
        $this->host = $host;
        $this->appPath = '/www/' . $this->host . 'b4.hu/';
        $this->appUrl = 'http://' . $this->host . '.b4.hu/';
        $this->adminPath = '/www/b4.hu/admin/';
        $this->adminUrl = 'http://b4.hu/admin/';
        $this->galleryDataPath = $this->adminPath . "galleries/" . $this->host . '/';
        $this->templatePath = $this->adminPath . 'view/';
        $this->customTemplatePath = $this->adminPath . 'view/' . $this->host . '/';
    }

}
