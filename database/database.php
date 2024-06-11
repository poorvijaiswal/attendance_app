<?php
class Database{
  private $servername = "localhost";
  private $username = "root";
  private $password = "";
  private $dbname= "attendance_db";

  public $conn=null;

  public function __construct(){
    try {
      //as it is member funcn of call, so we need to use "$this" object
      $this->conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);       // Yeh line ek naya PDO object create karti hai jo MySQL server se connect hota hai. Isme connection string use hota hai mysql:host=$servername;dbname=$dbname jo server aur database ko specify karta hai.

      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   //Yeh line PDO object ka error mode set karti hai to ERRMODE_EXCEPTION, jo errors ko exceptions ke roop mein throw karega. Yeh useful hota hai error handling aur debugging ke liye.  

      //echo "Connected successfully";
      
    } catch(PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
    }
  }

?>