<?php
session_start();
require_once 'includes/config.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Handle post creation
if(isset($_POST['submit'])) {
    $content = mysqli_real_escape_string($con, $_POST['content']);
    $user_id = $_SESSION['user_id'];
    
    $sql = "INSERT INTO posts (user_id, content) VALUES ('$user_id', '$content')";
    
    if(mysqli_query($con, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($con);
    }
}

// If someone tries to access this file directly without posting
header("Location: index.php");
exit();
?> 