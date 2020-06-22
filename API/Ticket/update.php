<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
    include_once '../config/database.php';
    include_once '../objects/ticket.php';

    $database = new Database();
    $db = $database->getConnection();

    $ticket = new Ticket($db);

    $data = json_decode(file_get_contents("php://input"));

    $ticket->id = $data->id;

    $ticket->name = $data->name; 
    $ticket->description = $data->description; 
    $ticket->location = $data->location; 
    $ticket->numberOfTickets = $data->numberOfTickets; 
    $ticket->date = $data->date; 

    if($ticket->update()){
        http_response_code(200);
        echo json_encode(array("message" => "Ticket was updated"));
    }
    else{
        http_response_code(503);
        echo json_encode(array("message" => "Unable to update the ticket"));
    }
?>