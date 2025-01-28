<?php

Class Singleproduct extends Controller
{
    function index()
    {
        $data['page_title'] = "Singleproduct";
        $this->view("singleproduct",$data);
    }
}