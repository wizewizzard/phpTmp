<?php

namespace Controllers;

class partners extends skeleton {

    public function actionindex() {
        global $dbLink;

        $sql = 'SELECT id, name, logo
            FROM partners';
        $result = mysqli_query($dbLink, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $partners[$row['id']] = $row;
            unset($row);
        }
        mysqli_free_result($result);
        unset($sql, $result);

        $this->template->assign('count', 0);
        $this->template->assign('even', 1);
        $this->template->assign('partners', $partners);
        $this->setTemplate('partners.tpl');
    }
    
    public function actionview($args) {
        global $dbLink;

        $id = (int) array_shift($args);

        $sql = 'SELECT *
            FROM partners 
            WHERE id = ' . $id;
        $result = mysqli_query($dbLink, $sql);
        $partner = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        unset($sql, $result);

        $sql = 'SELECT id, name, logo
            FROM partners';
        $result = mysqli_query($dbLink, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $partners[$row['id']] = $row;
            unset($row);
        }
        mysqli_free_result($result);
        unset($sql, $result);

        // Check if page exists
        if ($partner == null) {
            header('location:/404');            
        } 
        $this->template->assign('partner', $partner);
        $this->template->assign('partners', $partners);
        $this->template->assign('count', 0);
        $this->setTemplate('partner.tpl');

    }
}