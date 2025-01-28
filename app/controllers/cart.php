<?php

Class Cart extends Controller
{
    function index()
    {
        $data['page_title'] = "Cart";
        $this->view("cart",$data);
    }
}