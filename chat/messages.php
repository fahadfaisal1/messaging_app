<?php
session_start();
require_once '../includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Get all users except current user
$sql = "SELECT id, username, profile_pic FROM users WHERE id != {$_SESSION['user_id']}";
$users = mysqli_query($con, $sql);

// Get selected user's chat
$selected_user = isset($_GET['user']) ? (int)$_GET['user'] : null;
if($selected_user) {
    $sql = "SELECT messages.*, users.username 
            FROM messages 
            JOIN users ON messages.sender_id = users.id 
            WHERE (sender_id = {$_SESSION['user_id']} AND receiver_id = {$selected_user})
            OR (sender_id = {$selected_user} AND receiver_id = {$_SESSION['user_id']})
            ORDER BY sent_at ASC";
    $messages = mysqli_query($con, $sql);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Messages</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/chat.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="header">
        <div class="header-left">
            <button class="toggle-sidebar" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <h1>Messages</h1>
        </div>
        <div class="header-right">
            <span class="username">Welcome, <?php echo $_SESSION['username']; ?></span>
            <button class="dark-mode-toggle" onclick="toggleDarkMode()">
                <i class="fas fa-moon"></i>
            </button>
        </div>
    </div>

    <div class="container" id="container">
        <?php include '../includes/sidebar.php'; ?>

        <div class="main-content">
            <div class="chat-container">
                <div class="users-list">
                    <?php while($user = mysqli_fetch_assoc($users)) { ?>
                        <a href="?user=<?php echo $user['id']; ?>" 
                           class="user-item <?php echo ($selected_user == $user['id']) ? 'active' : ''; ?>">
                            <div class="user-avatar">
                                <?php 
                                $profile_pic = !empty($user['profile_pic']) 
                                    ? '../uploads/profile/' . htmlspecialchars($user['profile_pic'])
                                    : '../assets/images/default-avatar.jpg';
                                ?>
                                <img src="<?php echo $profile_pic; ?>" alt="Profile Picture" onerror="this.src='../assets/images/default-avatar.jpg'">
                            </div>
                            <div class="user-info">
                                <span class="user-name"><?php echo $user['username']; ?></span>
                            </div>
                        </a>
                    <?php } ?>
                </div>

                <div class="chat-area">
                    <?php if($selected_user): ?>
                        <div class="messages-container" id="messages">
                            <?php if(mysqli_num_rows($messages) > 0): ?>
                                <?php while($message = mysqli_fetch_assoc($messages)): ?>
                                    <div class="message <?php echo ($message['sender_id'] == $_SESSION['user_id']) ? 'sent' : 'received'; ?>">
                                        <div class="message-content">
                                            <?php echo htmlspecialchars($message['message']); ?>
                                        </div>
                                        
                                        <div class="message-time">
                                            <?php echo date('H:i', strtotime($message['sent_at'])); ?>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <div class="no-messages">No messages yet. Start the conversation!</div>
                            <?php endif; ?>
                        </div>
                        <form class="message-form" id="messageForm">
                            <input type="hidden" name="receiver_id" value="<?php echo $selected_user; ?>">
                            <input type="text" name="message" placeholder="Type a message..." required>
                            <button type="submit">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </form>
                    <?php else: ?>
                        <div class="select-chat">
                            <i class="fas fa-comments"></i>
                            <p>Select a chat to start messaging</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function toggleSidebar() {
            const container = document.getElementById('container');
            container.classList.toggle('sidebar-hidden');
            localStorage.setItem('sidebarHidden', container.classList.contains('sidebar-hidden'));
        }

        function toggleDarkMode() {
            const html = document.documentElement;
            const isDark = html.getAttribute('data-theme') === 'dark';
            const icon = document.querySelector('.dark-mode-toggle i');
            
            if (isDark) {
                html.removeAttribute('data-theme');
                icon.classList.remove('fa-sun');
                icon.classList.add('fa-moon');
                localStorage.setItem('darkMode', 'light');
            } else {
                html.setAttribute('data-theme', 'dark');
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
                localStorage.setItem('darkMode', 'dark');
            }
        }

        function scrollToBottom() {
            const messages = document.getElementById('messages');
            if(messages) {
                messages.scrollTop = messages.scrollHeight;
            }
        }

        // Check preferences on load
        window.addEventListener('load', () => {
            const isHidden = localStorage.getItem('sidebarHidden') === 'true';
            if (isHidden) {
                document.getElementById('container').classList.add('sidebar-hidden');
            }
            
            const darkMode = localStorage.getItem('darkMode');
            const icon = document.querySelector('.dark-mode-toggle i');
            
            if (darkMode === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            }
            
            scrollToBottom();
        });

        // Handle message sending
        $(document).ready(function() {
            $('#messageForm').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);
                const messageInput = form.find('input[name="message"]');
                
                $.ajax({
                    url: 'send_message.php',
                    method: 'POST',
                    data: form.serialize(),
                    success: function(response) {
                        if(response.success) {
                            messageInput.val('');
                            location.reload();
                        }
                    }
                });
            });
        });

        // Auto refresh messages
        function loadNewMessages() {
            const selectedUser = <?php echo $selected_user ?? 'null'; ?>;
            if(selectedUser) {
                $.ajax({
                    url: 'get_messages.php',
                    method: 'GET',
                    data: { user: selectedUser },
                    success: function(response) {
                        $('#messages').html(response);
                        scrollToBottom();
                    }
                });
            }
        }
        setInterval(loadNewMessages, 3000);
    </script>
</body>
</html>
