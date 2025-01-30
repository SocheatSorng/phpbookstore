<?php

class Home extends Controller
{
    public function index()
    {
        // Check if user is logged in
        $this->checkLogin();
        
        // Check if user is admin
        $this->checkAdmin();
        
        $data['page_title'] = "Dashboard";
        $this->view('index', $data);
    }
}