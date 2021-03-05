<?php
require_once "database.php";

class User extends Database{
    public function login($username,$password){
        $error = "The username or password you entered is incorrect";
        $sql = "SELECT * FROM users WHERE username = '$username'";

        $result = $this->conn->query($sql);
        if ($result->num_rows == 1) {
            $user_details = $result->fetch_assoc();
            if (password_verify($password,$user_details['password'])) {
                session_start();

                $_SESSION['id'] = $user_details['id'];
                $_SESSION['username'] = $user_details['username'];

                header("location: ../views/dashboard.php");
                exit;
            } else {
                echo $error;
            }
        }else {
            echo $error;
        }
    }

    public function createUser($first_name,$last_name,$username,$password,$origin){
        $sql = "INSERT INTO users(first_name,last_name,username,`password`) VALUES ('$first_name','$last_name','$username','$password')";

        if ($this->conn->query($sql)) {
            if ($origin == "register") {
                header("location: ../views");
                exit;
            }elseif ($origin == "dashboard") {
                header("location: ../views/dashboard.php");
            }
            
        }else{
            die("Error creating user: ".$this->conn->error);
        }
    }

    public function getUsers(){
        $sql = "SELECT id, first_name, last_name, username FROM users";

        if ($result = $this->conn->query($sql)) {
            return $result;
        }else{
            die("Error retrieving users: ".$this->conn->error);
        }
    }

    public function getUser($user_id){
        $sql = "SELECT id , first_name, last_name , username From users WHERE id = $user_id";

        if ($result = $this->conn->query($sql)) {
            return $result->fetch_assoc();
        }else{
            die("Error retrieving user: ".$this->conn->error);
        }
    }

    public function updateUser($first_name,$last_name,$username,$user_id){
        $sql = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', username = '$username' WHERE id = $user_id";

        if($this->conn->query($sql)){
            header("location: ../views/dashboard.php");
            exit;
        }else{
            die("Error updating user: ".$this->conn->error);
        }

    }

    public function deleteUser($user_id){
        $sql = "DELETE FROM users WHERE id = $user_id";

        if ($this->conn->query($sql)) {
            header("location: ../views/dashboard.php");
            exit;
        }else{
            die("Error deleting user: ".$this->conn->error);
        }
    }

}
