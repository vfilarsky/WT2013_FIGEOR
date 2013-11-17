<?php

namespace Figeor\Core;

class View {

    private $template;
    private $data;

    public function __construct($template) {
        $this->template = $template;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function renderToString() {
        $fname = 'views/';
        $fname .= $this->template;
        if (file_exists($fname)) {
            include $fname;
        }
    }

}

