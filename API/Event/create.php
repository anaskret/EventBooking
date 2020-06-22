<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../config/database.php';
    include_once '../objects/event.php';

    $database = new Database();
    $db = $database->getConnection();

    $event = new Event($db);

    $data = json_decode(file_get_contents("php://input"));

    if(
        !empty($data->id) &&
        !empty($data->name) &&
        !empty($data->description) &&
        !empty($data->location) &&
        !empty($data->numberOfReservations) &&
        !empty($data->date)
    ){
        $event->id= $data->id;
        $event->name = $data->name;
        $event->description = $data->description;
        $event->location = $data->location;
        $event->numberOfReservations = $data->numberOfReservations;
        $event->date = $data->date;

        if($event->create()){

            http_response_code(201);

            echo json_encode(array("message" => "Event was created."));
        }
        else{
            http_response_code(503);
            echo json_encode(array("message" => "Unable to create event."));
        }
    }
    else{
        http_response_code(400);
        echo json_encode(array("message" => "Unable to create event. Data is incomplete."));
    }
?>