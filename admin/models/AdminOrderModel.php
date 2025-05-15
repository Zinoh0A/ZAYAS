<?php
class AdminOrderModel {
    private $conn;
    private $table = 'orders';
    private $itemsTable = 'order_items';

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get all orders
    public function getOrders() {
        // Base query
        $query = "SELECT o.*, u.first_name, u.last_name, u.email
                  FROM " . $this->table . " o
                  JOIN users u ON o.user_id = u.id
                  ORDER BY o.created_at DESC";

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // Get order by ID
    public function getOrderById($id) {
        // Query
        $query = "SELECT o.*, u.first_name, u.last_name, u.email, u.address, u.city, u.postal_code, u.phone
                  FROM " . $this->table . " o
                  JOIN users u ON o.user_id = u.id
                  WHERE o.id = :id";

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind parameter
        $stmt->bindParam(':id', $id);

        // Execute query
        $stmt->execute();

        return $stmt->fetch();
    }

    // Get order items
    public function getOrderItems($orderId) {
        // Query
        $query = "SELECT oi.*, p.name, p.image_path, p.type
                  FROM " . $this->itemsTable . " oi
                  JOIN products p ON oi.product_id = p.id
                  WHERE oi.order_id = :order_id";

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind parameter
        $stmt->bindParam(':order_id', $orderId);

        // Execute query
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // Update order status
    public function updateOrderStatus($id, $status) {
        // Update query
        $query = "UPDATE " . $this->table . "
                  SET status = :status
                  WHERE id = :id";

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    // Get order status counts
    public function getOrderStatusCounts() {
        // Query
        $query = "SELECT status, COUNT(*) as count
                  FROM " . $this->table . "
                  GROUP BY status";

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        $counts = [];
        while ($row = $stmt->fetch()) {
            $counts[$row['status']] = $row['count'];
        }

        return $counts;
    }

    // Get delivery information for an order
    public function getDeliveryInfo($orderId) {
        // Query
        $query = "SELECT * FROM delivery WHERE order_id = :order_id";

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind parameter
        $stmt->bindParam(':order_id', $orderId);

        // Execute query
        $stmt->execute();

        return $stmt->fetch();
    }
}
?>
