<?php

namespace Controllers;
require_once ROOT_PATH . '/vendor/phpthumb/ThumbLib.inc.php';


class objects extends skeleton {

    public function actionindex() {
        global $dbLink;

        $sql = 'SELECT id, name, photos, category
            FROM objects';
        $result = mysqli_query($dbLink, $sql);
        $pathToImages = ROOT_PATH . '/upload/objectPhotos/';
        $pathToThumbs = ROOT_PATH . '/upload/objectPhotos/thumbs/';
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
        mysqli_free_result($result);
        unset($sql, $result);

        $this->template->assign('count', 0);
        $this->template->assign('even', 1);
        $this->template->assign('objects', $objects);
        $this->setTemplate('objects.tpl');
    }
    public function actionview($args) {
        global $dbLink;

        $id = (int) array_shift($args);

        // Get main selected object photos
        $sql = 'SELECT *
            FROM objects 
            WHERE id = ' . $id;
        $result = mysqli_query($dbLink, $sql);
        $object = mysqli_fetch_assoc($result);
        $object['photos'] = unserialize($object['photos']);
        $object['pdf_files'] = unserialize($object['pdf_files']);
        $pathToImages = UPLOADS_PATH . '/objectPhotos/';
        foreach ($object['photos'] as $id => $photo) {
            $thumb = \PhpThumbFactory::create($pathToImages . $photo);
            $thumb->adaptiveResize(940, 600);
            $thumb->save($pathToImages . $photo);
        }
        mysqli_free_result($result);
        unset($sql, $result);

        // Get other objects thumbs
        $sql = 'SELECT id, name, photos
            FROM objects';
        $result = mysqli_query($dbLink, $sql);
        $pathToImages = ROOT_PATH . '/upload/objectPhotos/';
        $pathToThumbs = ROOT_PATH . '/upload/objectPhotos/thumbs/';
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
        mysqli_free_result($result);
        unset($sql, $result);

        // Check if page exists
        if ($object == null) {
            header('location:/404');            
        }
        // echo "<pre>";
        // var_dump($objects);
        // exit;
        $this->template->assign('object', $object);
        $this->template->assign('objects', $objects);
        $this->template->assign('count', 0);
        $this->setTemplate('object.tpl');
    }
}