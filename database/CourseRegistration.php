<?php
$path = $_SERVER['DOCUMENT_ROOT'];
require_once($path.'/attendance_app/database/database.php');

class CourseRegistrationDetails{
    public function getRegisteredStudents($db,$courseid,$sessionid){
        $rv=[];
        $c = "select sd.id, sd.roll_no, sd.name from student_details as sd, course_registration as crg WHERE crg.student_id=sd.id and crg.session_id=:sessionid and crg.course_id=:courseid";
        $s = $db->conn->prepare($c);     
        try{
            $s->execute([':courseid'=>$courseid, ':sessionid'=>$sessionid]);
            $rv = $s->fetchAll(PDO::FETCH_ASSOC);
        }catch(PDOException $e){
            echo $e->getMessage();
        }
        return $rv;
    }
}
?>