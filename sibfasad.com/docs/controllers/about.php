<?php

namespace Controllers;

class about extends skeleton {

    public function actionindex() {
        global $dbLink;
        global $page;

        $employees = [];
        $sql = 'SELECT * 
            FROM employees
            WHERE enabled = 1
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

        $certificates = [];
        $sql = 'SELECT * 
            FROM certificates
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

        $this->template->assign('employees', $employees);
        $this->template->assign('certificates', $certificates);
        $this->setTemplate('about.tpl');
    }

    public function actionemployee($args) {
        global $dbLink;

        $id = (int) array_shift($args);

        $employee = [];
        $sql = 'SELECT * 
            FROM employees
            WHERE enabled = 1
            AND id = ' . $id;
        $result = mysqli_query($dbLink, $sql);
        if ($result != false) {
            $employee = mysqli_fetch_assoc($result);
            mysqli_free_result($result);
        }
        unset($sql, $result);

        $this->template->assign('employee', $employee);
        $this->setTemplate('employee.tpl');
    }
}