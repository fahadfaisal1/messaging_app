<?php
session_start();
require_once 'includes/config.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || !isset($_POST['user_id']) || !isset($_POST['action'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit();
}

$sender_id = $_SESSION['user_id'];
$receiver_id = (int)$_POST['user_id'];
$action = $_POST['action'];

switch($action) {
    case 'send':
        $sql = "INSERT INTO friend_requests (sender_id, receiver_id) VALUES ($sender_id, $receiver_id)";
        break;
        
    case 'accept':
        $sql = "UPDATE friend_requests 
                SET status = 'accepted' 
                WHERE receiver_id = $sender_id 
                AND sender_id = $receiver_id 
                AND status = 'pending'";
        break;
        
    case 'reject':
        $sql = "UPDATE friend_requests 
                SET status = 'rejected' 
                WHERE receiver_id = $sender_id 
                AND sender_id = $receiver_id 
                AND status = 'pending'";
        break;
        
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        exit();
}

if(mysqli_query($con, $sql)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode([
        'success' => false, 
        'message' => 'Database error: ' . mysqli_error($con)
    ]);
} 