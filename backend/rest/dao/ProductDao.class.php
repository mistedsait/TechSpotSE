<?php

require_once __DIR__ . "/BaseDao.class.php";

class ProductDao extends BaseDao 
{

    public function __construct()
    {
       parent::__construct('products');
    }

    public function getProductsByCategory($category)
    {
        try {
            $query = "SELECT name,price,image,product_id FROM products";
            if ($category !== 'all') {
                $query .= " WHERE category = :category";
            }
            $statement = $this->connection->prepare($query);
            if ($category !== 'all') {
                $statement->bindParam(':category', $category);
            }
            $statement->execute();
            $products = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $products;
        } catch (PDOException $e) {
            throw $e;
        }
        
    }
    public function getProductById($id) {
        try {
            $query = "SELECT * FROM products WHERE product_id = :id";
            $statement = $this->connection->prepare($query);
            $statement->bindParam(':id', $id, PDO::PARAM_INT);
            $statement->execute();
            $product = $statement->fetch(PDO::FETCH_ASSOC);
            return $product;
        } catch (PDOException $e) {
            throw $e;
        }
    }
    public function add_product($product_item)
    {
        return $this->insert('products', $product_item);
    }

    public function delete_product($id) {  
        $this->execute("DELETE FROM products WHERE product_id = :id", ["id" => $id]);
    }
    public function update_product($product_id, $product)
    {
        $this->execute_update('products', $product_id, $product_id);
    }

}

