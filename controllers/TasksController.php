<?php

namespace Figeor\Controller;

use Figeor\Core\View;

class TasksController extends AbstractController {

    protected function view() {
        $view = new View('tasks/view.php');
        $ret = array();
        $ret['title'] = 'Zoznam úloh';
        $ret['main'] = $view->renderToString();
        return $ret;
    }

}
