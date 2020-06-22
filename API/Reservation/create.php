<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    include_once '../config/database.php';
    include_once '../objects/reservation.php';

    $database = new Database();
    $db = $database->getConnection();

    $reservation = new Reservation($db);

    $data = json_decode(file_get_contents("php://input"));

    if(
        !empty($data->id) &&
        !empty($data->firstName) &&
        !empty($data->lastName) &&
        !empty($data->email) &&
        !empty($data->phoneNumber) &&
        !empty($data->numberOfReservations) &&
        !empty($data->reservationTypeId)
    ){
        $reservation->id= $data->id;
        $reservation->firstName = $data->firstName;
        $reservation->lastName = $data->lastName;
        $reservation->email = $data->email;
        $reservation->phoneNumber = $data->phoneNumber;
        $reservation->numberOfReservations = $data->numberOfReservations;
        $reservation->reservationTypeId = $data->reservationTypeId;

        if($reservation->create()){

            http_response_code(201);

            echo json_encode(array("message" => "You booked a reservation."));
        }
        else{
            http_response_code(503);
            echo json_encode(array("message" => "Unable to acquire reservation."));
        }
    }
    else{
        http_response_code(400);
        echo json_encode(array("message" => "Unable to buy reservation."));
    }
?>