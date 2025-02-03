<?php

class OrderModel extends Database 
{
    public function create($data) {
        try {
            $db = $this->db_connect();
            $db->beginTransaction();

            // Insert main order record
            $query = "INSERT INTO orders (user_id, total, status, billing_firstname, billing_lastname, 
                     billing_email, billing_phone, billing_address, billing_city, billing_country, 
                     billing_zipcode) VALUES (:user_id, :total, :status, :firstname, :lastname, 
                     :email, :phone, :address, :city, :country, :zipcode)";

            $statement = $db->prepare($query);
            $statement->execute([
                'user_id' => $data['user_id'] ?? null,
                'total' => $data['total'],
                'status' => $data['status'] ?? 'pending',
                'firstname' => $data['billing_details']['firstname'],
                'lastname' => $data['billing_details']['lastname'],
                'email' => $data['billing_details']['email'],
                'phone' => $data['billing_details']['phone'],
                'address' => $data['billing_details']['address'],
                'city' => $data['billing_details']['city'],
                'country' => $data['billing_details']['country'],
                'zipcode' => $data['billing_details']['zipcode']
            ]);

            $order_id = $db->lastInsertId();

            // Insert order items
            $query = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                     VALUES (:order_id, :product_id, :quantity, :price)";
            
            $statement = $db->prepare($query);

            foreach($data['items'] as $item) {
                $statement->execute([
                    'order_id' => $order_id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);
            }

            $db->commit();
            return $order_id;

        } catch(PDOException $e) {
            if($db->inTransaction()) {
                $db->rollBack();
            }
            error_log("Failed to create order: " . $e->getMessage());
            return false;
        }
    }

    public function update($order_id, $data) {
        try {
            $updates = [];
            $params = ['id' => $order_id];

            // Build dynamic update query based on provided data
            if(isset($data['status'])) {
                $updates[] = "status = :status";
                $params['status'] = $data['status'];
            }

            if(isset($data['payment_ref'])) {
                $updates[] = "payment_ref = :payment_ref";
                $params['payment_ref'] = $data['payment_ref'];
            }

            if(isset($data['payment_details'])) {
                $updates[] = "payment_details = :payment_details";
                $params['payment_details'] = $data['payment_details'];
            }

            if(empty($updates)) {
                return false;
            }

            $query = "UPDATE orders SET " . implode(', ', $updates) . " WHERE id = :id";
            
            $db = $this->db_connect();
            $statement = $db->prepare($query);
            return $statement->execute($params);

        } catch(PDOException $e) {
            error_log("Failed to update order: " . $e->getMessage());
            return false;
        }
    }

    public function get($order_id) {
        try {
            $query = "SELECT o.*, 
                     GROUP_CONCAT(
                         JSON_OBJECT(
                             'id', oi.product_id,
                             'quantity', oi.quantity,
                             'price', oi.price
                         )
                     ) as items
                     FROM orders o
                     LEFT JOIN order_items oi ON o.id = oi.order_id
                     WHERE o.id = :id
                     GROUP BY o.id";

            $db = $this->db_connect();
            $statement = $db->prepare($query);
            $statement->execute(['id' => $order_id]);
            
            $order = $statement->fetch(PDO::FETCH_ASSOC);
            
            if($order) {
                // Parse the JSON string of items back into an array
                $order['items'] = json_decode('[' . $order['items'] . ']', true);
            }

            return $order;

        } catch(PDOException $e) {
            error_log("Failed to get order: " . $e->getMessage());
            return false;
        }
    }

    public function getUserOrders($user_id, $limit = 10, $offset = 0) {
        try {
            $query = "SELECT o.*, 
                     GROUP_CONCAT(
                         JSON_OBJECT(
                             'id', oi.product_id,
                             'quantity', oi.quantity,
                             'price', oi.price
                         )
                     ) as items
                     FROM orders o
                     LEFT JOIN order_items oi ON o.id = oi.order_id
                     WHERE o.user_id = :user_id
                     GROUP BY o.id
                     ORDER BY o.created_at DESC
                     LIMIT :limit OFFSET :offset";

            $db = $this->db_connect();
            $statement = $db->prepare($query);
            
            $statement->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
            $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
            
            $statement->execute();
            
            $orders = $statement->fetchAll(PDO::FETCH_ASSOC);
            
            // Parse the JSON strings of items back into arrays
            foreach($orders as &$order) {
                $order['items'] = json_decode('[' . $order['items'] . ']', true);
            }

            return $orders;

        } catch(PDOException $e) {
            error_log("Failed to get user orders: " . $e->getMessage());
            return false;
        }
    }

    public function getOrderByPaymentRef($payment_ref) {
        try {
            $query = "SELECT * FROM orders WHERE payment_ref = :payment_ref LIMIT 1";
            
            $db = $this->db_connect();
            $statement = $db->prepare($query);
            $statement->execute(['payment_ref' => $payment_ref]);
            
            return $statement->fetch(PDO::FETCH_ASSOC);

        } catch(PDOException $e) {
            error_log("Failed to get order by payment reference: " . $e->getMessage());
            return false;
        }
    }

    public function getOrderStats($user_id = null) {
        try {
            $params = [];
            $where = "";
            
            if($user_id) {
                $where = "WHERE user_id = :user_id";
                $params['user_id'] = $user_id;
            }

            $query = "SELECT 
                        COUNT(*) as total_orders,
                        SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_orders,
                        SUM(CASE WHEN status = 'paid' THEN 1 ELSE 0 END) as completed_orders,
                        SUM(total) as total_revenue
                     FROM orders " . $where;

            $db = $this->db_connect();
            $statement = $db->prepare($query);
            $statement->execute($params);
            
            return $statement->fetch(PDO::FETCH_ASSOC);

        } catch(PDOException $e) {
            error_log("Failed to get order stats: " . $e->getMessage());
            return false;
        }
    }
}