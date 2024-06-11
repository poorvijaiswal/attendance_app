<?php

$path = $_SERVER['DOCUMENT_ROOT'];  //This is a superglobal variable that returns the document root directory under which the current script is executing, as defined in the server's configuration file.
require_once $path.'/attendance_app/database/database.php'; //This line includes the database.php file in the current file. This is done to use the Database class in this file.

$db = new Database();

function clearTable($db, $table_name){
    $c = "delete from $table_name;";
    $s=$db->conn->prepare($c);
    try{
        $s->execute();
    }catch(PDOException $e){
        echo("<br>Error deleting from :table_name: ".$e->getMessage());
    }
}

//table 1
$c="create table student_details(
    id int auto_increment primary key,
    roll_no varchar(20) unique,
    name varchar(50));";
try{
    $db->conn->exec($c) ;
    echo "Table created successfully";
}catch(PDOException $e){
    echo "<br>Error in creating table: ".$e->getMessage();
}

//table 2
$c="create table course_details(
    id int auto_increment primary key,
    code varchar(20) unique,
    title varchar(50),
    credits int(2));";
try{
    $db->conn->exec($c);
    echo "<br>Table created successfully";
}
catch(PDOException $e){
    echo "<br>Error in creating table: ".$e->getMessage();
}

//table 3
$c="create table faculty_details(
    id int auto_increment primary key,
    user_name varchar(20) unique,
    name varchar(80),
    password varchar(20));";
try{
    $db->conn->exec($c);
    echo "<br>Table created successfully";
}
catch(PDOException $e){
    echo "<br>Error in creating table: ".$e->getMessage();
}

//table 4
$c="create table session_details(
    id int auto_increment primary key,
    year int,
    term varchar(50),
    unique(year,term));";    //unique key is used to make sure that the combination of year and term is unique
try{
    $db->conn->exec($c);
    echo "<br>Table created successfully";
}
catch(PDOException $e){
    echo "<br>Error in creating table: ".$e->getMessage();
}

//table 5
$c="create table course_registration(
    student_id int,
    course_id int,
    session_id int,
    primary key(student_id,course_id,session_id));";
try{
    $db->conn->exec($c); //db is an object of Database class and conn is a member variable of Database class
    echo "<br>Table created successfully";
}
catch(PDOException $e){
    echo "<br>Error in creating table: ".$e->getMessage();
}

//table 6
$c = "create table course_allotment(
    faculty_id int,
    course_id int,
    session_id int,
    primary key(faculty_id,course_id,session_id));";
try{
    $db->conn->exec($c);
    echo "<br>Table created successfully";
}
catch(PDOException $e){
    echo "<br>Error in creating table: ".$e->getMessage();
}

//table 7
$c = "create table attendance_details(
    session_id int,
    student_id int,
    faculty_id int,
    course_id int,
    on_date date,
    status varchar(10),
    primary key(faculty_id,course_id,session_id,student_id,on_date));";
try{
    $db->conn->exec($c);
    echo "<br>Table created successfully";
}
catch(PDOException $e){
    echo "<br>Error in creating table: ".$e->getMessage();
}

//-----------------INSERTING RECORDS IN student_details TABLE----------------
$c= "insert into student_details (roll_no, name) VALUES
('0827CI221100', 'Alice'),
('0827CI221101', 'Bob'),
('0827CI221102', 'Charlie'),
('0827CI221103', 'David'),
('0827CI221104', 'Eve'),
('0827CI221105', 'Fay'),
('0827CI221106', 'Grace'),
('0827CI221107', 'Hank'),
('0827CI221108', 'Ivy'),
('0827CI221109', 'Jack'),
('0827CI221110', 'Karl'),
('0827CI221111', 'Liam'),
('0827CI221112', 'Mia'),
('0827CI221113', 'Nina'),
('0827CI221114', 'Oscar'),
('0827CI221115', 'Paul'),
('0827CI221116', 'Quinn'),
('0827CI221117', 'Rose'),
('0827CI221118', 'Sam'),
('0827CI221119', 'Tina');";
$s=$db->conn->prepare($c);
try{
    $s->execute();
}catch(PDOException $e){
    echo("<br>Error inserting into student_details: ".$e->getMessage());
}

//-----------------INSERTING RECORDS IN faculty_details TABLE----------------
$c= "insert into faculty_details (user_name, name, password) VALUES 
('MG', 'Prof. Manoj Gupta', '123'),
('NR', 'Prof. Nisha Rathi', '123'),
('AK', 'Dr. Alice Kumar', '123'),
('VB', 'Prof. Veronica Brown', '123'),
('RS', 'Dr. Rakesh Singh', '123'),
('TP', 'Prof. Tina Patel', '123'),
('KC', 'Dr. Kevin Chang', '123'),
('LP', 'Prof. Lisa Parker', '123');";
$s=$db->conn->prepare($c); //prepare() method is used to prepare the query for execution
try{
    $s->execute(); //execute() method is used to execute the query
}catch(PDOException $e){
    echo("<br>Error inserting into faculty_details: ".$e->getMessage());
}

// -----------------INSERTING RECORDS IN session_details TABLE----------------
$c= "insert into session_details (year, term) VALUES 
(2022, '1'),
(2023, '2'),
(2023, '3'),
(2024, '4'),
(2024, '5'),
(2025, '6'),
(2025, '7'),
(2026, '8');";
$s=$db->conn->prepare($c);
try{
    $s->execute();       
}catch(PDOException $e){   //catch block is executed when an exception is thrown
    echo("<br>Error inserting into session_details: ".$e->getMessage());
}

