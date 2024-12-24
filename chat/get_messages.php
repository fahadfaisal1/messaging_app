<?php
session_start();
require_once '../includes/config.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['user'])) {
    exit();
}

$selected_user = (int)$_GET['user'];
$sql = "SELECT messages.*, users.username 
        FROM messages 
        JOIN users ON messages.sender_id = users.id 
        WHERE (sender_id = {$_SESSION['user_id']} AND receiver_id = {$selected_user})
        OR (sender_id = {$selected_user} AND receiver_id = {$_SESSION['user_id']})
        ORDER BY sent_at ASC";
$messages = mysqli_query($con, $sql);

while($message = mysqli_fetch_assoc($messages)): ?>
    <div class="message <?php echo ($message['sender_id'] == $_SESSION['user_id']) ? 'sent' : 'received'; ?>">
        <div class="message-content">
            <?php echo htmlspecialchars($message['message']); ?>
        </div>
        <div class="message-time">
            <?php echo date('H:i', strtotime($message['sent_at'])); ?>
        </div>
    </div>
<?php endwhile; ?> 