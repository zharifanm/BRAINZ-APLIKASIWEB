<?php
// Database configuration
$host = "localhost";
$username = "root";
$password = "";
$database = "todolist_db";

// Create or connect to database
$conn = new mysqli($host, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS $database";
if (!$conn->query($sql)) {
    die("Error creating database: " . $conn->error);
}

// Select the database
$conn->select_db($database);

// Create tasks table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS tasks (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    deadline DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    completed TINYINT(1) DEFAULT 0
)";

if (!$conn->query($sql)) {
    die("Error creating table: " . $conn->error);
}

// Process form submission
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if we're toggling completion status
    if (isset($_POST['toggle_complete']) && isset($_POST['task_id'])) {
        $task_id = (int)$_POST['task_id'];
        $completed = isset($_POST['completed']) ? 1 : 0;
        
        $sql = "UPDATE tasks SET completed = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $completed, $task_id);
        
        if ($stmt->execute()) {
            $message = "Task status updated successfully!";
        } else {
            $message = "Error updating task: " . $conn->error;
        }
        $stmt->close();
    }
    // Check if we're deleting a task
    else if (isset($_POST['delete_task']) && isset($_POST['task_id'])) {
        $task_id = (int)$_POST['task_id'];
        
        $sql = "DELETE FROM tasks WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $task_id);
        
        if ($stmt->execute()) {
            $message = "Task deleted successfully!";
        } else {
            $message = "Error deleting task: " . $conn->error;
        }
        $stmt->close();
    }
    // Otherwise, we're adding a new task
    else if (isset($_POST['title']) && isset($_POST['description']) && isset($_POST['deadline'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $deadline = $_POST['deadline'];
        
        // Validate inputs
        if (empty($title) || empty($deadline)) {
            $message = "Title and deadline are required!";
        } else {
            // Insert new task
            $sql = "INSERT INTO tasks (title, description, deadline) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $title, $description, $deadline);
            
            if ($stmt->execute()) {
                $message = "Task added successfully!";
            } else {
                $message = "Error adding task: " . $conn->error;
            }
            $stmt->close();
        }
    }
}

// Get all tasks
$sql = "SELECT * FROM tasks ORDER BY deadline ASC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List Application</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1>My Assignments</h1>
            
            <?php if(!empty($message)): ?>
                <div class="message">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>
            
            <a href="todo.html" class="add-new">+ Add New Assignment</a>
            
            <div class="task-list">
                <?php
                if ($result && $result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        $taskClass = $row["completed"] ? "task-item completed" : "task-item";
                        $checkboxStatus = $row["completed"] ? "checked" : "";
                        
                        echo '<div class="' . $taskClass . '">';
                        
                        // Task completion toggle form
                        echo '<form method="POST" action="todo.php" class="task-toggle-form">';
                        echo '<input type="hidden" name="task_id" value="' . $row["id"] . '">';
                        echo '<input type="hidden" name="toggle_complete" value="1">';
                        echo '<input type="checkbox" name="completed" value="1" ' . $checkboxStatus . ' onchange="this.form.submit()" class="task-checkbox">';
                        echo '</form>';
                        
                        echo '<div class="task-content">';
                        echo '<div class="task-title">' . htmlspecialchars($row["title"]) . '</div>';
                        echo '<div class="task-description">' . htmlspecialchars($row["description"]) . '</div>';
                        
                        // Format the date to DD/MM/YYYY
                        $deadline = date("d/m/Y", strtotime($row["deadline"]));
                        echo '<div class="task-deadline">Deadline: ' . $deadline . '</div>';
                        echo '</div>';
                        
                        // Delete task form
                        echo '<form method="POST" action="todo.php" class="task-delete-form">';
                        echo '<input type="hidden" name="task_id" value="' . $row["id"] . '">';
                        echo '<input type="hidden" name="delete_task" value="1">';
                        echo '<button type="submit" class="delete-btn" onclick="return confirm(\'Are you sure you want to delete this task?\')">×</button>';
                        echo '</form>';
                        
                        echo '</div>';
                    }
                } else {
                    echo "<p class='no-tasks'>No assignments found. Add your first assignment!</p>";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>

<?php
// Close connection
$conn->close();
?>