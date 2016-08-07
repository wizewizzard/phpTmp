<?php

namespace Controllers\Admin;

class employees extends \Controllers\skeleton {

    public function actionindex() {
        global $dbLink;

        // Set current menu
        $active = 'employees';
        
        $search = '';
        $whereClause = '';
        $employees = [];

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
        $sql = 'SELECT id, name, enabled
            FROM employees
            ' . (($whereClause !== '') ? $whereClause : '') . '
            ORDER BY name ASC';
        $result = mysqli_query($dbLink, $sql);
        if ($result != false) {
            while ($row = mysqli_fetch_assoc($result)) {
                $employees[$row['id']] = $row;
                unset($row);
            }
            mysqli_free_result($result);
        }
        unset($sql, $result);

        $this->template->assign('employees', $employees);
        $this->template->assign('active', $active);
        $this->setTemplate('employees.tpl');
    }

    public function actionmanage($args) {
        global $dbLink;

        // Set current menu
        $active = 'employees';
        $id = (int) array_shift($args);

        if (isset($_REQUEST['name']) === true && $_REQUEST['name'] != '') {
            // Add new employee

            // Prepare varibles
            $data = [
                'name'        => '',
                'photo'       => '',
                'description' => '',
                'enabled'     => true,
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
                if (!file_exists(UPLOADS_PATH . '/employeesPhotos')) {
                    mkdir(UPLOADS_PATH . '/employeesPhotos', 0777, true);
                }
                $tempName = $_FILES['photo']['tmp_name'];
                $photoName = sha1($tempName . time()) . '.jpg';
                move_uploaded_file($_FILES['photo']['tmp_name'], UPLOADS_PATH . '/employeesPhotos/' . $photoName);
                $pathToImages = UPLOADS_PATH . '/employeesPhotos/';
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
                    
                    $sqlFields[] = $fieldName;
                    $sqlValues[] = mysqli_real_escape_string($dbLink, $fieldValue);

                    unset($fieldName, $fieldValue);
                }

                $sql = 'INSERT INTO employees (' . implode(', ', $sqlFields) . ')
                    VALUES (\'' . implode('\', \'', $sqlValues) . '\')';

                unset($sqlFields, $sqlValues);
            } else {
                // Update

                // Prepare logo and photo
                $sql =  'SELECT photo FROM employees WHERE id = ' . $id;
                $result = mysqli_query($dbLink, $sql);
                $_photos = mysqli_fetch_assoc($result);

                // Delete old photo if submited the new one
                if ($_photos['photo'] !== '' &&
                    $data['photo'] !== '') {
                    unlink(UPLOADS_PATH . '/employeesPhotos/' . $_photos['photo']);
                } elseif ($data['photo'] == '') {
                    $data['photo'] = $_photos['photo'];
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

                $sql = 'UPDATE employees
                    SET ' . implode(', ', $sqlFields) . '
                    WHERE id = ' . $id;

                unset($sqlFields);
            }
            mysqli_query($dbLink, $sql);
            header('location: /admin/employees');
            exit;
        }

        // Prepare varibles
        $employee = [
            'name'        => '',
            'photo'       => '',
            'description' => '',
            'enabled'     => true,
        ];

        if ($id === 0) {
            // Add employee
            $this->template->assign('header', 'Добавление сотрудника');
            $this->setTemplate('employeeManage.tpl');
            $this->setTitle('Добавление сотрудника');
        } else {
            // Manage employee
            // Check if employee exists
            $sql = 'SELECT * FROM employees WHERE id = ' . (int) $id;
            $result = mysqli_query($dbLink, $sql);
            if (($employee = mysqli_fetch_assoc($result)) === null) {
                $this->setTemplate('error.tpl');
                $this->setHeader('404 Not Found');
                $this->setTitle('Страница не найдена');
            } else {
                $this->template->assign('header', 'Редактирование сотрудника');
                $this->setTemplate('employeeManage.tpl');
                $this->setTitle('Редактирование сотрудника');
            }
        }

        $this->template->assign('employee', $employee);
        $this->template->assign('active', $active);
    }

    public function actiondelete($args) {
        global $dbLink;

        $id = (int) array_shift($args);

        // Get photos names to dleete 
        $sql = 'SELECT photo FROM employees WHERE id =' . $id;
        $result = mysqli_query($dbLink, $sql);
        $photos = mysqli_fetch_assoc($result);

        // Delete photo
        if ($photos['photo'] != '') {
            unlink(UPLOADS_PATH . '/empoyeesPhotos/' . $photos['photo']);
        }

        $sql = 'DELETE FROM employees WHERE id =' . $id;
        mysqli_query($dbLink, $sql);

        header('location: /admin/employees');
        exit;
    }
}
