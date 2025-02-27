<?php
//// filepath: /Applications/MAMP/htdocs/phpbookstore/app/models/CartModel.php

class CartModel
{
    private $db;

    public function __construct()
    {
        // Instantiate the admin Database class
        $this->db = new Database();
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    public function addToCart($bookId, $quantity)
    {
        if (isset($_SESSION['UserID'])) {
            // Logged in user – store in database
            return $this->addToDbCart($_SESSION['UserID'], $bookId, $quantity);
        } else {
            // Guest user – store in session
            return $this->addToSessionCart($bookId, $quantity);
        }
    }

    private function addToDbCart($userId, $bookId, $quantity)
    {
        try {
            $conn = $this->db->getConnection();
            // Check if the book is already in the cart
            $stmt = $conn->prepare("SELECT * FROM tbCart WHERE UserID = ? AND BookID = ?");
            $stmt->execute([$userId, $bookId]);
            $existingItem = $stmt->fetch(PDO::FETCH_OBJ);

            if ($existingItem) {
                // Update existing cart item
                $stmt = $conn->prepare("UPDATE tbCart SET Quantity = Quantity + ? WHERE UserID = ? AND BookID = ?");
                return $stmt->execute([$quantity, $userId, $bookId]);
            } else {
                // Insert new cart item
                $stmt = $conn->prepare("INSERT INTO tbCart (UserID, BookID, Quantity) VALUES (?, ?, ?)");
                return $stmt->execute([$userId, $bookId, $quantity]);
            }
        } catch (Exception $e) {
            error_log("Error adding to DB cart: " . $e->getMessage());
            return false;
        }
    }

    private function addToSessionCart($bookId, $quantity)
    {
        try {
            $query = "SELECT BookID, Title, Price, Image FROM tbBook WHERE BookID = ?";
            $conn = $this->db->getConnection();
            $stmt = $conn->prepare($query);
            $stmt->execute([$bookId]);
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);

            if (!$result || empty($result)) {
                error_log("Book not found: BookID = " . $bookId);
                return false;
            }

            $book = $result[0];
            $bookData = [
                'BookID'   => $book->BookID,
                'Title'    => $book->Title,
                'Price'    => (float)$book->Price,
                'Image'    => $book->Image ?? '',
                'Quantity' => (int)$quantity
            ];

            $found = false;
            // Ensure each item has a BookID key before comparing
            foreach ($_SESSION['cart'] as &$item) {
                if (isset($item['BookID']) && $item['BookID'] == $bookId) {
                    $item['Quantity'] += $quantity;
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $_SESSION['cart'][] = $bookData;
            }

            return true;
        } catch (Exception $e) {
            error_log("Error adding to session cart: " . $e->getMessage());
            return false;
        }
    }

    public function getCartItems()
    {
        if (isset($_SESSION['UserID'])) {
            try {
                $conn = $this->db->getConnection();
                $stmt = $conn->prepare("SELECT c.CartID, c.BookID, c.Quantity, b.Title, b.Price, b.Image 
                    FROM tbCart c 
                    JOIN tbBook b ON c.BookID = b.BookID 
                    WHERE c.UserID = ?");
                $stmt->execute([$_SESSION['UserID']]);
                $result = $stmt->fetchAll(PDO::FETCH_OBJ);

                if (!$result) {
                    return [];
                }

                return array_map(function ($item) {
                    return [
                        'BookID'   => $item->BookID,
                        'Title'    => $item->Title,
                        'Price'    => (float)$item->Price,
                        'Quantity' => (int)$item->Quantity,
                        'Image'    => $item->Image ?? '',
                        'CartID'   => $item->CartID
                    ];
                }, $result);
            } catch (Exception $e) {
                error_log("Error getting cart items from database: " . $e->getMessage());
                return [];
            }
        } else {
            return array_map(function ($item) {
                return [
                    'BookID'   => $item['BookID'] ?? 0,
                    'Title'    => $item['Title'] ?? 'Unknown Book',
                    'Price'    => (float)($item['Price'] ?? 0),
                    'Quantity' => (int)($item['Quantity'] ?? 1),
                    'Image'    => $item['Image'] ?? ''
                ];
            }, $_SESSION['cart'] ?? []);
        }
    }

    public function updateQuantity($bookId, $quantity, $cartId = null)
    {
        if (isset($_SESSION['UserID'])) {
            try {
                $conn = $this->db->getConnection();
                $stmt = $conn->prepare("UPDATE tbCart SET Quantity = ? WHERE CartID = ?");
                return $stmt->execute([$quantity, $cartId]);
            } catch (Exception $e) {
                error_log("Error updating quantity: " . $e->getMessage());
                return false;
            }
        } else {
            foreach ($_SESSION['cart'] as &$item) {
                if (isset($item['BookID']) && $item['BookID'] == $bookId) {
                    $item['Quantity'] = $quantity;
                    break;
                }
            }
            return true;
        }
    }

    public function removeFromCart($bookId) {
        try {
            if (isset($_SESSION['UserID'])) {
                // Remove from database for logged in user
                $conn = $this->db->getConnection();
                $stmt = $conn->prepare("DELETE FROM tbCart WHERE UserID = ? AND BookID = ?");
                $success = $stmt->execute([$_SESSION['UserID'], $bookId]);
            } else {
                // Remove from session cart for guest user
                if (isset($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $index => $item) {
                        if ($item['BookID'] == $bookId) {
                            unset($_SESSION['cart'][$index]);
                            $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex array
                            $success = true;
                            break;
                        }
                    }
                }
            }
            return $success ?? false;
        } catch (Exception $e) {
            error_log("Error removing from cart: " . $e->getMessage());
            return false;
        }
    }

    // Transfer session cart items to database after login
    public function transferSessionCartToDb($userId)
    {
        if (!empty($_SESSION['cart'])) {
            foreach ($_SESSION['cart'] as $item) {
                if (isset($item['BookID']) && isset($item['Quantity'])) {
                    $this->addToDbCart($userId, $item['BookID'], $item['Quantity']);
                }
            }
            // Clear session cart after transfer
            $_SESSION['cart'] = [];
        }
    }
}