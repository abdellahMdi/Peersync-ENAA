<?php
require_once __DIR__ . "/../config/db.php";

function getUserByEmail($email){
    try{
        $sql = "SELECT u.id,u.name,u.email,u.password,u.first_time,r.role FROM users u 
                JOIN roles r ON r.id = u.role_id
                WHERE u.email = ". $email;
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