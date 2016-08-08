<?php

namespace Controllers\Admin;

class login extends \Controllers\skeleton {

    public function actionindex() {
        // Redirect to admin index if user already logged in
        global $dbLink;
        if (
            isset($_SESSION['logged_in']) == true &&
            $_SESSION['logged_in'] === true
        ) { 
            header('Location: /admin');
            exit;
        }
        $errors = [];


        // Connect DB
        if (isset($_POST['login']) !== false) {
            if ($dbLink === false) {
                die("Error " . mysqli_error($dbLink));
            } else {

                // Set charset
                mysqli_set_charset($dbLink, 'utf8');

                // Escape and prepare varibles for login
                $login = mysqli_real_escape_string($dbLink, $_POST['login']);
                $password = $_POST['password'];
                $sql = 'SELECT * FROM users WHERE name = "' . $login . '"';
                if (($result = mysqli_query($dbLink, $sql)) === false) {
                    $errors[] = 'Неверный логин и/или пароль.';
                } else {
                    $user = mysqli_fetch_assoc($result);
                    if (sha1($_POST['password']) === $user['password']) {
                        $_SESSION['logged_in'] = true;
                        header('Location: /admin');
                        exit;
                    } else {
                        $errors[] = 'Неверный логин и/или пароль.';
                    }
                }
            }
        }

        // Send error if need
        $this->template->assign('errors', implode('<br>', $errors));

        $this->setTemplate('login.tpl');
        $this->setTitle('Вход');
    }
}
