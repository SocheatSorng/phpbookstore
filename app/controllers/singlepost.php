<?php

Class Singlepost extends Controller
{
    function index()
    {
        $data['page_title'] = "Single-post";
        $this->view("singlepost",$data);
    }
}