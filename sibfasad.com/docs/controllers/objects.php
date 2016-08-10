<?php

namespace Controllers;
require_once ROOT_PATH . '/vendor/phpthumb/ThumbLib.inc.php';


class objects extends skeleton {

    public function actionindex() {
        global $dbLink;

        $sql = 'SELECT id, name, photos, category, brief_info
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
                $photo = '/upload/objectPhotos/thumbs/' . $photo;


            }
            else{
                $photo = '/images/noimage.png';
            }

            $hexagons[] = [
                'link' => '/objects/view/' . $row['id'],
                'name' => $row['name'],
                'photo' => $photo,
                'category' => $row['category'],
                'brief_info' => (isset($row['brief_info']) && $row['brief_info']!='') ?
                    $row['brief_info'] : 'Перейти к просмотру'

            ];
            unset($row);
        }
        mysqli_free_result($result);
        unset($sql, $result);
        $hexagonEvenRowNum = 7;
        $hexagonUnevenRowNum = 6;
        $hexagonLayout = [
            [0 => 'f0', 2 => 'f1', 3 => 't1', 5 => 'f2', 6=> 't2'],
            [0 => 't0', 3 => 'f3', 4 => 't3'],
            [0 => 'f4', 2 => 'f5', 3 => 't5'],
            [0 => 't4', 2 => 'f6', 4 => 'f7', 5 => 't7'],
            [0 => 'f8', 1 => 't8', 3 => 't6', 6=> 'f9'],
            [0 => 'f10', 1 => 't10', 5 => 't9'],
        ];
        $hexagonsOnLayoutNum = 11;
        $hexagonsPhoto = [];//array of hexagons for photo
        $hexagonsText = [];//array of hexagons for text
        $itemsToDisplay = 11;//this the variable where user specifies number of displayed items
        $sql = 'SELECT count(*) as value FROM objects';
        $result = mysqli_query($dbLink, $sql);
        if (($config = mysqli_fetch_assoc($result)) !== null) {
            $itemsToDisplay = $config['value'];
        }

        $hexagonRowsNum = 39;//how many hexagons in one layout
        /**
         * count max needed number of hexagons
         */
        $hexagonsNum = ceil($itemsToDisplay * $hexagonRowsNum/$hexagonsOnLayoutNum);
        while($hexagonsNum % ($hexagonEvenRowNum + $hexagonUnevenRowNum) !== 0) $hexagonsNum++;
        $hexagonsCurrentNum = count($hexagons);

        $displayedItems = 0;

        $layoutIteratedTimes = 0;
        $maxI = 0;//variable to save max index value and use it to cut off unused hexagons
        for($i =0 ; $i < $hexagonsNum && $i < $hexagonsCurrentNum && $displayedItems < $itemsToDisplay ; $i++){
            if($i!=0 && $i % $hexagonsOnLayoutNum == 0)  $layoutIteratedTimes++;
            $curF = 'f'.$i%$hexagonsOnLayoutNum;
            $curT = 't'.$i%$hexagonsOnLayoutNum;
            $fIndex = -1;
            $tIndex = -1;
            $row_start_index = 0;
            foreach($hexagonLayout as $rowI => $row){

                if(($key = array_search($curF, $row))!==false){
                    $fIndex = $hexagonRowsNum * $layoutIteratedTimes + $row_start_index + $key;
                    if($maxI < $fIndex) $maxI = $fIndex;
                }
                if(($key = array_search($curT, $row))!==false){
                    $tIndex = $hexagonRowsNum * $layoutIteratedTimes +$row_start_index + $key;
                    if($maxI < $tIndex) $maxI = $tIndex;
                }

                if($rowI%2 == 0) $row_start_index += $hexagonEvenRowNum;
                else $row_start_index += $hexagonUnevenRowNum;
            }
            if($fIndex != -1){
                $hexagonsPhoto[$fIndex] = $hexagons[$i];
                $displayedItems++;
            }
            if($tIndex != -1)
                $hexagonsText[$tIndex] = $hexagons[$i];
        }
        /**
         * remove unused haxagons
         */
        while($hexagonsNum - $hexagonUnevenRowNum > $maxI){
            $hexagonsNum -= $hexagonUnevenRowNum;
            if($hexagonsNum - $hexagonEvenRowNum > $maxI)
                $hexagonsNum -= $hexagonEvenRowNum;
        }

        $this->template->assign('hexagonsPhoto', $hexagonsPhoto);
        $this->template->assign('hexagonsText', $hexagonsText);
        $this->template->assign('hexagonsNum', $hexagonsNum);
        $this->template->assign('hexagonEvenRowNum', $hexagonEvenRowNum);
        $this->template->assign('hexagonUnevenRowNum', $hexagonUnevenRowNum);
        $this->template->assign('count', 0);
        $this->template->assign('even', 1);
        $this->template->assign('objects', $objects);
        $this->setTemplate('objects.tpl');
    }
    public function actionview($args) {
        global $dbLink;

        $id = (int) array_shift($args);
        $pathToImages = ROOT_PATH . '/upload/objectPhotos/';
        $pathToThumbs = ROOT_PATH . '/upload/objectPhotos/thumbs/';
        // Get main selected object photos
        $sql = 'SELECT *
            FROM objects 
            WHERE id = ' . $id;
        $result = mysqli_query($dbLink, $sql);
        $object = mysqli_fetch_assoc($result);
        $object['photos'] = unserialize($object['photos']);
        $object['pdf_files'] = unserialize($object['pdf_files']);
        $pathToImages = UPLOADS_PATH . '/objectPhotos/';
        foreach ($object['photos'] as $key => $photo) {
            $thumb = \PhpThumbFactory::create($pathToImages . $photo);
            $thumb->adaptiveResize(940, 600);
            $thumb->save($pathToImages . $photo);
        }
        $object['photo'] = $photo = array_shift($object['photos']);
        if ($photo != '') {
            if (file_exists($pathToThumbs . $photo) != true) {
                $thumb = \PhpThumbFactory::create($pathToImages . $photo);
                $thumb->adaptiveResize(175, 175);
                $thumb->save($pathToThumbs . $photo);
            }
        }
        mysqli_free_result($result);
        unset($sql, $result);

        // Get other objects thumbs
        $sql = 'SELECT id, name, photos
            FROM objects where id <> ' . $id;
        $result = mysqli_query($dbLink, $sql);
        $objects[abs($id)] = $object;
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