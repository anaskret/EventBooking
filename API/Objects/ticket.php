<?php
class Ticket{
  
        // database connection and table name
        private $conn;
        private $table_name = "ticket";
    
        // object properties
        public $id;
        public $firstName;
        public $lastName;
        public $email;
        public $phoneNumber;
        public $ticketTypeId;

    
        // constructor with $db as database connection
        public function __construct($db){
            $this->conn = $db;
        }

        function read(){

            $query = "SELECT `id`, `firstName` , `lastName`, `email`, `phoneNumber`, `ticketTypeId` FROM `ticket`";
    
            $stmt = $this->conn->prepare($query);
    
            $stmt->execute();
    
            return $stmt;
        }
        function readOne(){

            $query = "SELECT `id`, `firstName`, `lastName`, `email`, `phoneNumber`, `ticketTypeId` FROM " . $this->table_name . " WHERE id = ?";
    
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(1, $this->id);
    
            $stmt->execute();
    
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
            $this->firstName = $row['firstName'];
            $this->lastName = $row['lastName'];
            $this->email = $row['email'];
            $this->phoneNumber = $row['phoneNumber'];
            $this->ticketTypeId = $row['ticketTypeId'];
    
        }

        function create(){
            $query = "INSERT INTO " . $this->table_name . " SET firstName=:firstName, lastName=:lastName, email=:email, phoneNumber=:phoneNumber, ticketTypeId=:ticketTypeId";
            $stmt = $this->conn->prepare($query);
            
            $stmt->bindParam(":firstName", $this->firstName);
            $stmt->bindParam(":lastName", $this->lastName);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":phoneNumber", $this->phoneNumber);
            $stmt->bindParam(":ticketTypeId", $this->ticketTypeId);
    
            if($stmt->execute()){
                return true;
            }
    
            return false;
        }
    
        function update(){
            $query = "UPDATE " . $this->table_name . 
                    " SET firstName = :firstName, lastName = :lastName, email = :email, phoneNumber = :phoneNumber, ticketTypeId = :ticketTypeId WHERE id = :id";
    
            $stmt = $this->conn->prepare($query);
    
            $stmt->bindParam(":firstName", $this->firstName);
            $stmt->bindParam(":lastName", $this->lastName);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":phoneNumber", $this->phoneNumber);
            $stmt->bindParam(":ticketTypeId", $this->ticketTypeId);
    
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