<?php
class Connection{
    public $servername = "vpc353_2.encs.concordia.ca";
    protected $username = "vpc353_2";
    protected $password = "A5DNm8";
    public $dbname = "vpc353_2";
    public $conn;
    protected $query;
    protected $lastID;
    protected $result;
    public function __construct()
    {
        // Create connection
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
    }
    public function setQuery($query){
        $this->query=$query;
    }
    public function displaySelectList($attribute, $table, $selected, $name){
        $result = $this->conn->query("SELECT $attribute FROM $table");
        echo "<select class='city' name=$name> 
                      <option selected value='default'>$selected</option>>";
        while ($row = $result->fetch_assoc()) {
            $id = $row[$attribute];
            echo '<option value='.$id.'>'.$id.'</option>';
        }
        echo "</select>";
    }
    public function showPosts($table){
        if(isset($this->query)){
            $result = $this->conn->query($this->query);
        }else{
            $result = $this->conn->query("SELECT * FROM $table");
        }
        while ($row = $result->fetch_assoc()) {
            echo "<br><div class='serviceContent'>";
            echo "Trip ID: ".$row['TID'];
            echo "Title: ".$row['title'];
            echo "<br>Departure Date: ".$row['dDate'];
            echo "<br>Departure Postal Code: ".$row['dPostal'];
            echo "<br>Arrival Postal Code: ".$row['aPostal'];
            echo "<br>Description: ".$row['Description'];
            $city = $row["dCity"];
            if ($row['Restriction']){
                $city2 = $this->conn->query("SELECT * FROM city WHERE cityName='$city'");
                echo "<br>Restricted to drivers from the following regions: ";
                while ($row2 = $city2->fetch_assoc()) {
                    echo $row2['citySurrounded'];
                }
            }
            echo "</div>";
        }
    }

    public function execute(){
        $this->conn->query($this->query);
    }

    public function getLastID(){
        $last_id='';
        if ($this->conn->query($this->query) === TRUE) {
            $last_id = $this->conn->insert_id;
//                echo "New record created successfully. Last inserted ID is: " . $last_id;
        } else {
            echo "Error: " . $this->query . "<br>" . $this->conn->error;
        }
        return $last_id;
    }
    public function getResult(){
        return $this->result;
    }
    public function close(){
        $this->conn->close();
    }
}
?>
