<?php
// Check if the form for adding a task has been submitted
if (!empty($_POST['Add_Task'])) {
    // Database connection parameters
    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $dbname = 'todolist';
    
    // Establish connection to the database
    $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
    
    // Check if the connection was successful
    if (mysqli_connect_errno()) {
        die("Database connection failed: " . mysqli_connect_error() . "(" . mysqli_connect_errno() . ")");
    }
    
    // Sanitize and escape user inputs to prevent SQL injection
    $task = $connection->real_escape_string($_POST['newTaskInput']);
    $dueDate = $connection->real_escape_string($_POST['dueDateInput']);
    
    // Assuming 'status' is always false initially when adding a task
    $status = 0; // Assuming 0 represents false status
    
    // SQL query to insert the task into the database
    $sql = "INSERT INTO tasks (task, duedate, status) VALUES ('$task', '$dueDate', '$status')";
    
    // Execute the SQL query
    $insert = $connection->query($sql);
    
    // Print response from MySQL
    if ($insert == TRUE) {
        echo "";
    } else {
        die("Error: {$connection->errno} : {$connection->error}");
    }

    // Close the database connection
    $connection->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>To-Do List</title>
  <link rel="stylesheet" type="text/css" href="styles.css" />
</head>
<body>
  <form method="POST" >
    <fieldset>
      <div class="container">
        <div id="todo-title">To-Do List</div>
        <div id="new-task">
          <input type="text" id="newTaskInput" name="newTaskInput" placeholder="Enter task" />
          <input type="date" id="dueDateInput" name="dueDateInput" />
          <input type="submit" name="Add_Task" value="Add Task" id="addButton"/>
        </div>
        <div id="tasks-title">Tasks</div>
        <div id="tasks"></div>
        <p id="instruction">Drag to prioritize your tasks!</p>
        <div id="logout-container">
            <p><a href="logout.php" id="logout-link">Logout</a></p>
        </div>
      </div>
    </fieldset>
  </form>
  <script src="script.js"></script>
</body>
</html>
