<?php

namespace Controllers\Admin;
require_once ROOT_PATH . '/vendor/phpthumb/ThumbLib.inc.php';

class partners extends \Controllers\skeleton {

    public function actionindex() {
        global $dbLink;

        // Set current menu
        $active = 'partners';
        
        $search = '';
        $whereClause = '';
        $partners = [];

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
        $sql = 'SELECT id, name, show_interview
            FROM partners
            ' . (($whereClause !== '') ? $whereClause : '') . '
            ORDER BY name ASC';
        $result = mysqli_query($dbLink, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $partners[$row['id']] = $row;
            unset($row);
        }
        mysqli_free_result($result);
        unset($sql, $result);

        $this->template->assign('partners', $partners);
        $this->template->assign('active', $active);
        $this->setTemplate('partners.tpl');
    }

    public function actionmanage($args) {
        global $dbLink;

        // Set current menu
        $active = 'partners';
        $id = (int) array_shift($args);

        if (isset($_REQUEST['name']) === true && $_REQUEST['name'] != '') {
            // Add new partner

            // Prepare varibles
            $data = [
                'name'       => '',
                'logo'       => '',
                'photo'      => '',
                'photoLabel' => '',
                'comment'    => '',
                'url'        => '',


                'show_interview'  => false,
                'description'     => '',
                'related_objects' => [],
            ];
            foreach ($data as $fieldName => $fieldDefault) {
                if (isset($_REQUEST[$fieldName]) === true) {
                    $data[$fieldName] = $_REQUEST[$fieldName];
                    settype($data[$fieldName], gettype($fieldDefault));
                }
                unset($fieldName, $fieldDefault);
            }

            // Upload logo if submited
            if (
                isset($_FILES['logo']['tmp_name']) === true &&
                $_FILES['logo']['tmp_name'] !== ''
            ) {
                // Make dir if doesn't exist
                if (!file_exists(UPLOADS_PATH . '/partnerPhotos')) {
                    mkdir(UPLOADS_PATH . '/partnerPhotos', 0777, true);
                }
                $tempName = $_FILES['logo']['tmp_name'];
                $photoName = sha1($tempName . time()) . '.jpg';
                move_uploaded_file($_FILES['logo']['tmp_name'], UPLOADS_PATH . '/partnerPhotos/' . $photoName);
                // Resize logo before saving
                // $pathToImages = UPLOADS_PATH . '/partnerPhotos/';
                // $thumb = \PhpThumbFactory::create($pathToImages . $photoName);
                // $thumb->adaptiveResize(175, 175);
                // $thumb->save($pathToImages . $photoName);
                $data['logo'] = $photoName;
            }

            // Upload photo if submited
            if (
                isset($_FILES['photo']['tmp_name']) === true &&
                $_FILES['photo']['tmp_name'] !== ''
            ) {
                // Make dir if doesn't exist
                if (!file_exists(UPLOADS_PATH . '/partnerPhotos')) {
                    mkdir(UPLOADS_PATH . '/partnerPhotos', 0777, true);
                }
                $tempName = $_FILES['photo']['tmp_name'];
                $photoName = sha1($tempName . time()) . '.jpg';
                move_uploaded_file($_FILES['photo']['tmp_name'], UPLOADS_PATH . '/partnerPhotos/' . $photoName);
                // Resize photo before saving
                $pathToImages = UPLOADS_PATH . '/partnerPhotos/';
                $thumb = \PhpThumbFactory::create($pathToImages . $photoName);
                $thumb->adaptiveResize(175, 175);
                $thumb->save($pathToImages . $photoName);
                $data['photo'] = $photoName;
            }

            // Update or insert new product
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

                $sql = 'INSERT INTO partners (' . implode(', ', $sqlFields) . ')
                    VALUES (\'' . implode('\', \'', $sqlValues) . '\')';

                unset($sqlFields, $sqlValues);
            } else {
                // Update

                // Prepare logo and photo
                $sql =  'SELECT logo, photo FROM partners WHERE id = ' . $id;
                $result = mysqli_query($dbLink, $sql);
                $_photos = mysqli_fetch_assoc($result);

                // Delete old logo if submited the new one
                if ($_photos['logo'] !== '' &&
                    $data['logo'] !== '') {
                    unlink(UPLOADS_PATH . '/partnerPhotos/' . $_photos['logo']);
                } elseif ($data['logo'] == '') {
                    $data['logo'] = $_photos['logo'];
                }
                // Delete old photo if submited the new one
                if ($_photos['photo'] !== '' &&
                    $data['photo'] !== '') {
                    unlink(UPLOADS_PATH . '/partnerPhotos/' . $_photos['photo']);
                } elseif ($data['photo'] == '') {
                    $data['photo'] = $_photos['photo'];
                }

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

                $sql = 'UPDATE partners
                    SET ' . implode(', ', $sqlFields) . '
                    WHERE id = ' . $id;

                unset($sqlFields);
            }
            mysqli_query($dbLink, $sql);
            header('location: /admin/partners');
            exit;
        }

        // Prepare varibles
        $partner = [
            'name'       => '',
            'logo'       => '',
            'photo'      => '',
            'photoLabel' => '',
            'comment'    => '',
            'url'        => '',

            'show_interview'  => false,
            'description'     => '',
            'related_objects' => [],
        ];

        if ($id === 0) {
            // Add partner
            $this->template->assign('header', 'Добавление партнера');
            $this->setTemplate('partnerManage.tpl');
            $this->setTitle('Добавление партнера');
        } else {
            // Manage partner
            // Check if partner exists
            $sql = 'SELECT * FROM partners WHERE id = ' . (int) $id;
            $result = mysqli_query($dbLink, $sql);
            if (($partner = mysqli_fetch_assoc($result)) === null) {
                $this->setTemplate('error.tpl');
                $this->setHeader('404 Not Found');
                $this->setTitle('Страница не найдена');
            } else {
                $this->template->assign('header', 'Редактирование партнера');
                $this->setTemplate('partnerManage.tpl');
                $this->setTitle('Редактирование партнера');

                // Unserialize arrays
                $partner['related_objects'] = unserialize($partner['related_objects']);
            }
        }
        // var_dump($partner);
        // exit;
        $this->template->assign('partner', $partner);

        $this->template->assign('active', $active);
    }

    public function actiondelete($args) {
        global $dbLink;

        $id = (int) array_shift($args);

        // Get photos names to dleete 
        $sql = 'SELECT logo, photo FROM partners WHERE id =' . $id;
        $result = mysqli_query($dbLink, $sql);
        $photos = mysqli_fetch_assoc($result);

        // Delete logo
        if ($photos['logo'] != '') {
            unlink(UPLOADS_PATH . '/partnerPhotos/' . $photos['logo']);
        }

        // Delete photo
        if ($photos['photo'] != '') {
            unlink(UPLOADS_PATH . '/partnerPhotos/' . $photos['photo']);
        }

        $sql = 'DELETE FROM partners WHERE id =' . $id;
        mysqli_query($dbLink, $sql);

        header('location: /admin/partners');
        exit;
    }
}
