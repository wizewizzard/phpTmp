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
    public function actiondownloadfile($args){
        echo 11;
        $filename = $_GET['filename'];

        $CLen = filesize($filename);
        //$filename = basename($filePath); // запрашиваемое имя
        $file_extension = strtolower(substr(strrchr($filename, '.'), 1));
        // Краткий перечень mime-типов
        //

        $uploadDirectories = array (
            'pdf' => 'objectPDFs',
            'jpg' => 'objectPhotos'
        );
        if(!isset($uploadDirectories[$file_extension])){

        }
        if(!file_exists(UPLOADS_PATH.'/'.$uploadDirectories.'/'.$filename)) {
            return false;
        }

        $CTypes = array (
            'pdf' => 'application/pdf',
            'gif' => 'image/gif',
            'png' => 'image/png',
            'jpe' => 'jpeg',
            'jpg' => 'image/jpg'
        );
        $fileCType = $CTypes[$file_extension];
        $this->setHeader('200 OK\r\nContent-Disposition: attachment; filename="' . basename($filename) . '"\r\nContent-Transfer-Encoding: binary\r\nAccept-Ranges: bytes\r\nContent-Length: ' . (filesize($filename)).'\r\nContent-Type: ' . $fileCType.'\r\n');
        //$this->sendHeaders();
        /*set_time_limit(0);
        header('HTTP/1.0 200 OK');
        header('Content-Disposition: attachment; filename="' . basename($filename) . '"');
        header('Content-Transfer-Encoding: binary');
        header('Accept-Ranges: bytes');
        header('Content-Length: ' . (filesize($filename)));
        header('Content-Type: ' . $fileCType );*/
        echo readfile($filename);

        /*if(isset($_GET['filename'])) {
            if (!file_exists($filename = $_GET['filename'])){
                print "Файл " . $filename . "не найден!\r\n";
            }
            else {

            }
        }*/
    }
}
class index2 extends skeleton {

    public function actionindex2() {
        $this->setTemplate('index2.tpl');
    }
}