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

    public function addProduct($product, $user)
    {
        $sql = "SELECT * FROM carts where product_id=" . $product . " and user_id = " . $user;
        $query = $this->db->prepare($sql);
        $query->execute();
        if ($query->rowCount() > 0) {
            $sql = "UPDATE carts SET quantity=quantity+1 WHERE product_id=" . $product . " and user_id = " . $user;
            $query = $this->db->prepare($sql);
            $query->execute();
        } else {
            $sql = "INSERT INTO carts (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)";
            $query = $this->db->prepare($sql);
            $query->execute(array(":user_id" => $user, ":product_id" => $product, ":quantity" => 1));
        }
        $sql = "UPDATE PRODUCTS SET STOCK=STOCK-1 WHERE ID=" . $product;
        $query = $this->db->prepare($sql);
        $query->execute();
    }

    public function removeProduct($product, $user)
    {
        $sql = "select * from carts where product_id=" . $product . " and user_id = " . $user;
        $query = $this->db->prepare($sql);
        $query->execute();
        foreach ($query->fetchAll() as $item) {
            if ($item->quantity > 1) {
                $sql = "UPDATE carts SET quantity=quantity-1 WHERE product_id=" . $product . " and user_id = " . $user;
                $query = $this->db->prepare($sql);
                $query->execute();
            } else {
                $sql = "DELETE FROM carts where product_id='" . $product . "' and user_id = " . $user;
                $query = $this->db->prepare($sql);
                $query->execute();
            }
        }
        $sql = "UPDATE PRODUCTS SET STOCK=STOCK+1 WHERE ID=" . $product;
        $query = $this->db->prepare($sql);
        $query->execute();
    }

    public function getProducts()
    {
        $sql = "SELECT products.id,type,name,photo_path,price,quantity FROM carts INNER JOIN products ON carts.product_id=products.id where user_id='" . $_SESSION['userID'] . "'";
        $query = $this->db->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function clear($user)
    {
        $sql = "DELETE FROM carts where user_id='" . $user . "'";
        $query = $this->db->prepare($sql);
        $query->execute();
    }
}



