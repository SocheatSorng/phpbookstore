<?php
class Shop extends Controller 
{
    public function index()
    {
        $this->showBooks();
    }

    public function category($categoryId = null)
    {
        $this->showBooks($categoryId);
    }

    private function showBooks($categoryId = null)
    {
        try {
            $book = $this->loadModel("BookModel");
            $categories = $book->getCategories();
            
            if ($categoryId) {
                $books = $book->getBooksByCategory($categoryId);
                $activeCategory = array_filter($categories, function($cat) use ($categoryId) {
                    return $cat->CategoryID == $categoryId;
                });
                $activeCategory = reset($activeCategory) ?: null;
            } else {
                $books = $book->getAllBooks();
                $activeCategory = null;
            }
            
            $data = [
                'page_title' => "Shop",
                'books' => $books,
                'categories' => $categories,
                'active_category' => $activeCategory,
                'category_id' => $categoryId
            ];
            
            $this->view("shop", $data);
            
        } catch(Exception $e) {
            error_log("Error in Shop controller: " . $e->getMessage());
            echo "An error occurred. Please check the error logs.";
        }
    }
}