<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    include_once '../config/database.php';
    include_once '../objects/reservation.php';

    $database = new Database();
    $db = $database->getConnection();

    $reservation= new Reservation($db);

    $stmt = $reservation->read();
    $num = $stmt->rowCount();

    if($num>0){

        $reservations_arr = array();
        $reservations_arr["records"] = array();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

            extract($row);

            $reservation_item = array(
                "id" => $id,
                "firstName" => $firstName,
                "lastName" =>$lastName, 
                "email" =>$email,
                "phoneNumber" =>$phoneNumber,
                "numberOfReservations" =>$numberOfReservations,
                "reservationTypeId" =>$reservationTypeId 
            );

            array_push($reservations_arr["records"], $reservation_item);
        }

        http_response_code(200);

        echo json_encode($reservations_arr);
    }
    else{
        http_response_code(404);

        echo json_encode(
            array("message" => "No reservations found.")
        );
    }
?>