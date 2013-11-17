<?php

namespace Figeor\Controller;

use Figeor\Core\View;

class IndexController extends AbstractController {

    public function __construct() {
        $this->defaultAction = 'login';
    }

    protected function login() {
        $view = new View('index/login.php');
        $ret = array();
        $ret['title'] = 'Prihlasovací formulár';
        $ret['main'] = $view->renderToString();
        return $ret;
    }

}

