<?php
// Start session to manage user authentication
session_start();

// Check if user is already logged in, redirect to todo.php if yes
if (isset($_SESSION["user"])) {
   header("Location: todo.php");
   // Ensure that no output is sent before header() function
   exit(); // Stop script execution
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <?php
        // Check if login form is submitted
        if (isset($_POST["login"])) {
            // Get email and password from form
            $email = $_POST["email"];
            $password = $_POST["password"];
            
            // Include database connection file
            require_once "database.php";
            
            // Fetch user with given email from database
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
            
            // If user exists
            if ($user) {
                // Verify password
                if (password_verify($password, $user["password"])) {
                    // Start session and set user flag
                    $_SESSION["user"] = "yes";
                    // Redirect user to todo.php
                    header("Location: todo.php");
                    // Stop script execution
                    exit();
                } else {
                    // Password does not match
                    echo "<div class='alert alert-danger'>Password does not match</div>";
                }
            } else {
                // User with given email not found
                echo "<div class='alert alert-danger'>Email does not match</div>";
            }
        }
        ?>
      <!-- Login Form -->
      <form action="login.php" method="post">
        <div class="form-group">
            <input type="email" placeholder="Enter Email:" name="email" class="form-control">
        </div>
        <div class="form-group">
            <input type="password" placeholder="Enter Password:" name="password" class="form-control">
        </div>
        <div class="form-btn">
            <input type="submit" value="Login" name="login" class="btn btn-primary">
        </div>
      </form>
     <!-- Registration Link -->
     <div><p>Not registered yet <a href="registration.php">Register Here</a></p></div>
    </div>
</body>
</html>
