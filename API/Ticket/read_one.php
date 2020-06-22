<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Credentials: true");
    header('Content-Type: application/json');

    include_once '../config/database.php';
    include_once '../objects/ticket.php';

    $database = new Database();
    $db = $database->getConnection();

    $ticket = new Ticket($db);

    $ticket->id = isset($_GET['id']) ? $_GET['id'] : die();

    $ticket->readOne();

    if($ticket->name!=null){
        
        $ticket_item = array(
            "id" => $ticket->id,
            'firstName' => $ticket->firstNname,
            "lastName" => $ticket->lastName,
            "email" => $ticket->email,
            "phonenumber" => $ticket->numberOfTickets,
            "ticketTypeId" => $ticket->ticketTypeId,
        );

        http_response_code(200);
        echo json_encode($ticket_item);
    }
    else{
        http_response_code(404);
        echo json_encode(array("message" => "Ticket doesn't exist."));
    }
?>