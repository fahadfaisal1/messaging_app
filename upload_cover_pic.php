<?php
session_start();
require_once 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in']);
    exit();
}

// Handle file upload logic
if (isset($_FILES['cover_pic'])) {
    $file = $_FILES['cover_pic'];
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $max_size = 5 * 1024 * 1024; // 5MB

    // Validate file
    if (!in_array($file['type'], $allowed_types)) {
        echo json_encode(['success' => false, 'message' => 'Invalid file type']);
        exit();
    }

    if ($file['size'] > $max_size) {
        echo json_encode(['success' => false, 'message' => 'File too large']);
        exit();
    }

    // Create uploads directory if it doesn't exist
    $upload_dir = 'uploads/cover/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Generate unique filename
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '.' . $extension;
    $filepath = $upload_dir . $filename;

    // Delete old cover picture if exists
    $sql = "SELECT cover_pic FROM users WHERE id = {$_SESSION['user_id']}";
    $result = mysqli_query($con, $sql);
    $user = mysqli_fetch_assoc($result);
    if (!empty($user['cover_pic'])) {
        $old_file = $upload_dir . $user['cover_pic'];
        if (file_exists($old_file)) {
            unlink($old_file);
        }
    }

    // Upload new file
    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        // Update database
        $sql = "UPDATE users SET cover_pic = '$filename' WHERE id = {$_SESSION['user_id']}";
        if (mysqli_query($con, $sql)) {
            echo json_encode([
                'success' => true, 
                'message' => 'Cover picture updated successfully',
                'image_url' => $filepath
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database update failed']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to upload file']);
    }
}

// Handle cover photo removal logic
if (isset($_POST['action']) && $_POST['action'] === 'remove') {
    $upload_dir = 'uploads/cover/';
    $sql = "SELECT cover_pic FROM users WHERE id = {$_SESSION['user_id']}";
    $result = mysqli_query($con, $sql);
    $user = mysqli_fetch_assoc($result);

    if (!empty($user['cover_pic'])) {
        $old_file = $upload_dir . $user['cover_pic'];
        if (file_exists($old_file)) {
            unlink($old_file);
        }

        // Remove cover photo from the database
        $sql = "UPDATE users SET cover_pic = NULL WHERE id = {$_SESSION['user_id']}";
        if (mysqli_query($con, $sql)) {
            echo json_encode([
                'success' => true,
                'message' => 'Cover photo removed successfully',
                'default_image' => 'assets/images/default-cover.jpg'
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update database']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No cover photo to remove']);
    }
}
