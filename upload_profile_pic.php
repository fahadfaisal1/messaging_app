<?php
session_start();
require_once 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit();
}

if (!isset($_FILES['profile_pic'])) {
    echo json_encode(['success' => false, 'message' => 'No file uploaded']);
    exit();
}

$file = $_FILES['profile_pic'];
$allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
$max_size = 5 * 1024 * 1024; // 5MB

// Validate file
if (!in_array($file['type'], $allowed_types)) {
    echo json_encode(['success' => false, 'message' => 'Invalid file type. Only JPG, PNG and GIF allowed']);
    exit();
}

if ($file['size'] > $max_size) {
    echo json_encode(['success' => false, 'message' => 'File too large. Maximum size is 5MB']);
    exit();
}

// Create uploads directory if it doesn't exist
$upload_dir = 'uploads/profile/';
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Generate unique filename
$extension = pathinfo($file['name'], PATHINFO_EXTENSION);
$filename = uniqid() . '.' . $extension;
$filepath = $upload_dir . $filename;

// Delete old profile picture if exists
$sql = "SELECT profile_pic FROM users WHERE id = {$_SESSION['user_id']}";
$result = mysqli_query($con, $sql);
$user = mysqli_fetch_assoc($result);
if (!empty($user['profile_pic'])) {
    $old_file = $upload_dir . $user['profile_pic'];
    if (file_exists($old_file)) {
        unlink($old_file);
    }
}

// Upload new file
if (move_uploaded_file($file['tmp_name'], $filepath)) {
    // Update database
    $sql = "UPDATE users SET profile_pic = '$filename' WHERE id = {$_SESSION['user_id']}";
    if (mysqli_query($con, $sql)) {
        echo json_encode([
            'success' => true, 
            'message' => 'Profile picture updated successfully',
            'image_url' => $filepath
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database update failed']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to upload file']);
} 