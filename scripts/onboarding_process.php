<?php
// scripts/onboarding_process.php
session_start();

// $_POST['skills'] looks like this:
// [
//   '3'  => 'maitrisee',
//   '5'  => 'a_travailler',
//   '7'  => 'maitrisee',
// ]
// Key = skill id, Value = 'maitrisee' or 'a_travailler'
// Skills the user left as 'none' are simply absent from the array.

$skills = $_POST['skills'] ?? [];

foreach ($skills as $skillId => $maitrise) {
    $skillId  = (int) $skillId;                          // always cast to int
    $maitrise = htmlspecialchars($maitrise);             // sanitize
    echo $skillId . " : " . $maitrise ;
    // validate the value matches your ENUM
    if (!in_array($maitrise, ['maitrisee', 'a_travailler'])) {
        continue; // skip anything unexpected
    }

    // insert into user_skills
    // $repo->addUserSkill($_SESSION['user_id'], $skillId, $maitrise);
}