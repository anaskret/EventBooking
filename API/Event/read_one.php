<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Credentials: true");
    header('Content-Type: application/json');

    include_once '../config/database.php';
    include_once '../objects/event.php';

    $database = new Database();
    $db = $database->getConnection();

    $event = new Event($db);

    $event->id = isset($_GET['id']) ? $_GET['id'] : die();

    $event->readOne();

    if($event->name!=null){
        
        $event_item = array(
            "id" => $event->id,
            'name' => $event->name,
            "description" => $event->description,
            "location" => $event->location,
            "numberOfTickets" => $event->numberOfTickets,
            "date" => $event->date,
        );

        http_response_code(200);
        echo json_encode($event_item);
    }
    else{
        http_response_code(404);
        echo json_encode(array("message" => "Event doesn't exist."));
    }
?>