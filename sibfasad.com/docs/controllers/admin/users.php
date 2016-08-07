<?php

namespace Controllers\Admin;

class users extends \Controllers\skeleton {

    public function actionindex() {
        global $dbLink;

        // Set current menu
        $active = 'users';
        
        $users = [];
        $sql = 'SELECT id, name, mail
            FROM users
            WHERE id != 1
            ORDER BY name ASC';
        $result = mysqli_query($dbLink, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $users[$row['id']] = $row;
            unset($row);
        }
        mysqli_free_result($result);
        unset($sql, $result);

        $this->template->assign('users', $users);
        $this->template->assign('active', $active);
        $this->setTemplate('users.tpl');
    }

    public function actionmanage($args) {
        global $dbLink;

        // Set current menu
        $active = 'users';
        $id = (int) array_shift($args);

        if ($_REQUEST) {

            $data = [
                'name'          => $_REQUEST['name'],
                'mail'          => $_REQUEST['mail'],
                'password'      => $_REQUEST['new_pass'],
            ];


            if ($data['password'] === '') {
                unset($data['password']);
            } else {
                $data['password'] = sha1($data['password']);
            }

            // Update or insert new object
            if ($id === 0) {
                // Insert
                $sqlFields = $sqlValues = [];
                foreach ($data as $fieldName => $fieldValue) {

                    $sqlFields[] = $fieldName;
                    $sqlValues[] = mysqli_real_escape_string($dbLink, $fieldValue);

                    unset($fieldName, $fieldValue);
                }

                $sql = 'INSERT INTO users (' . implode(', ', $sqlFields) . ')
                    VALUES (\'' . implode('\', \'', $sqlValues) . '\')';

                unset($sqlFields, $sqlValues);
            } else {

                // Update
                $sqlFields = [];
                foreach ($data as $fieldName => $fieldValue) {

                    $fieldValue = mysqli_real_escape_string($dbLink, $fieldValue);

                    $sqlFields[] = sprintf(
                        '%1$s = \'%2$s\'',
                        $fieldName,
                        $fieldValue
                    );
                    unset($fieldName, $fieldValue);
                }

                $sql = 'UPDATE users
                    SET ' . implode(', ', $sqlFields) . '
                    WHERE id = ' . $id;

                unset($sqlFields);
            }

            mysqli_query($dbLink, $sql);
            header('location: /admin/users');
            exit;
        } 

        // Prepare varibles
        $user = [
            'name'          => '',
            'mail'          => '',
        ];

        if ($id === 0) {
            // Add user
            $this->template->assign('header', 'Добавление пользователя');
            $this->setTemplate('userManage.tpl');
            $this->setTitle('Добавление пользователя');
        } else {
            // Manage user
            // Check if partner exists
            $sql = 'SELECT name, mail FROM users WHERE id = ' . (int) $id;
            $result = mysqli_query($dbLink, $sql);
            if (($user = mysqli_fetch_assoc($result)) === null) {
                $this->setTemplate('error.tpl');
                $this->setHeader('404 Not Found');
                $this->setTitle('Страница не найдена');
            } else {
                $this->template->assign('header', 'Редактирование пользователя');
                $this->setTemplate('userManage.tpl');
                $this->setTitle('Редактирование пользователя');
            }
        }

        $this->template->assign('user', $user);
        $this->template->assign('id', $id);

        $this->template->assign('active', $active);
    }

    public function actiondelete($args) {
        global $dbLink;

        $id = (int) array_shift($args);

        $sql = 'DELETE FROM users WHERE id =' . $id;
        mysqli_query($dbLink, $sql);

        header('location: /admin/users');
        exit;
    }

    public function actionpasscheck() {
        global $dbLink;

        $return = [];
        $id = $_POST['id'];
        $currentPass = $_POST['pass'];
        $sql = 'SELECT password FROM users WHERE id =' . $id;
        $result = mysqli_query($dbLink, $sql);
        $userPass = mysqli_fetch_assoc($result);

        if (sha1($currentPass) == $userPass['password']) {
            $return['message'] = 'success'; 
        } else {
            $return['message'] = 'error';
        }

        echo json_encode($return);
        exit();
    }
}