<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 08.08.2016
 * Time: 18:40
 */

namespace Controllers;


class file extends skeleton
{
    private $filePath;
    private $fileCType;

    public function actionload($args){
            $filename = array_shift($args);
            $CLen = filesize($filename);
            //$filename = basename($filePath); // запрашиваемое имя
            $file_extension = strtolower(substr(strrchr($filename, '.'), 1));


            $uploadDirectories = array (
                'pdf' => 'objectPDFs',
                'jpg' => 'objectPhotos'
            );
            $this->filePath = UPLOADS_PATH.'/'.$uploadDirectories[$file_extension].'/'.$filename;
            if(!isset($uploadDirectories[$file_extension])){
                die();
            }
            if(!file_exists($this->filePath)) {
                die();
            }
            // Краткий перечень mime-типов
            //
            $CTypes = array (
                'pdf' => 'application/pdf',
                'gif' => 'image/gif',
                'png' => 'image/png',
                'jpe' => 'jpeg',
                'jpg' => 'image/jpg'
            );
            $this->fileCType = $CTypes[$file_extension];
            $this->sendHeaders();
            @readfile($this->filePath);
    }

    public function sendHeaders(){
        header('HTTP/1.1 200 OK');
        header('Content-Disposition: attachment; filename="' . basename($this->filePath) . '"');
        header('Content-Transfer-Encoding: binary');
        header('Accept-Ranges: bytes');
        header('Content-Length: ' . (filesize($this->filePath)));
        header('Content-Type: ' . $this->fileCType );
    }
}