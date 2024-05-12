<?php

require_once __DIR__ . "/../dao/ProductDao.class.php";

class ProductService {
    
    private $product_dao;

    public function __construct(){
        $this->product_dao = new ProductDao();
    }

    public function getProductsByCategory($category){
        return $this->product_dao->getProductsByCategory($category);
    }
    public function add_product($product_item) {
        return $this->product_dao->add_product($product_item);
    }
    public function delete_product($product_id) {
        return $this->product_dao->delete_product($product_id);
    }
    public function update_product($product_id, $product)
    {
        $this->product_dao->update_product($product_id, $product);
    }
}
