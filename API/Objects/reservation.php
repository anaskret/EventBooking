<?php
class Reservation{
  
        // database connection and table name
        private $conn;
        private $table_name = "reservation";
    
        // object properties
        public $id;
        public $firstName;
        public $lastName;
        public $email;
        public $phoneNumber;
        public $umberOfReservations;
        public $reservationTypeId;

    
        // constructor with $db as database connection
        public function __construct($db){
            $this->conn = $db;
        }

        function read(){

            $query = "SELECT `id`, `firstName` , `lastName`, `email`, `phoneNumber`, numberOfReservations,`reservationTypeId` FROM `reservation`";
    
            $stmt = $this->conn->prepare($query);
    
            $stmt->execute();
    
            return $stmt;
        }
        function readOne(){

            $query = "SELECT `id`, `firstName`, `lastName`, `email`, `phoneNumber`, numberOfReservations, `reservationTypeId` FROM " . $this->table_name . " WHERE id = ?";
    
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(1, $this->id);
    
            $stmt->execute();
    
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            $this->firstName = $row['firstName'];
            $this->lastName = $row['lastName'];
            $this->email = $row['email'];
            $this->phoneNumber = $row['phoneNumber'];
            $this->numberOfReservations = $row['numberOfReservations'];
            $this->reservationTypeId = $row['reservationTypeId'];
    
        }

        function create(){
            $query = "INSERT INTO " . $this->table_name . " SET id=:id, firstName=:firstName, lastName=:lastName, email=:email, phoneNumber=:phoneNumber, numberOfReservations=:numberOfReservations, reservationTypeId=:reservationTypeId";
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(":id", $this->id);
            $stmt->bindParam(":firstName", $this->firstName);
            $stmt->bindParam(":lastName", $this->lastName);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":phoneNumber", $this->phoneNumber);
            $stmt->bindParam(":numberOfReservations", $this->numberOfReservations);
            $stmt->bindParam(":reservationTypeId", $this->reservationTypeId);
    
            if($stmt->execute()){
                return true;
            }
    
            return false;
        }
    
        function update(){
            $query = "UPDATE " . $this->table_name . 
                    " SET firstName = :firstName, lastName = :lastName, email = :email, phoneNumber = :phoneNumber, numberOfReservations=:numberOfReservations, reservationTypeId = :reservationTypeId WHERE id = :id";
    
            $stmt = $this->conn->prepare($query);
    
            $stmt->bindParam(":id", $this->id);
            $stmt->bindParam(":firstName", $this->firstName);
            $stmt->bindParam(":lastName", $this->lastName);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":phoneNumber", $this->phoneNumber);
            $stmt->bindParam(":numberOfReservations", $this->numberOfReservations);
            $stmt->bindParam(":reservationTypeId", $this->reservationTypeId);
    
            if($stmt->execute()){
                return true;
            }
            
            return false;
        }
    
        function delete(){
            $query = "DELETE FROM " . $this->table_name . " Where id = ?";
    
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(1, $this->id);
    
            if($stmt->execute()){
                return true;
            }
    
            return false;
        }














    }

?>