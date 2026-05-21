<?php
require_once __DIR__ . "/../config/db.php";

function getUserByEmail($email){
    try{
        $sql = "SELECT users.id,users.name,users.email,users.password,users.first_time,roles.role FROM users
                JOIN roles ON roles.id = users.role_id
                WHERE users.email = '". $email . "'";
        $conn = DB::connect();
        $stmt = $conn->query($sql);
        $res = $stmt->fetch(PDO::FETCH_OBJ);
        return $res;
    } catch(PDOException $e){
        echo "error : " . $e->getMessage();
    }
      

}

function updateFirstTime($user_id) {
    try {
        $sql = "UPDATE users SET first_time = '1' WHERE id = ?";
        $conn = DB::connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute([$user_id]);
         
    } catch (PDOException $e) {
        echo "Error : " . $e->getMessage() ;
    }
}       