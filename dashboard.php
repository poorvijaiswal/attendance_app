<?php
session_start();    // Start the session to access session variables like $_SESSION['user_id'] and $_SESSION['username'] 

if (!isset($_SESSION['user_id'])) { // Check if the user is not authenticated (i.e. user_id is not set in the session)
    header('Location: login.php'); // Redirect to login page if not authenticated
    exit;
}
else{
    $facid=$_SESSION['user_id'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <!-- <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2> 
    htmlspecialchars is used to prevent XSS attacks by escaping special characters like <, >, &, etc.  -->
    <div class="page">
        <div class="header-area">
            <div class="logo-area"> <h2 class="logo">ATTENDANCE APP</h2></div>
            <div class="logout-area"><button class="btnlogout" id="btnLogout"><a href="logout.php">LOGOUT</a></button></div>
        </div>
        <div class="session-area">
              <div class="label-area"><label>Semester for Batch 2022-26</label></div>
              <div class="dropdown-area">
                <select class="ddlclass" id="ddlclass">
                   <!-- <option>SELECT ONE</option>
                    <option>2023 AUTUMN</option>
                    <option>2023 SPRING</option> -->
                </select>
              </div>
        </div>
        <div class="classlist-area" id="classlistarea">
          <!-- <div class="classcard">CS101</div>
          <div class="classcard">CS101</div>
          <div class="classcard">CS101</div>
          <div class="classcard">CS101</div>
          <div class="classcard">CS101</div>
          <div class="classcard">CS101</div>
          <div class="classcard">CS101</div> -->
        </div>
        <div class="classdetails-area" id="classdetailsarea">
            <!-- <div class="classdetails">
                <div class="code-area">CS101</div>
                <div class="title-area">INTRODUCTION TO SCIENTIFIC COMPUTING</div>
                <div class="ondate-area">
                    <input type="date">
                </div>
            </div> -->
        </div>
        <div class="studentlist-area" id="studentlistarea">
            <!-- <div class="studenttlist"><label>STUDENT LIST</label></div> -->
            <!-- <div class="studentdetails">
                <div class="slno-area">001</div>
                <div class="rollno-area">CSB21001</div>
                <div class="name-area">Shivay Singh Oberoi</div>
                <div class="checkbox-area">
                    <input type="checkbox">
                </div>
            </div>

            <div class="studentdetails">
                <div class="slno-area">001</div>
                <div class="rollno-area">CSB21001</div>
                <div class="name-area">Shivay Singh Oberoi</div>
                <div class="checkbox-area">
                    <input type="checkbox">
                </div>
            </div>

            <div class="studentdetails">
                <div class="slno-area">001</div>
                <div class="rollno-area">CSB21001</div>
                <div class="name-area">Shivay Singh Oberoi</div>
                <div class="checkbox-area">
                    <input type="checkbox">
                </div>
            </div>

            <div class="studentdetails">
                <div class="slno-area">001</div>
                <div class="rollno-area">CSB21001</div>
                <div class="name-area">Shivay Singh Oberoi</div>
                <div class="checkbox-area">
                    <input type="checkbox">
                </div>
            </div>

            <div class="studentdetails">
                <div class="slno-area">001</div>
                <div class="rollno-area">CSB21001</div>
                <div class="name-area">Shivay Singh Oberoi</div>
                <div class="checkbox-area">
                    <input type="checkbox">
                </div>
            </div> -->
          
           
        </div>
    </div>
    <input type="hidden" id="hdnfacid" value="<?php echo $facid; ?>">
    <input type="hidden" id="hiddenSelectedCourseId" value=-1>
    
     <script src="js/attendance.js"></script>       

    <!-- <p>This is the dashboard page.</p>
    <a href="logout.php">Logout</a> -->
</body>
</html>
