<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: access");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Allow-Credentials: true");
    header('Content-Type: application/json');

    include_once '../config/database.php';
    include_once '../objects/reservation.php';

    $database = new Database();
    $db = $database->getConnection();

    $reservation = new Reservation($db);

    $reservation->id = isset($_GET['id']) ? $_GET['id'] : die();

    $reservation->readOne();

    if($reservation->name!=null){
        
        $reservation_item = array(
            "id" => $reservation->id,
            'firstName' => $reservation->firstNname,
            "lastName" => $reservation->lastName,
            "email" => $reservation->email,
            "phonenumber" => $reservation->numberOfReservations,
            "reservationTypeId" => $reservation->reservationTypeId,
        );

        http_response_code(200);
        echo json_encode($reservation_item);
    }
    else{
        http_response_code(404);
        echo json_encode(array("message" => "reservation doesn't exist."));
    }
?>