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
    $image_name = null;
    
    // Handle image upload
    if(isset($_FILES['post_image']) && $_FILES['post_image']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 5 * 1024 * 1024; // 5MB
        
        if(in_array($_FILES['post_image']['type'], $allowed_types) && $_FILES['post_image']['size'] <= $max_size) {
            $upload_dir = 'uploads/posts/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            $extension = pathinfo($_FILES['post_image']['name'], PATHINFO_EXTENSION);
            $image_name = uniqid() . '.' . $extension;
            $target_file = $upload_dir . $image_name;
            
            if(move_uploaded_file($_FILES['post_image']['tmp_name'], $target_file)) {
                // Image uploaded successfully
            } else {
                $image_name = null;
            }
        }
    }

    $sql = "INSERT INTO posts (user_id, content, image, created_at) VALUES ($user_id, '$content', " . 
           ($image_name ? "'$image_name'" : "NULL") . ", NOW())";
    
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