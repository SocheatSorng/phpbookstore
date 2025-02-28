<?php
class SingleProduct extends Controller 
{
    public function index($bookId = null)
    {
        if (!$bookId) {
            header("Location: " . ROOT . "shop");
            exit();
        }

        try {
            $book = $this->loadModel("BookModel");
            $bookDetails = $book->getBookDetails($bookId);
            $relatedBooks = $book->getRelatedBooks($bookDetails->CategoryID ?? null, $bookId, 6);
            $reviews = $book->getBookReviews($bookId);
            
            $data = [
                'page_title' => $bookDetails->Title ?? "Book Details",
                'book' => $bookDetails,
                'related_books' => $relatedBooks,
                'reviews' => $reviews
            ];
            
            $this->view("singleproduct", $data);
            
        } catch(Exception $e) {
            error_log("Error in SingleProduct controller: " . $e->getMessage());
            header("Location: " . ROOT . "shop");
            exit();
        }
    }
}