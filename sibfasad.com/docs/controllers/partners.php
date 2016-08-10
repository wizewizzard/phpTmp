<?php

namespace Controllers;

class partners extends skeleton {

    public function actionindex() {
        global $dbLink;
        $pathToImages = ROOT_PATH . '/upload/partnerPhotos/';
        $pathToThumbs = ROOT_PATH . '/upload/partnerPhotos/thumbs/';
        $sql = 'SELECT id, name, logo, photo
            FROM partners';
        $result = mysqli_query($dbLink, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $partners[$row['id']] = $row;
            $photo = $row['photo'];
            if ($photo != '') {
                if (file_exists($pathToThumbs . $photo) != true) {
                    $thumb = \PhpThumbFactory::create($pathToImages . $photo);
                    $thumb->adaptiveResize(175, 175);
                    $thumb->save($pathToThumbs . $photo);

                }
                $photo = '/upload/partnerPhotos/thumbs/' . $row['photo'];
            }
            else{
                $photo = '';
            }
            $partners[$row['id']]['photo'] = addslashes($photo);
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
        $objects = [];

        // Check if page exists
        if ($partner == null) {
            header('location:/404');            
        }
        /**
         * load objects data
         */
        $pathToImages = ROOT_PATH . '/upload/objectPhotos/';
        $pathToThumbs = ROOT_PATH . '/upload/objectPhotos/thumbs/';
        $sql = "SELECT objects.* from objects_of_partners INNER JOIN objects
                on objects_of_partners.object_id = objects.id WHERE partner_id = $id";
        $result = mysqli_query($dbLink, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $objects[$row['id']] = $row;
            $objects[$row['id']]['photo'] = $photo = array_shift(unserialize($row['photos']));
            if ($photo != '') {
                if (file_exists($pathToThumbs . $photo) != true) {
                    $thumb = \PhpThumbFactory::create($pathToImages . $photo);
                    $thumb->adaptiveResize(175, 175);
                    $thumb->save($pathToThumbs . $photo);
                }
            }
            unset($row);
        }

        $this->template->assign('partner', $partner);
        $this->template->assign('partners', $partners);
        $this->template->assign('objects', $objects);
        $this->template->assign('count', 0);
        $this->setTemplate('partner.tpl');

    }
}