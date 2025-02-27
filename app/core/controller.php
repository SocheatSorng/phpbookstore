<?php

Class Controller
{
    protected function view($view, $data = [])
    {
        // Load cart data for all views
        try {
            if(file_exists("../app/models/CartModel.php")) {
                include_once "../app/models/CartModel.php";
                $cartModel = new CartModel();
                
                // Add cart data to the existing data array
                $data['cart_items'] = $cartModel->getCartItems();
                
                // Calculate the cart total and count correctly
                $data['cart_total'] = 0;
                $data['cart_count'] = 0;
                
                foreach ($data['cart_items'] as $item) {
                    $data['cart_total'] += $item['Price'] * $item['Quantity'];
                    $data['cart_count'] += $item['Quantity'];  // Sum quantities instead of counting items
                }
            }
        } catch (Exception $e) {
            // If there's an error, set empty cart data
            $data['cart_items'] = [];
            $data['cart_count'] = 0;
            $data['cart_total'] = 0;
            error_log("Error loading cart data: " . $e->getMessage());
        }

        if (isset($data['cart_items'])) {
            // Calculate cart total
            $cartTotal = 0;
            foreach ($data['cart_items'] as $item) {
                $cartTotal += (float)($item['Price'] ?? 0) * (int)($item['Quantity'] ?? 0);
            }
            $data['cart_total'] = $cartTotal;
            $data['cart_count'] = count($data['cart_items']);
        }

        // Extract data to make variables available in view
         if(is_array($data)){
            extract($data);
        }
        
        $file = "../app/views/".$view.".php";
        if(file_exists($file))
        {
            require $file;
        } else {
            require "../app/views/404.php";
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