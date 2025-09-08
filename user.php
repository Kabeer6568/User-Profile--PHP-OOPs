<?php

require_once "config.php";



class Users{

    private $conn;

    public function __construct(){
        $db = new Database;
        $this->conn = $db->conn;
    }

    public function register($user_name , $user_email , $user_pass , $user_num , $user_country ,
    $user_city , $user_profile_img)
    {
        $user_profile_img = $_FILES['user_img'];

        $target_dir = "uploads/";
        $file_name = uniqid() . "_" . basename($user_profile_img['name']);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($user_profile_img['tmp_name'] , $target_file)) {
           
            $pass_hash = password_hash($user_pass , PASSWORD_BCRYPT);

            $register_query = "INSERT INTO user_data (user_name , user_email , user_pass , user_num , 
            user_country , user_city , user_profile_img) VALUES (?,?,?,?,?,?,?)";

            $stat = $this->conn->prepare($register_query);
            $stat->bind_param("sssisss" , $user_name , $user_email , $pass_hash , $user_num , $user_country ,
            $user_city , $target_file);

            if ($stat->execute()) {
                echo "User Registered";
            }
        }
        else{
            echo "Error uploading Image";
        }


    }

    public function checkemail($email){

        
        $check_email = "SELECT * FROM user_data WHERE user_email = ?";
        $stat = $this->conn->prepare($check_email);
        $stat->bind_param("s" , $email);
        $stat->execute();
        $result = $stat->get_result();
        
        return $result->num_rows > 0;
    }

}