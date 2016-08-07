<?php

namespace Controllers\Admin;
require_once ROOT_PATH . '/vendor/phpthumb/ThumbLib.inc.php';

class services extends \Controllers\skeleton {

    public function actionindex() {
        global $dbLink;

        $active = 'services';
        $services = [];

        $sql = 'SELECT *
            FROM services';
        $result = mysqli_query($dbLink, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $services[$row['name']] = $row;
            unset($row);
        }

        mysqli_free_result($result);
        unset($sql, $result);

        $this->template->assign('services', $services);
        $this->template->assign('active', $active);
        $this->setTemplate('services.tpl');
    }

    public function actionmanage($args) {
        global $dbLink;

        $active = 'specials';
        $name = array_shift($args);

        // Update service if set
        if ($_REQUEST) {

            $data = [
                'slide1' => '',
                'slide2' => '',
                'slide3' => '',
                'text'   => '',

            ];
            foreach ($data as $fieldName => $fieldDefault) {
                if (isset($_REQUEST[$fieldName]) === true) {
                    $data[$fieldName] = $_REQUEST[$fieldName];
                    settype($data[$fieldName], gettype($fieldDefault));
                }
                unset($fieldName, $fieldDefault);
            }

            // Upload slides if submited
            // Make sure the upload folder exists
            if (!file_exists(UPLOADS_PATH . '/slides')) {
                mkdir(UPLOADS_PATH . '/slides', 0777, true);
            }
            $slide1 = '';
            if (
                isset($_FILES['slide1']['tmp_name']) === true &&
                $_FILES['slide1']['tmp_name'] !== ''
            ) {
                $tempName = $_FILES['slide1']['tmp_name'];
                $slide1 = sha1($tempName . time()) . '.jpg';
                move_uploaded_file($_FILES['slide1']['tmp_name'], UPLOADS_PATH . '/slides/' . $slide1);
                // Resize slides to fit slider
                $pathToImages = UPLOADS_PATH . '/slides/';
                $thumb = \PhpThumbFactory::create($pathToImages . $slide1);
                $thumb->adaptiveResize(940, 450);
                $thumb->save($pathToImages . $slide1);
                $data['slide1'] = $slide1;
            }    
            $slide2 = '';
            if (
                isset($_FILES['slide2']['tmp_name']) === true &&
                $_FILES['slide2']['tmp_name'] !== ''
            ) {
                $tempName = $_FILES['slide2']['tmp_name'];
                $slide2 = sha1($tempName . time()) . '.jpg';
                move_uploaded_file($_FILES['slide2']['tmp_name'], UPLOADS_PATH . '/slides/' . $slide2);
                // Resize slides to fit slider
                $pathToImages = UPLOADS_PATH . '/slides/';
                $thumb = \PhpThumbFactory::create($pathToImages . $slide2);
                $thumb->adaptiveResize(940, 450);
                $thumb->save($pathToImages . $slide2);
                $data['slide2'] = $slide2;
            }    
            $slide3 = '';
            if (
                isset($_FILES['slide3']['tmp_name']) === true &&
                $_FILES['slide3']['tmp_name'] !== ''
            ) {
                $tempName = $_FILES['slide3']['tmp_name'];
                $slide3 = sha1($tempName . time()) . '.jpg';
                move_uploaded_file($_FILES['slide3']['tmp_name'], UPLOADS_PATH . '/slides/' . $slide3);
                // Resize slides to fit slider
                $pathToImages = UPLOADS_PATH . '/slides/';
                $thumb = \PhpThumbFactory::create($pathToImages . $slide3);
                $thumb->adaptiveResize(940, 450);
                $thumb->save($pathToImages . $slide3);
                $data['slide3'] = $slide3;
            }         

            // Insert not used, commented for further hypothetical changes
            // if ($id === 0) {
            //     // Insert
            //     $sqlFields = $sqlValues = [];
            //     foreach ($data as $fieldName => $fieldValue) {
            //         $sqlFields[] = $fieldName;
            //         $sqlValues[] = mysqli_real_escape_string($dbLink, $fieldValue);

            //         unset($fieldName, $fieldValue);
            //     }

            //     $sql = 'INSERT INTO services (' . implode(', ', $sqlFields) . ')
            //         VALUES (\'' . implode('\', \'', $sqlValues) . '\')';

            //     unset($sqlFields, $sqlValues);
            // } else {

            // Prepare slides
            $sql =  'SELECT slide1, slide2, slide3 FROM services WHERE name = \'' . $name . '\'';
            $result = mysqli_query($dbLink, $sql);
            $_slides = mysqli_fetch_assoc($result);
            if ($data['slide1'] == '') {
                $data['slide1'] = $_slides['slide1'];
            }
            if ($data['slide2'] == '') {
                $data['slide2'] = $_slides['slide2'];
            }
            if ($data['slide3'] == '') {
                $data['slide3'] = $_slides['slide3'];
            }

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

            $sql = 'UPDATE services
                SET ' . implode(', ', $sqlFields) . '
                WHERE name = \'' . $name . '\'';

            // Insert end   
            // }
            echo $sql;
            // exit;
            mysqli_query($dbLink, $sql);
            header('location: /admin/services');
            exit;
        }

        $services = [
            'name'   => '',
            'title'  => '',
            'slide1' => '',
            'slide2' => '',
            'slide3' => '',
            'text'   => '',
        ];

        // Manage service

        // Escape and prepare varibles for login
        $name = mysqli_real_escape_string($dbLink, $name);

        // Check if product exists
        $sql = 'SELECT * FROM services WHERE name = \'' . $name . '\'';
        $result = mysqli_query($dbLink, $sql);
        if (($service = mysqli_fetch_assoc($result)) == null) {
            $this->setTemplate('error.tpl');
            $this->setHeader('404 Not Found');
            $this->setTitle('Страница не найдена');
        } else{
            $this->template->assign('name', $service['name']);
            $this->template->assign('header', "Редактирование услуги");
            $this->setTemplate('serviceManage.tpl');
            $this->setTitle('Редактирование услуги');
        }

        $this->template->assign('service', $service);
        $this->template->assign('active', $active);
    }

    public function actionajax() {
        global $dbLink;

        $row = $_POST['row'];
        $name = $_POST['name'];
        $slide = $_POST['del'];
        $sql = 'UPDATE services set ' . $row . ' = \'\' WHERE name = \'' . $name . '\'';
        mysqli_query($dbLink, $sql); 
        unlink(UPLOADS_PATH . '/slides/' . $slide);
    }
}
