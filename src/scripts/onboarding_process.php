<?php
session_start();
require_once __DIR__ . "/../Repositories/UserRepository.php";
require_once __DIR__ . '/../Entities/UserSkill.php';
require_once __DIR__ . '/../Entities/Skill.php';
if(!isset($_SESSION["user_id"]) || empty($_SESSION["user_id"])){
    header('Location: ../Pages/index.php'); #path
    exit;
}
$skills = $_POST['skills'] ?? [];

foreach ($skills as $skillId => $maitrise) {
    addUserSkill($_SESSION["user_id"], $skillId, $maitrise);
    
}
header('Location: ../Pages/dashboard.php'); #path
exit ;