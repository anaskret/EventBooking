<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    include_once '../config/database.php';
    include_once '../objects/ticket.php';

    $database = new Database();
    $db = $database->getConnection();

    $ticket= new Ticket($db);

    $stmt = $ticket->read();
    $num = $stmt->rowCount();

    if($num>0){

        $tickets_arr = array();
        $tickets_arr["records"] = array();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

            extract($row);

            $ticket_item = array(
                "id" => $id,
                "name" => $name,
                "description" =>$description, 
                "location" =>$location,
                "numberOfTickets" =>$numberOfTickets,
                "date" =>$date 
            );

            array_push($tickets_arr["records"], $ticket_item);
        }

        http_response_code(200);

        echo json_encode($tickets_arr);
    }
    else{
        http_response_code(404);

        echo json_encode(
            array("message" => "No tickets found.")
        );
    }
?>