<?php
$path=$_SERVER['DOCUMENT_ROOT'];
require_once $path."/attendance_app/database/database.php";

class attendanceDetails{
    public function saveAttendance($dbo,$session,$course,$student,$fac,$ondate,$status)
     {
        $rv=[-1];
        $c="insert into attendance_details
        (session_id,course_id,faculty_id,student_id,on_date,status)
        values
        (:session_id,:course_id,:faculty_id,:student_id,:on_date,:status)";
        $s=$dbo->conn->prepare($c);
        try{
              $s->execute([":session_id"=>$session,":course_id"=>$course,":faculty_id"=>$fac,":student_id"=>$student,":on_date"=>$ondate,":status"=>$status]);
              $s->execute();
              $rv=[1];
        }
        catch(Exception $e)
        {
             //$rv=[$e->getMessage()];
             //it might happen that the entry is there, we just have to set reset the status
             $c="update attendance_details set status=:status
                where 
                session_id=:session_id and course_id=:course_id and faculty_id=:faculty_id
                and student_id=:student_id and on_date=:on_date";
                $s=$dbo->conn->prepare($c);
                try{
                    $s->execute([":session_id"=>$session,":course_id"=>$course,":faculty_id"=>$fac,":student_id"=>$student,":on_date"=>$ondate,":status"=>$status]);
                    $s->execute();
                    $rv=[1];
                }
                catch(Exception $ee)
                {
                    $rv=[$e->getMessage()];
                }

        }
        return $rv;
     }

     public function getPresentListOfAClassByAFacOnADate($dbo,$session,$course,$fac,$ondate)
     {
        $rv=[];
        $c="select student_id from attendance_details 
        where session_id=:session_id and course_id=:course_id
        and faculty_id=:faculty_id and on_date=:on_date
        and status='YES'";
        $s=$dbo->conn->prepare($c);
        try
        {
            $s->execute([":session_id"=>$session,":course_id"=>$course,":faculty_id"=>$fac,":on_date"=>$ondate]);
            $rv=$s->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(Exception $e)
        {
            $rv=[$e->getMessage()];
        }
        return $rv;
     }
}
?>