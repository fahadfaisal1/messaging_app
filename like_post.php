<?php
session_start();
require_once 'includes/config.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || !isset($_POST['post_id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit();
}

$post_id = (int)$_POST['post_id'];
$user_id = $_SESSION['user_id'];

// Check if already liked
$check_sql = "SELECT id FROM likes WHERE post_id = $post_id AND user_id = $user_id";
$check_result = mysqli_query($con, $check_sql);

if(mysqli_num_rows($check_result) > 0) {
    // Unlike
    $sql = "DELETE FROM likes WHERE post_id = $post_id AND user_id = $user_id";
    $action = 'unliked';
} else {
    // Like
    $sql = "INSERT INTO likes (post_id, user_id) VALUES ($post_id, $user_id)";
    $action = 'liked';
}

if(mysqli_query($con, $sql)) {
    // Get updated likes count
    $count_sql = "SELECT COUNT(*) as likes FROM likes WHERE post_id = $post_id";
    $count_result = mysqli_query($con, $count_sql);
    $likes = mysqli_fetch_assoc($count_result)['likes'];
    
    echo json_encode([
        'success' => true,
        'action' => $action,
        'likes' => $likes
    ]);
} else {
    echo json_encode([
        'success' => false, 
        'message' => 'Database error: ' . mysqli_error($con)
    ]);
}
?> 
