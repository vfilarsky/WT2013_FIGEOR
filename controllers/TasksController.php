<?php

namespace Figeor\Controller;

use Figeor\Core\View;

class TasksController extends AbstractController {

    protected function view() {
        if (isset($_GET['id'])) {
            $view = new View('tasks/view.php');
            $ret = array();
            $ret['title'] = 'Detail úlohy';
            $ret['main'] = $view->renderToString();
            return $ret;
        } else {
            $view = new View('tasks/list.php');
            $ret = array();
            $ret['title'] = 'Zoznam všetkých úloh na ' . $_GET['days'] . ' dní';
            $ret['main'] = $view->renderToString();
            return $ret;
        }
    }

    protected function newForm() {
        $view = new View('tasks/newForm.php');
        $ret = array();
        $ret['title'] = 'Pridať úlohu';
        $ret['main'] = $view->renderToString();
        return $ret;
    }

}
