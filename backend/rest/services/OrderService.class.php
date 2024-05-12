<?php
require_once __DIR__ . '/../dao/OrderDao.class.php';

class OrderService {

    private $order_dao;

    public function __construct() {
        $this->order_dao = new OrderDao();
    }

    public function get_order_by_id($order_id) {
        return $this->order_dao->get_order_by_id($order_id);
    }

    public function get_orders_by_user($user_id, $offset = 0, $limit = 25, $order = "id") {
        return $this->order_dao->get_orders_by_user($user_id, $offset, $limit, $order);
    }
    

    public function add_order($order_item) {
        return $this->order_dao->add_order($order_item);
    }

    public function delete_order($order_id) {
        return $this->order_dao->delete_order($order_id);
    }

    public function update_order($order_id, $order)
    {
        $this->order_dao->update_order($order_id, $order);
    }
}
