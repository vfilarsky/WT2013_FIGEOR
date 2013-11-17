<?php

namespace Figeor\Controller;

class AbstractController {

    protected $action = null;
    protected $defaultAction = '';

    public final function doAction($action) {
        if (method_exists($this, $action)) {
            $methodName = $action;
        } else {
            $methodName = $this->defaultAction;
        }
        return $this->{$methodName}();
    }

}

