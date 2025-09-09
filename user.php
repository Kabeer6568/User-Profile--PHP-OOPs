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
                
                header("location: profile.php");
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

    public function login($userInput , $userpass){

        $login_query = "SELECT * FROM user_data WHERE user_name = ? OR user_email = ?";
        $stat = $this->conn->prepare($login_query);
        $stat->bind_param("ss" , $userInput , $userInput );
        $stat->execute();
        $res = $stat->get_result();

        if ($res->num_rows > 0) {
            $rows = $res->fetch_assoc();
            $stored_hash = $rows['user_pass'];
            if (password_verify($userpass , $stored_hash)) {
                $_SESSION['user_id'] = $rows['id'];
                $_SESSION['user_name'] = $rows['user_name'];

                echo "Login successful. Welcome" . htmlspecialchars($rows['user_name']);
            }
            else{
                echo "Incorrect Password";
            }
        }
        else{
            echo "Incorrect Username Or Email";
        }


    }

}