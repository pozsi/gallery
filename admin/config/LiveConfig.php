<?php

require_once('Config.php');

class LiveConfig extends Config {

    public $appPath = '/www/pozsi.com/gallery2/';

    function __construct() {
        $this->adminPath = $this->appPath . 'admin/';
        $this->templatePath = $this->adminPath . 'templates/';
    }

}
