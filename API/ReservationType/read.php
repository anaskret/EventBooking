<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    include_once '../config/database.php';
    include_once '../objects/reservationtype.php';

    $database = new Database();
    $db = $database->getConnection();

    $type = new ReservationType($db);

    $stmt = $type->read();
    $num = $stmt->rowCount();

    if($num>0){

        $types_arr = array();
        $types_arr["records"] = array();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){

            extract($row);

            $type_item = array(
                "id" => $id,
                "name" => $name,
                "price" => $price,
                "numberAvailable" => $numberAvailable,
                "eventId" => $eventId
            );

            array_push($types_arr["records"], $type_item);
        }

        http_response_code(200);

        echo json_encode($types_arr);
    }
    else{
        http_response_code(404);

        echo json_encode(array("message" => "No reservation types found"));
    }

?>