<?php

class View {

    private $config;

    public function __construct(Config $config) {
        $this->config = $config;
    }

    function render($template, $params) {
        ob_start();
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        include($this->config->templatePath.$template);
        return ob_get_clean();
    }

} 