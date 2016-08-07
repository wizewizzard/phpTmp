<?php

namespace Controllers\Admin;
require_once ROOT_PATH . '/vendor/phpthumb/ThumbLib.inc.php';

class certificates extends \Controllers\skeleton {

    public function actionindex() {
        global $dbLink;

        // Set current menu
        $active = 'certificates';
        
        $search = '';
        $whereClause = '';
        $certificates = [];

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
        $sql = 'SELECT *
            FROM certificates
            ' . (($whereClause !== '') ? $whereClause : '') . '
            ORDER BY id DESC';
        $result = mysqli_query($dbLink, $sql);
        if ($result != false) {
            while ($row = mysqli_fetch_assoc($result)) {
                $certificates[$row['id']] = $row;
                unset($row);
            }
            mysqli_free_result($result);
        }
        unset($sql, $result);

        $this->template->assign('certificates', $certificates);
        $this->template->assign('active', $active);
        $this->setTemplate('certificates.tpl');
    }

    public function actionmanage($args) {
        global $dbLink;

        // Set current menu
        $active = 'certificates';
        $id = (int) array_shift($args);

        if (isset($_REQUEST['name']) === true && $_REQUEST['name'] != '') {
            // Add new certificate

            // Prepare varibles
            $data = [
                'name'        => '',
                'photo'       => '',
            ];
            foreach ($data as $fieldName => $fieldDefault) {
                if (isset($_REQUEST[$fieldName]) === true) {
                    $data[$fieldName] = $_REQUEST[$fieldName];
                    settype($data[$fieldName], gettype($fieldDefault));
                }
                unset($fieldName, $fieldDefault);
            }

            // Upload photo if submited
            if (
                isset($_FILES['photo']['tmp_name']) === true &&
                $_FILES['photo']['tmp_name'] !== ''
            ) {
                // Make dir if doesn't exist
                if (!file_exists(UPLOADS_PATH . '/certificates')) {
                    mkdir(UPLOADS_PATH . '/certificates', 0777, true);
                }
                // Make dir if doesn't exist
                if (!file_exists(UPLOADS_PATH . '/certificates/thumbs')) {
                    mkdir(UPLOADS_PATH . '/certificates/thumbs', 0777, true);
                }
                $tempName = $_FILES['photo']['tmp_name'];
                $photoName = sha1($tempName . time()) . '.jpg';
                move_uploaded_file($_FILES['photo']['tmp_name'], UPLOADS_PATH . '/certificates/' . $photoName);
                $thumb = \PhpThumbFactory::create(UPLOADS_PATH . '/certificates/' . $photoName);
                $thumb->adaptiveResize(300, 425);
                $thumb->save(UPLOADS_PATH . '/certificates/thumbs/' . $photoName);
                $data['photo'] = $photoName;
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

                $sql = 'INSERT INTO certificates (' . implode(', ', $sqlFields) . ')
                    VALUES (\'' . implode('\', \'', $sqlValues) . '\')';

                unset($sqlFields, $sqlValues);
            } else {
                // Update

                // Prepare logo and photo
                $sql =  'SELECT photo FROM certificates WHERE id = ' . $id;
                $result = mysqli_query($dbLink, $sql);
                $_photo = mysqli_fetch_assoc($result);

                // Delete old photo if submited a new one
                if ($_photo['photo'] !== '' &&
                    $data['photo'] !== '') {
                    unlink(UPLOADS_PATH . '/certificates/' . $_photo['photo']);
                    unlink(UPLOADS_PATH . '/certificates/thumbs' . $_photo['photo']);
                } elseif ($data['photo'] == '') {
                    $data['photo'] = $_photo['photo'];
                }

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

                $sql = 'UPDATE certificates
                    SET ' . implode(', ', $sqlFields) . '
                    WHERE id = ' . $id;

                unset($sqlFields);
            }
            mysqli_query($dbLink, $sql);
            header('location: /admin/certificates');
            exit;
        }

        // Prepare varibles
        $certificate = [
            'name'        => '',
            'photo'       => '',
        ];

        if ($id === 0) {
            // Add employee
            $this->template->assign('header', 'Добавление диплома');
            $this->setTemplate('certificateManage.tpl');
            $this->setTitle('Добавление диплома');
        } else {
            // Manage employee
            // Check if employee exists
            $sql = 'SELECT * FROM certificates WHERE id = ' . (int) $id;
            $result = mysqli_query($dbLink, $sql);
            if (($certificate = mysqli_fetch_assoc($result)) === null) {
                $this->setTemplate('error.tpl');
                $this->setHeader('404 Not Found');
                $this->setTitle('Страница не найдена');
            } else {
                $this->template->assign('header', 'Редактирование диплома');
                $this->setTemplate('certificateManage.tpl');
                $this->setTitle('Редактирование диплома');
            }
        }

        $this->template->assign('certificate', $certificate);
        $this->template->assign('active', $active);
    }

    public function actiondelete($args) {
        global $dbLink;

        $id = (int) array_shift($args);

        // Get photo name to delete 
        $sql = 'SELECT photo FROM certificates WHERE id =' . $id;
        $result = mysqli_query($dbLink, $sql);
        $photo = mysqli_fetch_assoc($result);

        // Delete photo and thumb
        if ($photo['photo'] != '') {
            unlink(UPLOADS_PATH . '/certificates/' . $photo['photo']);
            unlink(UPLOADS_PATH . '/certificates/thumbs/' . $photo['photo']);
        }

        $sql = 'DELETE FROM certificates WHERE id =' . $id;
        mysqli_query($dbLink, $sql);

        header('location: /admin/certificates');
        exit;
    }
}
