<?php
$path=$_SERVER['DOCUMENT_ROOT'];
require_once($path.'/attendance_app/database/database.php');

class SessionDetails{
    public function getSession($db){
        $c="select * from session_details";
        $s=$db->conn->prepare($c);
        try{
            $s->execute(); //execute function se query run hoti hai
            $rv=$s->fetchAll(PDO::FETCH_ASSOC); //rv mein query se fetch kiya gaya data store hota hai.
            return $rv;
        }
        catch(PDOException $e){
            echo "Error: ".$e->getMessage();
        }
        return $rv;
    }

    public function getCoursesInSession($db,$facid,$sessionid){
        
    }
};
?>