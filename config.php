<?php

class database{

    private $host = "localhost";
    private $username = "root";
    private $password = "";

    public $conn;

    public function __construct(){
        $this->conn = new mysqli($this->host , $this->username , $this->password);
        
        if ($this->conn->connect_error) {
            echo "NOT CONNECTED" . $this->conn->connect_error;
        } 
        else{
            $this->createDB();
        }
    }

    private function createDB(){

        $createdb = "CREATE DATABASE IF NOT EXISTS user_profile";
        
        if ($this->conn->query($createdb) == FALSE) {
            echo "Error Creating table" . $this->conn->error;
        }
        else{
            $this->createTable();
        }
    }

    private function createTable(){

        $usedb = "USE user_profile";

        $this->conn->query($usedb);

        $table = "CREATE TABLE IF NOT EXISTS user_data (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_name VARCHAR(255) NOT NULL,
        user_email VARCHAR(255) NOT NULL,
        user_pass VARCHAR(255) NOT NULL,
        user_num INT NOT NULL,
        user_country VARCHAR(255) NOT NULL,
        user_city VARCHAR(255) NOT NULL,
        user_profile_img VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

        $res = $this->conn->query($table);

        if ($res == FALSE) {
            echo "ERROR CREATING TABLE";
        }

    }


}