// -----------------INSERTING RECORDS IN course_details TABLE----------------

$c = "insert ignore into course_details (code, title, credits) VALUES
('CSIT201', 'Data Structures and Algorithms', 4),
('CSIT202', 'Database Management Systems', 4),
('CSIT203', 'Computer Networks', 3),
('CSIT204', 'Operating Systems', 4),
('CSIT205', 'Discrete Mathematics', 3),
('CSIT301', 'Object-Oriented Programming', 4),
('CSIT302', 'Software Engineering', 3),
('CSIT303', 'Web Technologies', 3),
('CSIT401', 'Artificial Intelligence', 3),
('CSIT402', 'Machine Learning', 4),
('CSIT403', 'Cloud Computing', 3),
('CSIT404', 'Big Data Analytics', 3),
('CSIT405', 'Cyber Security', 3),
('CSIT406', 'Deep Learning', 2),
('CSIT407', 'Blockchain', 3),
('CSIT408', 'Operating System', 4);";
$s = $db->conn->prepare($c);
try{
    $s->execute();
}catch(PDOException $e){   //catch block is executed when an exception is thrown
    echo("<br>Error inserting into course_details: ".$e->getMessage());
}

//---------------------INSERTING RECORDS IN course_registration TABLE----------------

clearTable($db, "course_registration");

// Fetch all students
$students = $db->conn->query("SELECT id FROM student_details")->fetchAll(PDO::FETCH_ASSOC);

// Fetch all sessions
$sessions = $db->conn->query("SELECT id FROM session_details")->fetchAll(PDO::FETCH_ASSOC);

// Fetch all courses
$courses = $db->conn->query("SELECT id FROM course_details")->fetchAll(PDO::FETCH_ASSOC);

// Ensure courses are in correct order and in chunks of 2 for each term
$term_courses = array_chunk($courses, 2);

// Check if the number of terms matches the number of sessions
if (count($sessions) != count($term_courses)) {
    die("<br>Number of sessions does not match number of terms.");
}

// Insert course registration details
foreach ($students as $student) {
    foreach ($sessions as $session) {
        $term_index = $session['id'] - 1; // Adjust index if session IDs start from 1
        if (!isset($term_courses[$term_index])) {
            echo "<br>Warning: No courses found for term with index $term_index.";
            continue;
        }
        foreach ($term_courses[$term_index] as $course) {
            $c = "INSERT INTO course_registration (student_id, course_id, session_id) 
                  VALUES (:student_id, :course_id, :session_id)";
            $stmt = $db->conn->prepare($c);
            try {
                $stmt->execute([
                    ':student_id' => $student['id'],
                    ':course_id' => $course['id'],
                    ':session_id' => $session['id']
                ]);
            } catch (PDOException $e) {
                echo "<br>Error inserting into course_registration: " . $e->getMessage();
            }
        }
    }
}

echo "<br>Course registration details inserted successfully.";

// -----------------INSERTING RECORDS IN course_allotment TABLE----------------

// Fetch the list of faculties.
// Fetch the list of subjects.
// Distribute the subjects evenly among the faculties.
// Insert the allotted subjects into the course_allotment table.
clearTable($db, "course_allotment");

// Fetch all faculties
$faculties = $db->conn->query("SELECT id FROM faculty_details")->fetchAll(PDO::FETCH_ASSOC);

// Fetch all subjects
$subjects = $db->conn->query("SELECT id FROM course_details")->fetchAll(PDO::FETCH_ASSOC);

// Shuffle subjects to randomize the allotment
shuffle($subjects);

// Allocate subjects to faculties
$allotments = [];
$faculty_count = count($faculties);
$subject_count = count($subjects);

if ($subject_count < $faculty_count * 2) {
    die("Not enough subjects to allot a minimum of 2 subjects to each faculty.");
}

// Distribute subjects among faculties
foreach ($faculties as $index => $faculty) {
    $allotments[$faculty['id']] = array_slice($subjects, $index * 2, 2);
}

// Insert remaining subjects (if any) to faculties
$remaining_subjects = array_slice($subjects, $faculty_count * 2);

for ($i = 0; $i < count($remaining_subjects); $i++) {
    $faculty_id = $faculties[$i % $faculty_count]['id'];
    $allotments[$faculty_id][] = $remaining_subjects[$i];
}

// Fetch all sessions
$sessions = $db->conn->query("SELECT id FROM session_details")->fetchAll(PDO::FETCH_ASSOC);

// Insert allotments into course_allotment table
foreach ($allotments as $faculty_id => $courses) {
    foreach ($sessions as $session) {
        foreach ($courses as $course) {
            $c = "INSERT INTO course_allotment (faculty_id, course_id, session_id) 
                  VALUES (:faculty_id, :course_id, :session_id)";
            $stmt = $db->conn->prepare($c);
            try {
                $stmt->execute([
                    ':faculty_id' => $faculty_id,
                    ':course_id' => $course['id'],
                    ':session_id' => $session['id']
                ]);
            } catch (PDOException $e) {
                echo "<br>Error inserting into course_allotment: " . $e->getMessage();
            }
        }
    }
}

echo "<br><br>Course allotment details inserted successfully.";

?>
