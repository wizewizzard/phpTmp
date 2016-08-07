<?php

namespace Controllers\Admin;

class brands extends \Controllers\skeleton {

    public function actionindex() {
        global $dbLink;

        $active = 'brands';
        $search = '';
        $whereClause = '';
        $brands = [];

        if (
            isset($_REQUEST['search']) &&
            $_REQUEST['search'] !== ''
        ) {
            $search = $_REQUEST['search'];
            $_search = trim(mysqli_real_escape_string($dbLink, $search));
            $whereClause = 'WHERE name LIKE \'%' . $search . '%\'';
            unset($_search);
        }
        $sql = 'SELECT *
            FROM brands
            ' . (($whereClause !== '') ? $whereClause : '');
        $result = mysqli_query($dbLink, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $brands[$row['id']] = $row['name'];
            unset($row);
        }
        mysqli_free_result($result);
        unset($sql, $result);

        $this->template->assign('brands', $brands);
        $this->template->assign('search', $search);
        $this->template->assign('active', $active);
        $this->setTemplate('brands.tpl');
    }

    public function actionmanage($args) {
        global $dbLink;

        $active = 'brands';
        $id = (int) array_shift($args);

        // Update brand if exists
        if (
            isset($_REQUEST['name']) === true &&
            (isset($_REQUEST['id']) === true && $_REQUEST['id'] !== '')
            ) {

            // Escape values
            $brandName = mysqli_real_escape_string($dbLink, $_REQUEST['name']);
            $brandId = mysqli_real_escape_string($dbLink, $_REQUEST['id']);

            $sql = 'UPDATE brands SET name = \'' . $brandName . '\' WHERE id = ' . $brandId;
            mysqli_query($dbLink, $sql);
            header('location: /admin/brands');
        } elseif (isset($_REQUEST['name']) === true) {

            // Add new brand 
            $brandName = mysqli_real_escape_string($dbLink, $_REQUEST['name']);
            $sql = 'INSERT INTO brands VALUES(\'\' ,\'' . $brandName . '\')';
            mysqli_query($dbLink, $sql);
            header('location: /admin/brands');
            exit;
        }

        if ($id === 0) {
            // Add product

            $this->template->assign('header', "Добавление бренда");
            $this->setTemplate('brandManage.tpl');
            $this->setTitle('Добавление бренда');
        } else {
            // Manage product

            // Escape and prepare varibles for login
            $id = mysqli_real_escape_string($dbLink, $id);

            // Check if product exists
            $sql = 'SELECT * FROM brands WHERE id = ' . $id;
            $result = mysqli_query($dbLink, $sql);
            if (($row =mysqli_fetch_assoc($result)) == null) {
                $this->setTemplate('error.tpl');
                $this->setHeader('404 Not Found');
                $this->setTitle('Страница не найдена');
            } else{
                $this->template->assign('id', $row['id']);
                $this->template->assign('name', $row['name']);
                $this->template->assign('header', "Редактирование бренда");
                $this->setTemplate('brandManage.tpl');
                $this->setTitle('Редактирование бренда');
            }
        }
        $this->template->assign('active', $active);
    }

    public function actiondelete($args) {
        global $dbLink;

        $id = (int) array_shift($args);

        $sql = 'DELETE FROM brands WHERE id =' . $id;
        mysqli_query($dbLink, $sql);

        header('location: /admin/brands');
        exit;
    }
}
