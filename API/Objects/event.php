<?php
class Event{
    private $conn;
    private $table_name = "event";

    public $id;
    public $name;
    public $description;
    public $location;
    public $numberOfReservations;
    public $date;

    public function __construct($db){
        $this->conn = $db;
    }
    function read(){

        $query = "SELECT `id`, `name` , `description`, `location`, `numberOfReservations`, `date` FROM `event`";

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    function readOne(){

        $query = "SELECT `id`, `name` , `description`, `location`, `numberOfReservations`, `date` FROM " . $this->table_name . " WHERE id = ?";

        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(1, $this->id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->name = $row['name'];
        $this->description = $row['description'];
        $this->location = $row['location'];
        $this->numberOfReservations = $row['numberOfReservations'];
        $this->date = $row['date'];

    }
    function create(){
        $query = "INSERT INTO " . $this->table_name . 
        " SET id=:id, name=:name, description=:description, location=:location, numberOfReservations=:numberOfReservations, date=:date";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":location", $this->location);
        $stmt->bindParam(":numberOfReservations", $this->numberOfReservations);
        $stmt->bindParam(":date", $this->date);

        if($stmt->execute()){
            return true;
        }
        
       //echo json_encode(array("message" => $stmt->errorInfo()));
        return false;
    }

    function update(){
        $query = "UPDATE " . $this->table_name . 
                " SET name = :name, description = :description, location = :location, numberOfReservations=:numberOfReservations, date=:date WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":location", $this->location);
        $stmt->bindParam(":numberOfReservations", $this->numberOfReservations);
        $stmt->bindParam(":date", $this->date);

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
