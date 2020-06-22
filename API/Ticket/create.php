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

    if(
        !empty($data->firstName) &&
        !empty($data->lastName) &&
        !empty($data->email) &&
        !empty($data->phoneNumber) &&
        !empty($data->ticketTypeId)
    ){
        $ticket->firstName = $data->firstName;
        $ticket->lastName = $data->lastName;
        $ticket->email = $data->email;
        $ticket->phoneNumber = $data->phoneNumber;
        $ticket->ticketTypeId = $data->ticketTypeId;

        if($ticket->create()){

            http_response_code(201);

            echo json_encode(array("message" => "You bought a ticket."));
        }
        else{
            http_response_code(503);
            echo json_encode(array("message" => "Unable to acquire ticket."));
        }
    }
    else{
        http_response_code(400);
        echo json_encode(array("message" => "Unable to buy ticket."));
    }
?>