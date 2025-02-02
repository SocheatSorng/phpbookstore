<?php

class Login extends Controller 
{
    public function index() 
    {
        // Check and create first admin if needed
        $user = $this->loadModel("user");
        $user->createFirstAdmin();

        // If already logged in, redirect to dashboard
        if(isset($_SESSION['user_id']) && isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
            header("Location: " . ROOT . "home");
            die;
        }

        $data['page_title'] = "Login";
        
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $user = $this->loadModel("user");
            $user->login($_POST);
        }
        
        $this->view("login", $data);
    }

    public function logout()
    {
        session_destroy();
        header("Location: " . ROOT . "login");
        die;
    }
}
