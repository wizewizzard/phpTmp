<?php

namespace Controllers\Admin;

class video extends \Controllers\skeleton {

    public function actionindex() {
        // Prepare variables
        $statusClass = $statusMessage = '';

        // Upload file
        if (isset($_FILES['video']) === true) {
            if (move_uploaded_file($_FILES['video']['tmp_name'], UPLOADS_PATH . '/video/intro.mp4') === true) {
                $statusClass   = 'success';
                $statusMessage = 'Файл успешно загружен';
            } else {
                $statusClass   = 'error';
                $statusMessage = 'Произошла ошибка при загрузке файла';
            }
        }

        $this->template->assign('statusClass',   $statusClass);
        $this->template->assign('statusMessage', $statusMessage);
        $this->template->assign('active', 'video');
        $this->setTemplate('video.tpl');
        $this->setTitle('Управление вступительным видео');
    }
}
