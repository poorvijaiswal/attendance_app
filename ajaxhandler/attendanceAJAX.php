<?php
$path = $_SERVER['DOCUMENT_ROOT'];
require_once($path.'/attendance_app/database/database.php');
//require_once ka matlab hai agar yeh file pehle se include ho chuki hai, to dobara include nahi hogi.
require_once($path.'/attendance_app/database/SessionDetails.php');
require_once($path.'/attendance_app/database/FacultyDetails.php');
require_once($path.'/attendance_app/database/CourseRegistration.php');
require_once($path.'/attendance_app/database/attendanceDetails.php');


if(isset($_REQUEST['action'])){
    $action = $_REQUEST['action'];
    if($action=="getSession"){
        //fetch seesion DB and return to client
        // $rv=["session"=>"2019-2020","semester"=>"1st","course"=>"B.Tech","branch"=>"CSE","section"=>"A"];
        $db= new Database();
        $sobj= new SessionDetails();
        $rv=$sobj->getSession($db);
        echo json_encode($rv); //json_encode function ke through yeh array JSON format mein client ko return kiya jata hai.
    }
    //data: { action: "getFacultyCourses", facid: $facid, sessionid: $sessionid }

    if($action=="getFacultyCourses"){
        $facid = $_POST['facid'];
        $sessionid = $_POST['sessionid'];   //$_POST is a PHP super global variable which is used to collect form data after submitting an HTML form with method="post". $_POST is also widely used to pass variables.
        $db= new Database();
        $fobj= new FacultyDetails();
        $rv=$fobj->getCoursesInSession($db,$facid,$sessionid);  
        echo json_encode($rv); //json_encode function ke through yeh array JSON format mein client ko return kiya jata hai.
    }

    if($action=="getStudentList"){
        $courseid = $_POST['courseid'];
        $sessionid = $_POST['sessionid'];   //$_POST is a PHP super global variable which is used to collect form data after submitting an HTML form with method="post". $_POST is also widely used to pass variables.
        $facid = $_POST['facid'];
        $ondate = $_POST['ondate'];
        $db= new Database();
        $crobj= new CourseRegistrationDetails();
        $allstudents=$crobj->getRegisteredStudents($db,$courseid,$sessionid);
        $ado= new attendanceDetails();
        $presentStudents=$ado->getPresentListOfAClassByAFacOnADate($db,$sessionid,$courseid,$facid,$ondate);
        for($i=0;$i<count($allstudents);$i++){
            $allstudents[$i]['isPresent']="NO";
            for($j=0;$j<count($presentStudents);$j++){
                if($allstudents[$i]['id']==$presentStudents[$j]['student_id']){  
                    $allstudents[$i]['isPresent']="YES";
                    break;
                }
            }
        }
        echo json_encode($allstudents); //json_encode function ke through yeh array JSON format mein client ko return kiya jata hai.
    }
    if($action=="saveattendance"){
        $courseid = $_POST['courseid'];
        $sessionid = $_POST['sessionid'];
        $facultyid = $_POST['facultyid'];
        $studentid = $_POST['studentid'];   
        $ondate = $_POST['ondate'];  
        $status=$_POST['ispresent']; 
        $dbo= new Database();
        $ado= new attendanceDetails();
        $rv=$ado->saveAttendance($dbo,$sessionid,$courseid,$studentid,$facultyid,$ondate,$status);
        echo json_encode($rv); //json_encode function ke through yeh array JSON format mein client ko return kiya jata hai.
    }
    
}

?>