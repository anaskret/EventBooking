<?php
class TicketType{
    private $conn;
    private $table_name = "tickettype";

    public $id;
    public $name;
    public $price;
    public $numberAvailable;
    public $eventId;

    public function __construct($db){
        $this->conn = $db;
    }

    function read(){

        $query = "SELECT id, name, price, numberAvailable, eventId FROM tickettype";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    function readOne(){

        $query = "SELECT id, name, price, numberAvailable, eventId FROM tickettype WHERE id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->name = $row['name'];
        $this->price = $row['price'];
        $this->numberAvailable = $row['numberAvailable'];
        $this->eventId = $row['eventId'];
    }

    function create(){

        $query = "INSERT INTO " . $this->table_name . 
        " SET name=:name, price=:price, numberAvailable=:numberAvailable, eventId=:eventId";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":numberAvailable", $this->numberAvailable);
        $stmt->bindParam(":eventId", $this->eventId);

        if($stmt->execute()){
            return true;
        }

        return false;
    }

    function update(){

        $query = "UPDATE " . $this->table_name . 
        " SET id=:id, name=:name, price=:price, numberAvailable=:numberAvailable, eventId=:eventId WHERE id =:id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":price", $this->price);
        $stmt->bindParam(":numberAvailable", $this->numberAvailable);
        $stmt->bindParam(":eventId", $this->eventId);

        if($stmt->execute()){
            return true;
        }

        return false;
    }

    function delete(){

        $query = "DELETE FROM " .$this->table_name . " WHERE id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);

        if($stmt->execute()){
            return true;
        }
        
        return false;
    }

    function maxAvailable(){

        $query = "SElECT numberOfTickets FROM event WHERE id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->eventId);
        $stmt->execute();
        
        return $stmt;
    }
}
?>