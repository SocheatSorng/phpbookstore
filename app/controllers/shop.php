<?php
class Shop extends Controller 
{
    public function index()
    {
        try {
            $book = $this->loadModel("BookModel");
            $all_books = $book->getAllBooks();
            
            // Add debugging
            error_log("Books retrieved in Shop controller: " . print_r($all_books, true));
            
            $data = [
                'page_title' => "Shop",
                'books' => $all_books
            ];
            
            $this->view("shop", $data);
            
        } catch(Exception $e) {
            error_log("Error in Shop controller: " . $e->getMessage());
            echo "An error occurred. Please check the error logs.";
        }
    }
}