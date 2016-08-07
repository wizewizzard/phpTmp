<?php

namespace Controllers\Admin;

class index extends \Controllers\skeleton {

    public function actionindex() {

        $this->setTemplate('index.tpl');
        $this->setTitle('Административная панель');
    }
}
