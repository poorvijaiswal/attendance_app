<?php
$path=$_SERVER['DOCUMENT_ROOT'];
require_once($path.'/attendance_app/database/database.php');

class FacultyDetails{
    public function getCoursesInSession($db,$facid,$sessionid){
        $rv=[];
        $c="select cd.id,cd.code,cd.title from course_allotment as ca, course_details as cd where ca.course_id=cd.id and faculty_id=:facid and session_id=:sessionid";
        $s=$db->conn->prepare($c);
        // $s->bindParam(':facid',$facid);
        // $s->bindParam(':sessionid',$sessionid);
        try{
            $s->execute(["facid"=>$facid,"sessionid"=>$sessionid]); 
            $rv=$s->fetchAll(PDO::FETCH_ASSOC); //rv mein query se fetch kiya gaya data store hota hai.
            return $rv;
        }
        catch(PDOException $e){
            echo "Error: ".$e->getMessage();
        }
        return $rv;
    }
}
?>