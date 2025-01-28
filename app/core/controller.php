<?php

Class Controller
{
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
        try {
            if(file_exists("../app/models/".$model.".php")) {
                include "../app/models/".$model.".php";
                return $model = new $model;
            }
            return false;
        } catch (Exception $e) {
            // Handle model loading error
            error_log("Error loading model: " . $e->getMessage());
            return false;
        }
    }
}