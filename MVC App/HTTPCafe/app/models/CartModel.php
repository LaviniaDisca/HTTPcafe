<?php

class CartModel
{
    /**
     * Every model needs a database connection, passed to the model
     * @param object $db A PDO database connection
     */
    function __construct($db)
    {
        try {
            $this->db = $db;
        } catch (PDOException $e) {
            exit('Database connection could not be established.');
        }
    }

    public function addProduct($product)
    {
        $sql = "INSERT INTO carts (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)";
        $query = $this->db->prepare($sql);
        $query->execute(array(":user_id" => $_SESSION["userID"], ":product_id" => $product, ":quantity" => 1));
    }

    public function removeProduct($product)
    {
        $sql="DELETE FROM carts where product_id='".$product."'";
        $query = $this->db->prepare($sql);
        $query->execute();
    }

    public function getProducts()
    {
        $sql = "SELECT products.id,type,name,photo_path,price FROM carts INNER JOIN products ON carts.product_id=products.id where user_id='" . $_SESSION['userID'] . "'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }
}


