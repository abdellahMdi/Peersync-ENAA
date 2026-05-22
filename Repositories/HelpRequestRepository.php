<?php
require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . '/../Entities/HelpRequest.php'; 

function getAllRequests()
    {
        try {
            $sql = "SELECT
                        hr.id AS request_id,
                        hr.title,
                        hr.description,
                        hr.date_pub,
                        hr.date_session,
                        s.id AS skill_id,
                        s.name AS skill_name,
                       s.dificulti AS skill_difficulty,
                       st.status AS status_name,
                       learner.id AS learner_id,
                       learner.name AS learner_name,
                       learner.email AS learner_email,
                       tutor.id AS tutor_id,
                       tutor.name AS tutor_name,
                       tutor.email AS tutor_email               
                    FROM help_requests hr
                    JOIN skills s ON hr.skill_id = s.id
                    JOIN `status` st ON hr.status_id = st.id
                    JOIN users learner ON hr.learner_id = learner.id
                    LEFT JOIN users tutor ON hr.tutor_id = tutor.id
                    ORDER BY hr.date_pub DESC ;
                    ";
            $conn = DB::connect();
            $stmt = $conn->query($sql);
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
                new User($row->learner_name,$row->learner_email,"$2a$11\$gU1039/8HZFAWoT8osdxCuOCuTRMG5exXN66s4/M8Q1s9k0mMYzbK","1","1",$row->learner_id),
                new Skill($row->skill_name,$row->skill_difficulty,$row->skill_id),
                $row->status_name,
                $row->date_session ? new DateTime($row->date_session) : null,
                $row->tutor_id ? new User($row->tutor_name,$row->tutor_email,"$2a$11\$gU1039/8HZFAWoT8osdxCuOCuTRMG5exXN66s4/M8Q1s9k0mMYzbK","1",1,$row->tutor_id) : null,
                $row->request_id
            );
            $requests[] = $request;
        }

        return $requests;
    }


function creatNewRequest(){
    try{
        $conn = DB::connect();
        $sql = " INSERT INTO help_requests (title, description, date_pub, date_session, learner_id, tutor_id, skill_id, status_id)
                                    VALUES (:title, :description, :date_pub, :date_session, :learner_id, :tutor_id, :skill_id, 1)
    ";
        $stmt = $this->pdo->prepare("
        INSERT INTO help_requests (title, description, date_pub, date_session, learner_id, tutor_id, skill_id, status_id)
        VALUES (:title, :description, :date_pub, :date_session, :learner_id, :tutor_id, :skill_id, 
                (SELECT id FROM status WHERE status = :status))
    ");

    return $stmt->execute([
        ':title'        => $request->getTitle(),
        ':description'  => $request->getDescription(),
        ':date_pub'     => $request->getDatePub()->format('Y-m-d H:i:s'),
        ':date_session' => $request->getDateSession()?->format('Y-m-d H:i:s'),
        ':learner_id'   => $request->learner->getId(),
        ':tutor_id'     => $request->tutor?->getId(),
        ':skill_id'     => $request->skill->getId(),
        ':status'       => $request->getStatus(),
    ]);

    } catch(PDOException $e){
        echo "error : " . $e->getMessage();
    }
}

function bringAllSkills()
{
    $skills = [];
    try {
            $sql = "SELECT * FROM skills";
            $conn = DB::connect();
            $stmt = $conn->query($sql);
            $rows = $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch(PDOException $e){
            echo "error : " . $e->getMessage();
        }

    foreach ($rows as $row) {
        $skills[] = new Skill(
            $row->name,
            $row->dificulti,
            (int) $row->id
        );
    }

    return $skills;
}