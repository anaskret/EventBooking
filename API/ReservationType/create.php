<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    include_once '../config/database.php';
    include_once '../objects/reservationtype.php';

    $database = new Database();
    $db = $database->getConnection();

    $type = new ReservationType($db);

    $data = json_decode(file_get_contents("php://input"));

    if(
        !empty($data->id) &&
        !empty($data->name) &&
        !empty($data->price) &&
        !empty($data->numberAvailable) &&
        !empty($data->eventId )
    ){
        $type->id = $data->id;
        $type->name = $data->name;
        $type->price = $data->price;
        $type->numberAvailable = $data->numberAvailable;
        $type->eventId = $data->eventId;

        if($type->create()){

            http_response_code(201);

            echo json_encode(array("message" => "Reservation type was created."));
        }
        else{

            http_response_code(503);
           // echo json_encode(array("message" => $type->error_get_last));
            echo json_encode(array("message" => "Unable to create reservation type."));
        }
    }
    else{
        
        http_response_code(400);

        echo json_encode(array("message" => "Unable to create reservation type. Data is incomplete"));
    }
?>