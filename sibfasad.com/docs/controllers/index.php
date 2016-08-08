<?php

namespace Controllers;
require_once ROOT_PATH . '/vendor/phpthumb/ThumbLib.inc.php';

class index extends skeleton {

    public function actionindex() {
        global $dbLink;
    
        $withVideo = true;
        $host = $_SERVER['HTTP_HOST'];
        if (isset($_SERVER['HTTP_REFERER']) &&
            strpos($_SERVER['HTTP_REFERER'], $host) !== false
            ) {
            $withVideo = false;   
        }
        unset($host);

        // Prepare objects 
        $hexagons = [];
        $sql = 'SELECT id, name, photos
            FROM objects WHERE show_object = 1';
        $result = mysqli_query($dbLink, $sql);
        $pathToImages = ROOT_PATH . '/upload/objectPhotos/';
        $pathToThumbs = ROOT_PATH . '/upload/objectPhotos/thumbs/';
        while ($row = mysqli_fetch_assoc($result)) {
            $arr = unserialize($row['photos']);
            $photo = array_shift($arr);
            if ($photo != '') {
                if (file_exists($pathToThumbs . $photo) != true) {
                    $thumb = \PhpThumbFactory::create($pathToImages . $photo);
                    $thumb->adaptiveResize(175, 175);
                    $thumb->save($pathToThumbs . $photo);
                }

            $photo = '/upload/objectPhotos/thumbs/' . $photo;
            $hexagons[] = [
                            'link' => '/objects/view/' . $row['id'],
                            'name' => $row['name'],
                            'photo' => $photo,
                            ];
            }
            unset($row, $arr, $photo);
        }


        $sql = 'SELECT id, name, photo
            FROM partners';
        $result = mysqli_query($dbLink, $sql);
        $pathToImages = ROOT_PATH . '/upload/partnerPhotos/';
        $pathToThumbs = ROOT_PATH . '/upload/partnerPhotos/thumbs/';
        while ($row = mysqli_fetch_assoc($result)) {
            // $row['photo'] != '' ? $photo = '/upload/partnerPhotos/' . $row['photo'] : $photo = '/images/nophoto.jpg';
            if ($row['photo'] != '') {
                if (file_exists($pathToThumbs . $row['photo']) != true) {
                    $thumb = \PhpThumbFactory::create($pathToImages . $row['photo']);
                    $thumb->adaptiveResize(175, 175);
                    $thumb->save($pathToThumbs . $row['photo']);
                }
                $photo = '/upload/partnerPhotos/thumbs/' . $row['photo'];
                $hexagons[] = [
                                'link' => '/partners/view/' . $row['id'],
                                'name' => $row['name'],
                                'photo' => $photo,
                                ];
            } //endif

            unset($row, $photo, $thumb);
        }
        
        $sql = 'SELECT id, photo, photoLabel, description
            FROM partners
            WHERE show_interview = 1';
        $result = mysqli_query($dbLink, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $interviews[$row['id']] = $row;
            unset($row);
        }

        // Add blank hexagons
        $count = ceil(count($hexagons) * 0.15);
        for ($i = 1; $i <= $count; $i++) {
            $hexagons[] = 'space';
        }

        shuffle($hexagons);
        // echo '<pre>';
        // var_dump($hexagons);
        // exit;

        $this->template->assign('withVideo', $withVideo);
        $this->template->assign('hexagons', $hexagons);
        $this->template->assign('interviews', $interviews);

        $this->setTemplate('index.tpl');
    }
}
class index2 extends skeleton {

    public function actionindex2() {
        $this->setTemplate('index2.tpl');
    }
}