<?php

namespace Controllers;

class error extends \Controllers\skeleton {

    function action404() {
        $this->setHeader('404 Not Found');

        $this->setTemplate('error.tpl');
        $this->setTitle('Страница не найдена');
    }
}
