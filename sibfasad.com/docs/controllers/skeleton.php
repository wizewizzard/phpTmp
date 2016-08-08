<?php

namespace Controllers;

abstract class skeleton {
    protected $template = null;
    private $templateName = 'index.tpl';

    protected $header = '200 OK';

    public function __call($name, $args)
    {
        // Check that specified action exists or setup "index" as action
        if (method_exists($this, $name) === false) {
            $name = 'actionindex';
        }

        call_user_func([$this, $name], $args);
    }

    public function setTemplateObject(\Smarty $template)
    {
        if ($this->template === null) {
            $this->template = $template;
        }
    }

    protected function setTemplate($templateName)
    {
        $this->templateName = $templateName;
    }

    protected function getTemplate()
    {
        return $this->templateName;
    }

    protected function setTitle($title)
    {
        $this->template->assign('pageTitle', $title);
    }

    protected function setHeader($header)
    {
        $this->header = $header;
    }

    public function sendHeaders()
    {
        header('HTTP/1.1 ' . $this->header);
    }

    public function display()
    {
        // $this->template->assign('basket', $_SESSION['basket']);
        $this->template->assign('currentDate', date("Y-m-d H:i:s"));
        $this->template->display($this->templateName);
    }
}
