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


                if ($rows['id'] === 6) {
                    header("location: index.php");
                }
                else{
                    header("location: profile.php");
                }

                
            }
            else{
                echo "Incorrect Password";
            }
        }
        else{
            echo "Incorrect Username Or Email";
        }

    }

    public function adminPanel(){

        $id = $_SESSION['user_id'];

        if ($id != 6) {
            echo "ONLY ADMIN CAN VIEW THIS PAGE";
        }
    }

    public function checkLogin(){
        if (!empty($_SESSION['user_id'])) {
            header("location: profile.php");
        }
        
    }

    public function profile_data($id){

        $profile_query = "SELECT user_name , user_email , user_pass , user_num , 
        user_country , user_city , user_profile_img FROM user_data WHERE id = ?";

        $stat = $this->conn->prepare($profile_query);
        $stat->bind_param("i" , $id);

        $stat->execute();

        return $res = $stat->get_result();

    }

    public function viewAll(){

        $viewAll_query = "SELECT * FROM user_data";

        $stat = $this->conn->query($viewAll_query);

        return $stat;

    }

    public function getByID($id){

        $getByID_query = "SELECT * FROM user_data WHERE id = ?";
        $stat = $this->conn->prepare($getByID_query);
        $stat->bind_param("i" , $id);
        $stat->execute();

        return $res = $stat->get_result();

    }

    public function updateData($id , $user_name , $user_email , $user_pass , $user_num , $user_country ,
        $user_city , $user_profile_img){
        

        if (!empty($user_pass)) {
            $hash = password_hash($user_pass , PASSWORD_BCRYPT);
        }
        else{
            $old_pass = $this->getByID($id);
            $get_old_pass = $old_pass->fetch_assoc();
            $hash = $get_old_pass['user_pass'];
        };


        $final_img = "";

        if (!empty($user_profile_img)) {
            $final_img = $_FILES['user_img'];

        $target_dir = "uploads/";
        $file_name = uniqid() . "_" . basename($final_img['name']);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($final_img['tmp_name'] , $target_file)) {
            $final_img = $target_file;
        }
    }
        else{
            $old_img = $this->getByID($id);
            $get_old_img = $old_img->fetch_assoc();
            $new_img = $get_old_img['user_profile_img'];
        }

        $update_query = "UPDATE user_data SET user_name = ? , user_email = ? , user_pass = ? , user_num = ? , 
        user_country = ? , user_city = ? , user_profile_img = ? WHERE id = ?";
        $stat = $this->conn->prepare($update_query);
        $stat->bind_param("sssisssi" , $user_name , $user_email , $hash , $user_num , $user_country ,
        $user_city , $final_img , $id);
        return $stat->execute();
    }

    public function deleteData($id){

        $delete_query = "DELETE FROM user_data WHERE id = ?";
        $stat = $this->conn->prepare($delete_query);
        $stat->bind_param("i" , $id);
        return $stat->execute();

    }
}