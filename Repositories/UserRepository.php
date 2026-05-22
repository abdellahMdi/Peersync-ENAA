<?php
require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . '/../Entities/HelpRequest.php'; 

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

function updateFirstTime(int $user_id) {
    try {
        $sql = "UPDATE users SET first_time = '1' WHERE id = ?";
        $conn = DB::connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute([$user_id]);
         
    } catch (PDOException $e) {
        echo "Error : " . $e->getMessage() ;
    }
}       

function getAllSkills(){
    try {
            $sql = "SELECT id,name FROM skills";
            $conn = DB::connect();
            $stmt = $conn->query($sql);
            $res = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $res;
        } catch(PDOException $e){
            echo "error : " . $e->getMessage();
        }
}
function addUserSkill(int $userId, int $skillId, string $maitrise)
    {
        $allowed = ['maîtrisées', 'à travailler'];

        if (!in_array($maitrise, $allowed, true)) {
            $maitrise = 'à travailler';
        }
        
        try {
            $sql ="INSERT INTO user_skills (user_id, skill_id, maitrise) VALUES (?, ?, ?)";
            $conn = DB::connect();
            $stmt = $conn->prepare($sql);
            $stmt->execute([$userId, $skillId, $maitrise]);
        } catch(PDOException $e){
            echo "error : " . $e->getMessage();
        }
    }
function getAllRequests()
    {
        try {
            $sql ="SELECT * FROM help_requests h
            LEFT JOIN skills s ON h.skill_id = s.id 
            LEFT JOIN `status` t ON t.id = h.status_id
            LEFT JOIN users u ON u.id = h.tutor_id


            ";
            $sql = "SELECT
                        -- Help Request data
                        hr.id AS request_id,
                        hr.title,
                        hr.description,
                        hr.date_pub,
                        hr.date_session,
                        -- Skill data
                        s.id AS skill_id,
                        s.name AS skill_name,
                       s.dificulti AS skill_difficulty,
                       -- Status data
                       st.status AS status_name,
                       -- Learner data
                       learner.id AS learner_id,
                       learner.name AS learner_name,
                       learner.email AS learner_email,
                       -- Tutor data
                       tutor.id AS tutor_id,
                       tutor.name AS tutor_name,
                       tutor.email AS tutor_email               
                    FROM help_requests hr
                    -- Join skill
                    JOIN skills s ON hr.skill_id = s.id
                    -- Join status
                    JOIN `status` st ON hr.status_id = st.id
                    -- Join learner 
                    JOIN users learner ON hr.learner_id = learner.id
                    -- Left join tutor
                    LEFT JOIN users tutor ON hr.tutor_id = tutor.id;";
            $conn = DB::connect();
            $stmt = $conn->query("SELECT * FROM help_requests");
            $rows = $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch(PDOException $e){
            echo "error : " . $e->getMessage();
        }
        $requests = [];

        foreach ($rows as $row) {
            $request = new HelpRequest(
                $row->title,
                $row->description,
                new DateTime($row->date_pub),
                $row->learner_id,
                $row->skill_id,
                $row->status_id,
                $row->date_session ? new DateTime($row->date_session) : null,
                $row->tutor_id,
                $row->id
            );

            $requests[] = $request;
        }

        return $requests;
    }
