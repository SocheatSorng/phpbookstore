<?php

Class Controller
{
    private $models = [];

    protected function view($view, $data = [])
    {
        try {
            if(file_exists("../app/views/".$view.".php")) {
                include "../app/views/".$view.".php";
            } else {
                include "../app/views/404.php";
            }
        } catch (Exception $e) {
            // Handle view loading error
            error_log("Error loading view: " . $e->getMessage());
            include "../app/views/404.php";
        }
    }

    protected function loadModel($model)
    {
        // Check if model is already loaded
        if(isset($this->models[$model])) {
            return $this->models[$model];
        }

        $filename = "../app/models/" . strtolower($model) . ".php";
        if(file_exists($filename)) {
            require_once $filename;
            $this->models[$model] = new $model();
            return $this->models[$model];
        }
        return false;
    }

    protected function checkLogin()
    {
        if(!isset($_SESSION['user_id'])) {
            header("Location: " . ROOT . "login");
            die;
        }
    }

    protected function checkAdmin() 
    {
        if(!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'admin') {
            header("Location: " . ROOT . "login");
            die;
        }
    }
}