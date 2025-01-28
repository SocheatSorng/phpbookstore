<?php

Class Checkout extends Controller
{
    function index()
    {
        $data['page_title'] = "Checkout";
        $this->view("checkout",$data);
    }
}