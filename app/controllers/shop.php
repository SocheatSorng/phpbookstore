<?php

Class Shop extends Controller
{
    function index()
    {
        $data['page_title'] = "Shop";
        $this->view("shop",$data);
    }
}