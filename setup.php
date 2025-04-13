<?php
// Include database connection
require_once 'todo.php';

// Create database if it doesn't exist
$sql = "CREATE DATABASE IF NOT EXISTS todolist_db";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully or already exists<br>";
} else {
    echo "Error creating database: " . $conn->error . "<br>";
}

// Select the database
$conn->select_db("todolist_db");

// Create tasks table
$sql = "CREATE TABLE IF NOT EXISTS tasks (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    deadline DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    completed TINYINT(1) DEFAULT 0
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'tasks' created successfully or already exists<br>";
} else {
    echo "Error creating table: " . $conn->error . "<br>";
}

$conn->close();
echo "Database setup completed!";
?>