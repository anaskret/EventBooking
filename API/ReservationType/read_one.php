<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Credentials: true");
    header('Content-Type: application/json');

    include_once '../config/database.php';
    include_once '../objects/reservationtype.php';

    $database = new Database();
    $db = $database->getConnection();

    $type = new ReservationType($db);

    $type->id = isset($_GET['id']) ? $_GET['id'] : die();

    $type->readOne();

    if($type->name!=null){

        $type_item = array(
            "id" => $type->id,
            "name" => $type->name,
            "price" => $type->price,
            "numberAvailable" => $type->numberAvailable,
            "eventId" => $type->eventId,
        );

        http_response_code(200);
        echo json_encode($type_item);
    }
    else{

        http_response_code(404);
        echo json_encode(array("message" => "reservation type with given ID doesn't exist"));
    }
?>