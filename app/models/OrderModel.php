<?php

class OrderModel 
{
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function createOrder($order_data) {
    try {
        $conn = $this->db->getConnection();
        
        error_log("Creating order with data: " . print_r($order_data, true));
        
        // Use the stored procedure from your SQL file
        $stmt = $conn->prepare("CALL sp_InsertOrder(?, ?, ?, ?, ?)");
        
        $params = [
            $order_data['UserID'],
            $order_data['TotalAmount'],
            $order_data['Status'],
            $order_data['ShippingAddress'],
            $order_data['PaymentMethod']
        ];

        error_log("Executing sp_InsertOrder with params: " . print_r($params, true));
        
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        error_log("Stored procedure result: " . print_r($result, true));
            
            if ($result && isset($result['OrderID'])) {
                return $result['OrderID'];
            }
            
            throw new Exception("Failed to get OrderID after creation");

        } catch (PDOException $e) {
            error_log("Order Creation Error: " . $e->getMessage());
            throw $e;
        }
    }

    public function addOrderDetail($detail) {
        try {
            $conn = $this->db->getConnection();
            
            // Use the stored procedure from your SQL file
            $stmt = $conn->prepare("CALL sp_InsertOrderDetail(?, ?, ?, ?)");
            
            $params = [
                $detail['OrderID'],
                $detail['BookID'],
                $detail['Quantity'],
                $detail['Price']
            ];

            $stmt->execute($params);
            return true;

        } catch (PDOException $e) {
            error_log("Order Detail Creation Error: " . $e->getMessage());
            throw $e;
        }
    }

    public function getUserOrders($userId) {
        try {
            $conn = $this->db->getConnection();
            $stmt = $conn->prepare("CALL sp_GetUserOrders(?)");
            $stmt->execute([$userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get User Orders Error: " . $e->getMessage());
            return [];
        }
    }

    public function clearCart() {
        try {
            if (isset($_SESSION['UserID'])) {
                $conn = $this->db->getConnection();
                $stmt = $conn->prepare("DELETE FROM tbCart WHERE UserID = ?");
                $stmt->execute([$_SESSION['UserID']]);
            }
            // Also clear session cart if exists
            if (isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            return true;
        } catch (PDOException $e) {
            error_log("Clear Cart Error: " . $e->getMessage());
            return false;
        }
    }
}