<?php

namespace Occazou\Src\Controller;

class Controller
{
    public function getView(string $view, array $data=null)
    {
        $view = new \Occazou\Src\View\View($view);
        $view->generate($data);
    }
}