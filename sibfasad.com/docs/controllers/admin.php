<?php

namespace Controllers;

class admin extends skeleton {
    public function __call($name, $args)
    {
        $args = $args[0];
        array_unshift($args, $name);
        call_user_func_array([$this, 'actionindex'], $args);
    }

    public function actionindex() {
        /*
        * Change templates path
        */
        $this->template->setTemplateDir(TEMPLATES_PATH . '/admin/');

        /*
        * Router O_o
        */
        $args = func_get_args();

        // Parse URI
        $uriTokens = array_filter($args);

        // Catch admin controller options
        $controllerName = array_shift($uriTokens);
        $controllerAction = array_shift($uriTokens);

        // Set default controller name if need
        if ($controllerName === null) {
            $controllerName = 'index';
        } elseif (strpos($controllerName, 'action') === 0) {
            $controllerName = substr($controllerName, 6);
        }

        // Prevent possible attacks
        if (strpos($controllerName, '..') !== false) {
            die('Hacking attempt!');
        }

        /*
        * Check logged in state or redirect to login
        */
        if (
            isset($_SESSION['logged_in']) === false ||
            $_SESSION['logged_in'] === false
        ) {
            $controllerName   = 'login';
            $controllerAction = 'index';
        }

        // Check that controller exists
        if (file_exists(CONTROLLERS_PATH . '/admin/' . $controllerName . '.php') === false) {
            $controllerName = 'error';
            $controllerAction = '404';
        }

        // Load controller
        require(CONTROLLERS_PATH . '/admin/' . $controllerName . '.php');
        $controllerClass = '\\Controllers\\Admin\\' . $controllerName;
        $controllerObject = new $controllerClass;
        $controllerObject->setTemplateObject($this->template);

        // Check that specified action exists or set "index" as default action
        if (method_exists($controllerObject, 'action' . $controllerAction) === false) {
            if ($controllerName === 'error') {
                $controllerAction = '404';
            } else {    
                $controllerAction = 'index';
            }
        }

        // Call specified action
        call_user_func([$controllerObject, 'action' . $controllerAction], $uriTokens);

        if (isset($_SESSION['logged_in']) !== false) {
            $this->template->assign('logged_in', $_SESSION['logged_in']);
        } else {
            $this->template->assign('logged_in', false);
        } 
        $this->setTemplate($controllerObject->getTemplate());
    }
}
