<?php
require_once __DIR__ . '/BaseDao.class.php';

class OrderDao extends BaseDao {

    public function __construct() {
        parent::__construct("orders");
    }

    public function get_order_by_id($id) {
        return $this->query_unique("SELECT * FROM orders WHERE id = :id", ["id" => $id]);
    }

    public function add_order($order_item) {
        return $this->insert('orders', $order_item);
    }

    public function update_order($id, $order_item) {
        $this->execute_update('orders', $id, $order_item);
    }

    public function delete_order($id) { 
        $this->execute("DELETE FROM orders WHERE id = :id", ["id" => $id]);
    }
    
    public function get_orders_by_user($user_id, $offset = 0, $limit = 25, $order = "id")
{
    list($order_column, $order_direction) = self::parse_order($order);
    $query = "SELECT *
              FROM orders
              WHERE user_id = :user_id
              ORDER BY {$order_column} {$order_direction}
              LIMIT {$limit} OFFSET {$offset}";
    return $this->query($query, ["user_id" => $user_id]);
}

}