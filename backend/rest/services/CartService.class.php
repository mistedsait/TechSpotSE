<?php

require_once __DIR__ . "/../dao/CartDao.class.php";

class CartService {
    
    private $cart_dao;

    public function __construct(){
        $this->cart_dao = new CartDao();
    }

    public function add_to_cart($cart_item) {
        return $this->cart_dao->add_to_cart($cart_item);
    }

    public function get_cart_products($user_id) {
        return $this->cart_dao->get_cart_products($user_id);
    }

    public function remove_from_cart($cart_item_id) {
        return $this->cart_dao->remove_from_cart($cart_item_id);
    }

    public function update_cart_item($cart_item_id, $quantity) {
        return $this->cart_dao->update_cart_item($cart_item_id, $quantity);
    }
}

?>
