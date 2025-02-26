<?php
class Cart extends Controller 
{
    private $cartModel;
    
    public function __construct()
    {
        $this->cartModel = $this->loadModel('CartModel');
    }

    // Add the missing index method
    public function index()
    {
        // Get cart items
        $cartItems = $this->cartModel->getCartItems();
        
        // Calculate cart total
        $cartTotal = 0;
        foreach ($cartItems as $item) {
            $cartTotal += $item['Price'] * $item['Quantity'];
        }

        // Prepare data for the view
        $data = [
            'page_title' => "Shopping Cart",
            'cart_items' => $cartItems,
            'cart_total' => $cartTotal
        ];

        // Load the cart view with data
        $this->view("cart", $data);
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }

        $bookId = $_POST['book_id'] ?? null;
        $quantity = $_POST['quantity'] ?? 1;

        if (!$bookId) {
            echo json_encode(['success' => false, 'message' => 'Book ID is required']);
            return;
        }

        // Add to cart using the CartModel
        if ($this->cartModel->addToCart($bookId, $quantity)) {
            // Get updated cart items
            $cartItems = $this->cartModel->getCartItems();
            $cartCount = 0;
            foreach ($cartItems as $item){
                $cartCount += $item['Quantity'];
            }
            echo json_encode([
                'success' => true,
                'message' => 'Item added to cart successfully',
                'cart_items' => $cartItems,
                'cart_count' => $cartCount
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add item to cart']);
        }
    }

    public function getCart()
    {
        $cartItems = $this->cartModel->getCartItems();
        $cartCount = 0;
        foreach ($cartItems as $item){
                $cartCount += $item['Quantity'];
            }
        echo json_encode([
            'success' => true,
            'cart_items' => $cartItems,
            'cart_count' => count($cartItems)
        ]);
    }

    public function updateQuantity()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
            return;
        }

        $bookId = $_POST['book_id'] ?? null;
        $quantity = $_POST['quantity'] ?? 1;

        if ($this->cartModel->updateQuantity($bookId, $quantity)) {
            $cartItems = $this->cartModel->getCartItems();
            echo json_encode([
                'success' => true,
                'message' => 'Cart updated successfully',
                'cart_items' => $cartItems,
                'cart_count' => count($cartItems)
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update cart']);
        }
    }

    public function remove()
    {
        // Try to obtain book_id from routing parameters or GET query string
        $bookId = $this->params[0] ?? ($_GET['book_id'] ?? null);
        
        if (!$bookId) {
            echo json_encode(['success' => false, 'message' => 'Book ID is required']);
            return;
        }
        
        // In remove() method, after successfully removing the item:
        if ($this->cartModel->removeFromCart($bookId)) {
            $cartItems = $this->cartModel->getCartItems();
            $cartCount = 0;
            $cartTotal = 0;
            
            foreach ($cartItems as $item) {
                $cartCount += $item['Quantity'];
                $cartTotal += $item['Price'] * $item['Quantity'];
            }
            
            echo json_encode([
                'success' => true, 
                'message' => 'Item removed',
                'cart_count' => $cartCount,
                'cart_total' => $cartTotal
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to remove item']);
        }
    }
}