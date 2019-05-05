<?php

class UserModel
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

    /**
     * searches for a user in the database
     * true if found
     * false if not found
     */

    public function exists($username)
    {
        $sql = "SELECT * FROM users where username='" . $username . "'";
        $query = $this->db->prepare($sql);
        $query->execute();

        if ($query->rowCount() > 0)
            return true;
        else return false;
    }

    public function insert($username, $email, $password)
    {
        $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $query = $this->db->prepare($sql);
        $query->execute(array(":username" => $username, ":email" => $email, ":password" => $password));
        /*//get the created id
        $sql = "SELECT id FROM users where username='" . $username . "'";
        $query = $this->db->prepare($sql);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $sql = "INSERT INTO carts (user_id, email, password) VALUES (:username, :email, :password)";
        $query = $this->db->prepare($sql);
        $query->execute(array(":username" => $username, ":email" => $email, ":password" => $password));*/
    }

    public function getInfo($username)
    {
        $sql = "SELECT * FROM users where username='" . $username . "'";
        $query = $this->db->prepare($sql);
        $query->execute();
        $results = $query->fetch(PDO::FETCH_ASSOC);
        return $results;
    }

    public function getUsername($userID)
    {
        $sql = "SELECT username FROM users where id='" . $userID . "'";
        $query = $this->db->prepare($sql);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}



