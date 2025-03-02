<?php
class Home extends Controller 
{
    public function index()
    {
        try {
            $book = $this->loadModel("BookModel");
            $best_selling_books = $book->getBestSellingBooks();
            // $banner_books = $book->getBannerBooks(3); // Get 3 random books for banner
            
            // Create data array
            $data = [
                'page_title' => "Home",
                'best_selling_books' => $best_selling_books,
                // 'banner_books' => $banner_books
            ];
            
            // Pass data to view
            $this->view("index", $data);
            
        } catch(Exception $e) {
            error_log("Error in Home controller: " . $e->getMessage());
            echo "An error occurred. Please check the error logs.";
        }
    }
}