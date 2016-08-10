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
        $sql = 'SELECT id, name, photos, brief_info, description
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
                            'brief_info' => (isset($row['brief_info']) && $row['brief_info']!='') ?
                                $row['brief_info'] : 'Перейти к просмотру'

                            ];
            }
            unset($row, $arr, $photo);
        }


        $sql = 'SELECT id, name, photo, brief_info, description
            FROM partners';
        $result = mysqli_query($dbLink, $sql);
        $pathToImages = ROOT_PATH . '/upload/partnerPhotos/';
        $pathToThumbs = ROOT_PATH . '/upload/partnerPhotos/thumbs/';
        while ($row = mysqli_fetch_assoc($result)) {
            // $row['photo'] != '' ? $photo = '/upload/partnerPhotos/' . $row['photo'] : $photo = '/images/nophoto.jpg';
            if (strlen($row['photo']) > 0) {
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
                                'brief_info' => (isset($row['brief_info']) && $row['brief_info']!='') ?
                                    $row['brief_info']  : 'Перейти к просмотру'

                ];
            } //endif

            unset($row, $photo, $thumb);
        }
        //die();
        
        $sql = 'SELECT id, photo, photoLabel, description
            FROM partners
            WHERE show_interview = 1';
        $result = mysqli_query($dbLink, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $interviews[$row['id']] = $row;
            unset($row);
        }

        // Add blank hexagons
        /*$count = ceil(count($hexagons) * 0.15);
        for ($i = 1; $i <= $count; $i++) {
            $hexagons[] = 'space';
        }*/
        shuffle($hexagons);
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
        $sql = 'SELECT * FROM config WHERE param = "main_page_items_num"';
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
        // echo '<pre>';
        // var_dump($hexagons);
        // exit;
        $this->template->assign('withVideo', $withVideo);
        $this->template->assign('hexagonsPhoto', $hexagonsPhoto);
        $this->template->assign('hexagonsText', $hexagonsText);
        $this->template->assign('hexagonsNum', $hexagonsNum);
        $this->template->assign('hexagonEvenRowNum', $hexagonEvenRowNum);
        $this->template->assign('hexagonUnevenRowNum', $hexagonUnevenRowNum);
        $this->template->assign('interviews', $interviews);

        $this->setTemplate('index.tpl');
    }
}
class index2 extends skeleton {

    public function actionindex2() {
        $this->setTemplate('index2.tpl');
    }
}