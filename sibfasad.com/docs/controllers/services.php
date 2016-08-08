<?php

namespace Controllers;

class services extends skeleton {

    public function actionindex() {
        global $dbLink;

        // Get services data
        $sql = 'SELECT * FROM services';
        $result = mysqli_query($dbLink, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $services[$row['name']] = $row;
            unset($row);
        }

        // Cleanup
        mysqli_free_result($result);
        unset($sql, $result);
        
        // echo '<pre>';
        // var_dump($services);
        // exit;
        // Parse template and data
        $this->template->assign('services', $services);
        $this->setTemplate('services.tpl');
    }


}