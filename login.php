<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            /* display: block; */
            margin-bottom: 5px;
        }
        input {
            padding: 5px;
            margin-bottom: 10px;
            width: 100%;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h2>Login Form</h2>
    <form action="login.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br><br>
        <input type="submit" value="Login">
        <!-- <?php    if (isset($error_message)) { ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php } ?> -->
    </form>
        
    <?php
        session_start();
        $path = $_SERVER['DOCUMENT_ROOT'];
        require_once $path . '/attendance_app/database/database.php';
        $db = new Database();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Check if the user exists in the database
            $stmt = $db->conn->prepare("SELECT * FROM faculty_details WHERE user_name = :username AND password = :password");
            $stmt->execute([':username' => $username, ':password' => $password]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC); 

            if ($user) {
                // User authenticated successfully
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['user_name'];
                header('Location: dashboard.php');
                exit;
            } else {
                // Authentication failed
                $error_message = "Invalid username or password.";
            }
        }

        // Display error message if set
        if (isset($error_message)) {
            echo "<p style='color: red;'>$error_message</p>";
        }
    ?>
</body>
</html>
