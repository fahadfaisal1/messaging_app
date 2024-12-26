<?php
session_start();
require_once 'includes/config.php';
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit();
}

$search = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';

$sql = "SELECT 
        users.id, users.username, users.profile_pic,
        fr.status as request_status,
        CASE 
            WHEN fr.sender_id = {$_SESSION['user_id']} THEN 'sent'
            WHEN fr.receiver_id = {$_SESSION['user_id']} THEN 'received'
        END as request_type
        FROM users 
        LEFT JOIN friend_requests fr ON 
            (fr.sender_id = {$_SESSION['user_id']} AND fr.receiver_id = users.id) OR
            (fr.receiver_id = {$_SESSION['user_id']} AND fr.sender_id = users.id)
        WHERE users.id != {$_SESSION['user_id']}
        " . ($search ? "AND users.username LIKE '%$search%'" : "");

$result = mysqli_query($con, $sql);
$users = [];

while($user = mysqli_fetch_assoc($result)) {
    $profile_pic = !empty($user['profile_pic']) 
        ? 'uploads/profile/' . $user['profile_pic']
        : 'assets/images/default-avatar.jpg';
    
    $user['profile_pic'] = $profile_pic;
    $users[] = $user;
}

echo json_encode($users);
?> 