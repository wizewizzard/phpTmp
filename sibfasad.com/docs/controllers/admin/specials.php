<?php

namespace Controllers\Admin;

class specials extends \Controllers\skeleton {

    public function actionindex() {
        global $dbLink;

        $active = 'specials';
        $search = '';
        $whereClause = '';
        $specials = [];

        $sql = 'SELECT *
            FROM specials
            ' . (($whereClause !== '') ? $whereClause : '');
        $result = mysqli_query($dbLink, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $specials[$row['id']] = $row;
            unset($row);
        }

        mysqli_free_result($result);
        unset($sql, $result);

        $this->template->assign('specials', $specials);
        $this->template->assign('active', $active);
        $this->setTemplate('specials.tpl');
    }

    public function actionmanage($args) {
        global $dbLink;

        $active = 'specials';
        $id = (int) array_shift($args);

        // Update brand if exists
        if (isset($_REQUEST['title']) === true) {

            $data = [
                'title' => '',
                'link'  => '',
                'photo' => '',
                'descr' => '',
                'price' => '',
                'active' => 0,
            ];
            foreach ($data as $fieldName => $fieldDefault) {
                if (isset($_REQUEST[$fieldName]) === true) {
                    $data[$fieldName] = $_REQUEST[$fieldName];
                    settype($data[$fieldName], gettype($fieldDefault));
                }
                unset($fieldName, $fieldDefault);
            }

            // Upload photo if submited
            $specialPhoto = '';
            if (
                isset($_FILES['specialPhoto']['tmp_name']) === true &&
                $_FILES['specialPhoto']['tmp_name'] !== ''
            ) {
                $data['photo'] = sha1(time()) . '.jpg';
                move_uploaded_file($_FILES['specialPhoto']['tmp_name'], UPLOADS_PATH . '/specialPhotos/' . $data['photo']);
            }            

            // Update or insert new product
            if ($id === 0) {
                // Insert
                $sqlFields = $sqlValues = [];
                foreach ($data as $fieldName => $fieldValue) {
                    $sqlFields[] = $fieldName;
                    $sqlValues[] = mysqli_real_escape_string($dbLink, $fieldValue);

                    unset($fieldName, $fieldValue);
                }

                $sql = 'INSERT INTO specials (' . implode(', ', $sqlFields) . ')
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

                $sql = 'UPDATE specials
                    SET ' . implode(', ', $sqlFields) . '
                    WHERE id = ' . $id;
            }

            mysqli_query($dbLink, $sql);
            header('location: /admin/specials');
            exit;
        }

        $special = [
                'title'  => '',
                'link'   => '',
                'photo'  => '',
                'descr'  => '',
                'price'  => '',
                'active' => 1,
            ];

        if ($id === 0) {
            // Add product

            $this->template->assign('header', "Добавление спецпредложения");
            $this->setTemplate('specialManage.tpl');
            $this->setTitle('Добавление спецпредложения');
        } else {
            // Manage product

            // Escape and prepare varibles for login
            $id = mysqli_real_escape_string($dbLink, $id);

            // Check if product exists
            $sql = 'SELECT * FROM specials WHERE id = ' . $id;
            $result = mysqli_query($dbLink, $sql);
            if (($special =mysqli_fetch_assoc($result)) == null) {
                $this->setTemplate('error.tpl');
                $this->setHeader('404 Not Found');
                $this->setTitle('Страница не найдена');
            } else{
                $this->template->assign('id', $special['id']);
                $this->template->assign('header', "Редактирование спецпредложения");
                $this->setTemplate('specialManage.tpl');
                $this->setTitle('Редактирование спецпредложения');
            }
        }

        $this->template->assign('special', $special);
        $this->template->assign('active', $active);
    }

    public function actiondelete($args) {
        global $dbLink;

        $id = (int) array_shift($args);

        $sql = 'DELETE FROM specials WHERE id =' . $id;
        mysqli_query($dbLink, $sql);

        header('location: /admin/specials');
        exit;
    }
}
