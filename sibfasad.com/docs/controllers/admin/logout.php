<?php

namespace Controllers\Admin;

class logout extends \Controllers\skeleton {

    public function actionindex() {
        $_SESSION['logged_in'] = false;
        header('Location: /');
        exit;
    }
}
