<?php
require_once __DIR__ . "/BaseDao.class.php";

class CartDao extends BaseDao {

    public function __construct() {
        parent::__construct('cart_items');
    }

    public function add_to_cart($cart_item) {
        // Check if the product is already in the user's cart
        $existing_item = $this->query_unique("SELECT * FROM cart_items WHERE user_id = :user_id AND product_id = :product_id", [
            "user_id" => $cart_item['user_id'],
            "product_id" => $cart_item['product_id']
        ]);

        if ($existing_item) {
            // If the product is already in the cart, update the quantity
            $this->execute("UPDATE cart_items SET quantity = quantity + :quantity WHERE user_id = :user_id AND product_id = :product_id", [
                "quantity" => $cart_item['quantity'],
                "user_id" => $cart_item['user_id'],
                "product_id" => $cart_item['product_id']
            ]);
            return $this->query_unique("SELECT * FROM cart_items WHERE cart_item_id = :cart_item_id", ["cart_item_id" => $existing_item['cart_item_id']]);
        } else {
            // If the product is not in the cart, insert a new row
            $this->execute("INSERT INTO cart_items (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)", [
                "user_id" => $cart_item['user_id'],
                "product_id" => $cart_item['product_id'],
                "quantity" => $cart_item['quantity']
            ]);
            return $this->query_unique("SELECT * FROM cart_items WHERE cart_item_id = :cart_item_id", ["cart_item_id" => $this->connection->lastInsertId()]);
        }
    }

    public function get_cart_products($user_id) {
        $query = "
            SELECT ci.cart_item_id,ci.product_id, ci.quantity, p.name as product_name, p.image as product_image, p.price as product_price
            FROM cart_items ci
            JOIN products p ON ci.product_id = p.product_id
            WHERE ci.user_id = :user_id
        ";
        return $this->query($query, ['user_id' => $user_id]);
    }
    

    

    public function remove_from_cart($cart_item_id) {
        return $this->execute("DELETE FROM cart_items WHERE cart_item_id = :cart_item_id", ["cart_item_id" => $cart_item_id]);
    }

    public function update_cart_item($cart_item_id, $quantity) {
        return $this->execute("UPDATE cart_items SET quantity = :quantity WHERE cart_item_id = :cart_item_id", [
            "quantity" => $quantity,
            "cart_item_id" => $cart_item_id
        ]);
    }
}

?>
