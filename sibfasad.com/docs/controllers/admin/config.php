<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 09.08.2016
 * Time: 23:57
 */

namespace Controllers\Admin;


class config  extends \Controllers\skeleton
{
    public function actionindex() {
        global $dbLink;

        // Set current menu
        $active = 'config';

        $config = [];
        $sql = 'SELECT * FROM config';
        $result = mysqli_query($dbLink, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $config[$row['id']] = $row;
            unset($row);
        }
        mysqli_free_result($result);
        unset($sql, $result);

        $this->template->assign('config', $config);
        $this->template->assign('active', $active);
        $this->setTemplate('config.tpl');
    }

    public function actionmanage($args) {
        global $dbLink;

        // Set current menu
        $active = 'config';
        $id = (int) array_shift($args);

        if ($_REQUEST) {

            $data = [
                'value'          => $_REQUEST['value'],
            ];

            // Update or insert new object
            if ($id === 0) {
                $this->setTemplate('error.tpl');
                $this->setHeader('404 Not Found');
                $this->setTitle('Страница не найдена');
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

                $sql = 'UPDATE config
                    SET ' . implode(', ', $sqlFields) . '
                    WHERE id = ' . $id;

                unset($sqlFields);
            }

            mysqli_query($dbLink, $sql);
            header('location: /admin/config');
            exit;
        }

        // Prepare varibles
        $config = [
            'value'          => '',
        ];

        if ($id === 0) {
            $this->setTemplate('error.tpl');
            $this->setHeader('404 Not Found');
            $this->setTitle('Страница не найдена');
        } else {
            // Manage user
            // Check if partner exists
            $sql = 'SELECT * FROM config WHERE id = ' . (int) $id;
            $result = mysqli_query($dbLink, $sql);
            if (($config = mysqli_fetch_assoc($result)) === null) {
                $this->setTemplate('error.tpl');
                $this->setHeader('404 Not Found');
                $this->setTitle('Страница не найдена');
            } else {
                $this->template->assign('header', 'Редактирование настройки');
                $this->setTemplate('configManage.tpl');
                $this->setTitle('Редактирование настройки');
            }
        }

        $this->template->assign('config', $config);
        $this->template->assign('id', $id);

        $this->template->assign('active', $active);
    }
}