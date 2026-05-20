<?php
require_once __DIR__ . "../config/db.php";

session_start();
    $_SESSION['error'] = "";
    $email = htmlentities($_POST["email"]);
    $password = password_hash($_POST["password"]);

if(isset($_POST["submit"])){
    header('Location: ../suggestions/index.php'); # path
    exit ;
}
if(empty($_POST["email"]))
 {
     $_SESSION['error'] = "you have to enter the email";
     header('Location: ../suggestions/index.php'); # path
     exit ;
 } elseif (empty($_POST["password"])) {
     $_SESSION['error'] = "you have to enter the password";
     header('Location: ../suggestions/index.php'); # path
     exit ;
 }
 
 function checkUserEntries($email , $passord){
    $sql = "SELECT u.id,u.name,u.email,u.password,u.first_time,r.role FROM users u 
            JOIN roles r ON r.id = u.role_id
            WHERE u.email = ". $email ;
    $conn = DB::connect();
    $stmt = $conn->query($sql);
    $response = $stmt->fetchAll(PDO::FETCH_OBJ);
    if(!empty($response)){
    $_SESSION['error'] = "this email : ".$email." Doesn't belong to any student";
     header('Location: ../suggestions/index.php'); # path
     exit ;
    }
    $_SESSION['user_id'] = $respose->id ;
    $_SESSION['user_name'] = $respose->name ;
    $_SESSION['user_email'] = $respose->email ;
    $_SESSION['user_role'] = $respose->role ;

    if($respose->role == "apprenant"){
        if($respose->first_time == 0){
            header('Location: ../suggestions/first_login.php'); # path



        }else {
            header('Location: ../suggestions/dashboard.php'); # path
        }
         exit ;
    }

 }


 unset($_SESSION['error']);