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
        // Check if request already exists
        $check_sql = "SELECT * FROM friend_requests 
                     WHERE (sender_id = $sender_id AND receiver_id = $receiver_id)
                     OR (sender_id = $receiver_id AND receiver_id = $sender_id)";
        $check_result = mysqli_query($con, $check_sql);
        
        if(mysqli_num_rows($check_result) > 0) {
            echo json_encode(['success' => false, 'message' => 'Request already exists']);
            exit();
        }

        $sql = "INSERT INTO friend_requests (sender_id, receiver_id) VALUES ($sender_id, $receiver_id)";
        if(mysqli_query($con, $sql)) {
            $notification_sql = "INSERT INTO notifications (user_id, type, from_user_id, content) 
                               VALUES ($receiver_id, 'friend_request', $sender_id, 
                               (SELECT CONCAT(username, ' sent you a friend request') 
                                FROM users WHERE id = $sender_id))";
            mysqli_query($con, $notification_sql);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => mysqli_error($con)]);
        }
        break;
        
    case 'cancel':
        $sql = "DELETE FROM friend_requests 
                WHERE sender_id = $sender_id 
                AND receiver_id = $receiver_id 
                AND status = 'pending'";
        
        if(mysqli_query($con, $sql)) {
            if(mysqli_affected_rows($con) > 0) {
                $notification_sql = "INSERT INTO notifications (user_id, type, from_user_id, content) 
                                   VALUES ($receiver_id, 'friend_request_canceled', $sender_id, 
                                   (SELECT CONCAT(username, ' canceled their friend request') 
                                    FROM users WHERE id = $sender_id))";
                mysqli_query($con, $notification_sql);
                
                mysqli_query($con, "DELETE FROM notifications 
                                  WHERE user_id = $receiver_id 
                                  AND from_user_id = $sender_id 
                                  AND type = 'friend_request'");
                                  
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'No request found to cancel']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => mysqli_error($con)]);
        }
        break;
        
    case 'accept':
        $sql = "UPDATE friend_requests 
                SET status = 'accepted' 
                WHERE receiver_id = $sender_id 
                AND sender_id = $receiver_id 
                AND status = 'pending'";
        if(mysqli_query($con, $sql)) {
            if(mysqli_affected_rows($con) > 0) {
                // Add notification for accepted request
                $notification_sql = "INSERT INTO notifications (user_id, type, from_user_id, content) 
                                   VALUES ($receiver_id, 'friend_request_accepted', $sender_id, 
                                   (SELECT CONCAT(username, ' accepted your friend request') 
                                    FROM users WHERE id = $sender_id))";
                mysqli_query($con, $notification_sql);
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'No request found to accept']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => mysqli_error($con)]);
        }
        break;
        
    case 'reject':
        $sql = "DELETE FROM friend_requests 
                WHERE receiver_id = $sender_id 
                AND sender_id = $receiver_id 
                AND status = 'pending'";
        if(mysqli_query($con, $sql)) {
            if(mysqli_affected_rows($con) > 0) {
                // Add notification for rejected request
                $notification_sql = "INSERT INTO notifications (user_id, type, from_user_id, content) 
                                   VALUES ($receiver_id, 'friend_request_rejected', $sender_id, 
                                   (SELECT CONCAT(username, ' rejected your friend request') 
                                    FROM users WHERE id = $sender_id))";
                mysqli_query($con, $notification_sql);
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'message' => 'No request found to reject']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => mysqli_error($con)]);
        }
        break;
        
    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
        exit();
}
?> 