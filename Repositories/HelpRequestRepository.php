<?php
require_once __DIR__ . "/../config/db.php";
require_once __DIR__ . '/../Entities/HelpRequest.php'; 

function getAllRequests()
    {
        try {
            $sql ="SELECT * FROM help_requests h
            LEFT JOIN skills s ON h.skill_id = s.id 
            LEFT JOIN `status` t ON t.id = h.status_id
            LEFT JOIN users u ON u.id = h.tutor_id


            ";
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
                    ORDER BY hr.date_pub ;
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
                $row->status_id,
                $row->date_session ? new DateTime($row->date_session) : null,
                new User($row->tutor_name,$row->tutor_email,"$2a$11\$gU1039/8HZFAWoT8osdxCuOCuTRMG5exXN66s4/M8Q1s9k0mMYzbK","1","1",$row->tutor_id),
                $row->id
            );
            $requests[] = $request;
        }

        return $requests;
    }