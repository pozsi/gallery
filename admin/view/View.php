<?php
/**
 * Created by IntelliJ IDEA.
 * User: pozsi
 * Date: 11/19/14
 * Time: 11:18 PM
 */

class View {

    private $config;

    public function __construct(Config $config) {
        $this->config = $config;
    }

    function render($template, $params) {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        include($this->config->templatePath.$template);
    }
} 