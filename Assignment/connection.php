<?php

// variable 
$servername = 'localhost';
$username = 'root';
$password = '';

// creating connection here
$conn = mysqli_connect($servername,$username,$password);

// check if connection is sucess or not if sucess then select db;
if($conn){
    $sql = "CREATE DATABASE  IF NOT EXISTS Animal";   
    $result = mysqli_query($conn, $sql);
    if($result){
        $databasename = mysqli_select_db($conn,'Animal');  
    }
}

// create table if not exists

$sql1 = "CREATE TABLE IF NOT EXISTS animalcollection (
    id int(255) PRIMARY KEY AUTO_INCREMENT,
    name varchar(255),
    category varchar(255),
    animalimg blob,
    decription varchar(255),
    life_expenctancy varchar(255),
    uploded date
    )";
$result1 = mysqli_query($conn, $sql1);

$sql2 = "
DROP TABLE IF EXISTS `counter`;
CREATE TABLE `counter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `counter` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";
$result2 = mysqli_query($conn, $sql2);

$counterObj = new counter($conn);
$counter = $counterObj->getCounter();

class counter{

    private $db;
    public $count;

    public function __construct($conn) {
        $this->db = $conn;
    }

    public function getCounter(){

        $this->count = 0;

        $sql = "SELECT id, counter FROM counter";
        $result = mysqli_query($this->db, $sql);
        
        if($result->num_rows > 0){ #row_exist 

            while($row = mysqli_fetch_assoc($result)){
                $this->count = $row['counter'] + 1;
                break;
            }

            $sql = "UPDATE `counter` SET `counter` = '$this->count'";
            $result = mysqli_query($this->db, $sql);
            
        }else{ #no_row
            $sql = "INSERT INTO `counter` (`counter`) VALUES ('1')";
            $result = mysqli_query($this->db, $sql);
            $this->count = 1;
        }

        return $this->count;        
    }

}

?>