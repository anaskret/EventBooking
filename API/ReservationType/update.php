<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: PUT");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../config/database.php';
    include_once '../objects/reservationtype.php';

    $database = new Database();
    $db = $database->getConnection();

    $type = new ReservationType($db);

    $data = json_decode(file_get_contents("php://input"));

    $type->id = $data->id;

    $type->name = $data->name;
    $type->price = $data->price;
    $type->numberAvailable = $data->numberAvailable;
    $type->eventId = $data->eventId;
    
    if($type->update()){

        http_response_code(200);
        echo json_encode(array("message" => "reservation type was updated"));
    }
    else{

        http_response_code(503);
        echo json_encode(array("message" => "Unable to update reservation type"));
    }
?>