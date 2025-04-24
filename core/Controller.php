<?php

namespace core;
require_once __DIR__ . '/helpers.php';

class Controller
{
    public function view($view, $data = [])
    {
        extract($data);
        $viewPath = "../app/views/" . $view . ".php";

        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            echo "View $viewPath not found.";
        }
    }

    public function redirect($url)
    {
        header("Location: $url");
        exit;
    }
}
