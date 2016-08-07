<?php

namespace Controllers\Admin;

class objects extends \Controllers\skeleton {

    public function actionindex() {
        global $dbLink;

        // Set current menu
        $active = 'objects';

        $search = '';
        $whereClause = '';
        $objects = [];

        // Fetch products
        if (
            isset($_REQUEST['search']) &&
            $_REQUEST['search'] !== ''
        ) {
            $search = $_REQUEST['search'];
            $_search = trim(mysqli_real_escape_string($dbLink, $search));
            $whereClause = 'WHERE name LIKE \'%' . $search . '%\'';
            unset($_search);
        }
        $sql = 'SELECT id, name, show_object
            FROM objects
            ' . (($whereClause !== '') ? $whereClause : '') . '
            ORDER BY name ASC';
        $result = mysqli_query($dbLink, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $objects[$row['id']] = $row;
            unset($row);
        }
        mysqli_free_result($result);
        unset($sql, $result);
        
        $this->template->assign('objects', $objects);
        $this->template->assign('active', $active);
        $this->setTemplate('objects.tpl');
    }

    public function actionmanage($args) {
        global $dbLink;

        // Set current menu
        $active = 'objects';
        $id = (int) array_shift($args);

        if (isset($_REQUEST['name']) === true && $_REQUEST['name'] != '') {

            // Add new object

            // Prepare varibles
            $data = [
                'name'          => '',
                'description'   => '',
                'participiants' => '',
                'technologies'  => '',
                'category'      => 0,
                'show_object'   => false,

                'photos' => [],
            ];
            foreach ($data as $fieldName => $fieldDefault) {
                if (isset($_REQUEST[$fieldName]) === true) {
                    $data[$fieldName] = $_REQUEST[$fieldName];
                    settype($data[$fieldName], gettype($fieldDefault));
                }
                unset($fieldName, $fieldDefault);
            }

            // Upload photos if submited
            if (
                isset($_FILES['photos']['tmp_name']) === true &&
                $_FILES['photos']['tmp_name'][0] !== ''
            ) {
                // Make dir if doesn't exist
                if (!file_exists(UPLOADS_PATH . '/objectPhotos')) {
                    mkdir(UPLOADS_PATH . '/objectPhotos', 0777, true);
                }
                foreach ($_FILES['photos']['tmp_name'] as $tempId => $tempName) {
                    $photoName = sha1($tempName . time()) . '.jpg';
                    move_uploaded_file($_FILES['photos']['tmp_name'][$tempId], UPLOADS_PATH . '/objectPhotos/' . $photoName);
                    $data['photos'][] = $photoName;
                }
            }

            // Update or insert new object
            if ($id === 0) {
                // Insert
                $sqlFields = $sqlValues = [];
                foreach ($data as $fieldName => $fieldValue) {
                    // Serialize arrays
                    if (gettype($fieldValue) === 'array') {
                        $fieldValue = serialize($fieldValue);
                    }

                    $sqlFields[] = $fieldName;
                    $sqlValues[] = mysqli_real_escape_string($dbLink, $fieldValue);

                    unset($fieldName, $fieldValue);
                }

                $sql = 'INSERT INTO objects (' . implode(', ', $sqlFields) . ')
                    VALUES (\'' . implode('\', \'', $sqlValues) . '\')';

                unset($sqlFields, $sqlValues);
            } else {

                // Prepare photos array
                $sql =  'SELECT photos FROM objects WHERE id = ' . $id;
                $result = mysqli_query($dbLink, $sql);
                $_photos = mysqli_fetch_assoc($result);
                if ($_photos['photos'] !== '') {
                    $photos = unserialize($_photos['photos']);
                    $data['photos'] = array_merge($data['photos'], $photos);
                }   

                // Update
                $sqlFields = [];
                foreach ($data as $fieldName => $fieldValue) {
                    // Serialize arrays
                    if (gettype($fieldValue) === 'array') {
                        $fieldValue = serialize($fieldValue);
                    }

                    $fieldValue = mysqli_real_escape_string($dbLink, $fieldValue);

                    $sqlFields[] = sprintf(
                        '%1$s = \'%2$s\'',
                        $fieldName,
                        $fieldValue
                    );
                    unset($fieldName, $fieldValue);
                }

                $sql = 'UPDATE objects
                    SET ' . implode(', ', $sqlFields) . '
                    WHERE id = ' . $id;

                unset($sqlFields);
            }

            mysqli_query($dbLink, $sql);
            header('location: /admin/objects');
            exit;
        }

        $object = [
            'name'          => '',
            'description'   => '',
            'participiants' => '',
            'technologies'  => '',
            'photos'        => '',
            'category'      => '',
            'show_object'   => true,
        ];

        if ($id === 0) {
            // Add products

            $this->template->assign('header', 'Добавление объекта');
            $this->setTemplate('objectManage.tpl');
            $this->setTitle('Добавление объекта');
        } else {
            // Manage product

            // Check if object exists
            $sql = 'SELECT * FROM objects WHERE id = ' . (int) $id;
            $result = mysqli_query($dbLink, $sql);
            if (($object = mysqli_fetch_assoc($result)) === null) {
                $this->setTemplate('error.tpl');
                $this->setHeader('404 Not Found');
                $this->setTitle('Страница не найдена');
            } else {
                $this->template->assign('header', 'Редактирование объекта');
                $this->setTemplate('objectManage.tpl');
                $this->setTitle('Редактирование объекта');
            }
        }
        // Prepare photos to display if needed
        if ($object['photos'] != '') {
            $object['photos'] = unserialize($object['photos']);
        }

        $this->template->assign('object', $object);
        $this->template->assign('id', $id);
        $this->template->assign('active', $active);
        
    }

    public function actiondelete($args) {
        global $dbLink;

        $id = (int) array_shift($args);

        // Remove photos from uploads
        $sql = 'SELECT photos FROM objects WHERE id =' . $id;
        $result = mysqli_query($dbLink, $sql);
        $_photos = mysqli_fetch_assoc($result);
        if ($_photos['photos'] !== '' ||
            $_photos['photos'] !== 'a:0:{}') {
            $photos = unserialize($_photos['photos']);
            foreach ($photos as $photoId => $name) {
                unlink(UPLOADS_PATH . '/objectPhotos/' . $name);
                unlink(UPLOADS_PATH . '/objectPhotos/thumbs/' . $name);
            }
            mysqli_free_result($result);
            unset($sql, $result);
        }

        $sql = 'DELETE FROM objects WHERE id =' . $id;
        mysqli_query($dbLink, $sql);

        // @todo delete photos

        header('location: /admin/objects');
        exit;
    }

    public function actionajax() {
        global $dbLink;

        $id = $_POST['id'];
        $photo = $_POST['photo'];
        $sql = 'SELECT photos FROM objects WHERE id =' . $id;
        $result = mysqli_query($dbLink, $sql);
        $_photos = mysqli_fetch_assoc($result);
        $photos = unserialize($_photos['photos']);
        foreach ($photos as $key => $name) {
            if ($name == $photo) { 
                unset($photos[$key]);
            }
        }
        $photos = serialize($photos);
        if ($photos == 'a:0:{}') {
            $photos = '';
        }
        $sql = 'UPDATE objects set photos = \'' . $photos . '\' WHERE id =' . $id;
        mysqli_query($dbLink, $sql); 
        unlink(UPLOADS_PATH . '/objectPhotos/' . $photo);
        unlink(UPLOADS_PATH . '/objectPhotos/thumbs/' . $photo);
    }
}
