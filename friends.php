<?php
session_start();
require_once 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get users with friend request status
$sql = "SELECT DISTINCT
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
        GROUP BY users.id";

$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Find Friends</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .users-container {
            max-width: 800px;
            margin: 20px auto;
        }
        
        .user-card {
            background: var(--bg-secondary);
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 8px;
            box-shadow: 0 1px 3px var(--shadow-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .user-avatar {
            width: 50px;
            height: 50px;
            background: var(--bg-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .user-details h3 {
            margin: 0;
            color: var(--text-color);
        }
        
        .user-details p {
            margin: 5px 0 0;
            color: var(--text-secondary);
            font-size: 14px;
        }
        
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        
        .btn {
            padding: 8px 16px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .btn-primary {
            background: var(--primary-color);
            color: white;
        }
        
        .btn-secondary {
            background: var(--bg-color);
            color: var(--text-color);
        }
        
        .search-box {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 16px;
            background: var(--bg-secondary);
            color: var(--text-color);
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-left">
            <button class="toggle-sidebar" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <h1>Find Friends</h1>
        </div>
        <div class="header-right">
            <span class="username">Welcome, <?php echo $_SESSION['username']; ?></span>
            <button class="dark-mode-toggle" onclick="toggleDarkMode()">
                <i class="fas fa-moon"></i>
            </button>
        </div>
    </div>

    <div class="container" id="container">
        <!-- Sidebar -->
        <?php include 'includes/sidebar.php'; ?>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Keep search outside the users-container -->
            <div class="search-wrapper" style="max-width: 800px; margin: 0 auto 20px;">
                <input type="text" id="searchInput" class="search-box" placeholder="Search users...">
            </div>

            <!-- Separate container for users -->
            <div class="users-container">
                <?php while($user = mysqli_fetch_assoc($result)): ?>
                    <div class="user-card">
                        <?php 
                        $profile_pic = !empty($user['profile_pic']) 
                            ? 'uploads/profile/' . htmlspecialchars($user['profile_pic'])
                            : 'assets/images/default-avatar.jpg';
                        ?>
                        <img src="<?php echo $profile_pic; ?>" alt="Profile Picture" class="profile-pic" onerror="this.src='assets/images/default-avatar.jpg'">
                        <h3><?php echo htmlspecialchars($user['username']); ?></h3>
                        <div class="action-buttons">
                            <?php if (empty($user['request_status'])): ?>
                                <button class="btn btn-primary" onclick="sendFriendRequest(<?php echo $user['id']; ?>, this)">
                                    <i class="fas fa-user-plus"></i>
                                    Add Friend
                                </button>
                            <?php elseif ($user['request_status'] == 'pending'): ?>
                                <?php if ($user['request_type'] == 'sent'): ?>
                                    <button class="btn btn-secondary" onclick="cancelFriendRequest(<?php echo $user['id']; ?>, this)">
                                        <i class="fas fa-times"></i>
                                        Cancel Request
                                    </button>
                                <?php else: ?>
                                    <button class="btn btn-primary" onclick="handleFriendRequest(<?php echo $user['id']; ?>, 'accept', this)">
                                        <i class="fas fa-check"></i>
                                        Accept
                                    </button>
                                    <button class="btn btn-secondary" onclick="handleFriendRequest(<?php echo $user['id']; ?>, 'reject', this)">
                                        <i class="fas fa-times"></i>
                                        Reject
                                    </button>
                                <?php endif; ?>
                            <?php endif; ?>
                            <a href="chat/messages.php?user=<?php echo $user['id']; ?>" class="btn btn-secondary">
                                <i class="fas fa-comment"></i>
                                Message
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <script>
        // Sidebar toggle function
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
        });

        // Search functionality
        let searchTimeout;
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchText = this.value;
            clearTimeout(searchTimeout);
            
            searchTimeout = setTimeout(() => {
                fetch(`search_users.php?search=${encodeURIComponent(searchText)}`)
                    .then(response => response.json())
                    .then(users => {
                        const container = document.querySelector('.users-container');
                        let html = '';
                        
                        users.forEach(user => {
                            let buttonHtml = '';
                            if (!user.request_status) {
                                buttonHtml = `
                                    <button class="btn btn-primary" onclick="sendFriendRequest(${user.id}, this)">
                                        <i class="fas fa-user-plus"></i>
                                        Add Friend
                                    </button>
                                `;
                            } else if (user.request_status == 'pending') {
                                if (user.request_type == 'sent') {
                                    buttonHtml = `
                                        <button class="btn btn-secondary" onclick="cancelFriendRequest(${user.id}, this)">
                                            <i class="fas fa-times"></i>
                                            Cancel Request
                                        </button>
                                    `;
                                } else {
                                    buttonHtml = `
                                        <button class="btn btn-primary" onclick="handleFriendRequest(${user.id}, 'accept', this)">
                                            <i class="fas fa-check"></i>
                                            Accept
                                        </button>
                                        <button class="btn btn-secondary" onclick="handleFriendRequest(${user.id}, 'reject', this)">
                                            <i class="fas fa-times"></i>
                                            Reject
                                        </button>
                                    `;
                                }
                            }
                            
                            html += `
                                <div class="user-card">
                                    <img src="${user.profile_pic}" alt="Profile Picture" class="profile-pic" onerror="this.src='assets/images/default-avatar.jpg'">
                                    <h3>${user.username}</h3>
                                    <div class="action-buttons">
                                        ${buttonHtml}
                                        <a href="chat/messages.php?user=${user.id}" class="btn btn-secondary">
                                            <i class="fas fa-comment"></i>
                                            Message
                                        </a>
                                    </div>
                                </div>
                            `;
                        });
                        
                        container.innerHTML = html || '<p style="text-align: center; color: var(--text-secondary);">No users found</p>';
                    })
                    .catch(error => console.error('Error:', error));
            }, 300);
        });

        function sendFriendRequest(userId, button) {
            // Disable the button to prevent multiple clicks
            button.disabled = true;
            
            fetch('handle_friend_request.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=send&user_id=${userId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const actionButtons = button.parentElement;
                    actionButtons.innerHTML = `
                        <button class="btn btn-secondary" onclick="cancelFriendRequest(${userId}, this)">
                            <i class="fas fa-times"></i>
                            Cancel Request
                        </button>
                        <a href="chat/messages.php?user=${userId}" class="btn btn-secondary">
                            <i class="fas fa-comment"></i>
                            Message
                        </a>
                    `;
                } else {
                    // Re-enable the button if there was an error
                    button.disabled = false;
                    alert(data.message || 'Error sending friend request');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                button.disabled = false;
            });
        }

        function handleFriendRequest(userId, action, button) {
            fetch('handle_friend_request.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=${action}&user_id=${userId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const actionButtons = button.parentElement;
                    if (action === 'reject') {
                        // After reject, show Add Friend button
                        actionButtons.innerHTML = `
                            <button class="btn btn-primary" onclick="sendFriendRequest(${userId}, this)">
                                <i class="fas fa-user-plus"></i>
                                Add Friend
                            </button>
                            <a href="chat/messages.php?user=${userId}" class="btn btn-secondary">
                                <i class="fas fa-comment"></i>
                                Message
                            </a>
                        `;
                    } else if (action === 'accept') {
                        // After accept, show Friends status
                        actionButtons.innerHTML = `
                            <button class="btn btn-secondary" disabled>
                                <i class="fas fa-user-check"></i>
                                Friends
                            </button>
                            <a href="chat/messages.php?user=${userId}" class="btn btn-secondary">
                                <i class="fas fa-comment"></i>
                                Message
                            </a>
                        `;
                    }
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function cancelFriendRequest(userId, button) {
            // Disable the button to prevent multiple clicks
            button.disabled = true;
            
            fetch('handle_friend_request.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=cancel&user_id=${userId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const actionButtons = button.parentElement;
                    actionButtons.innerHTML = `
                        <button class="btn btn-primary" onclick="sendFriendRequest(${userId}, this)">
                            <i class="fas fa-user-plus"></i>
                            Add Friend
                        </button>
                        <a href="chat/messages.php?user=${userId}" class="btn btn-secondary">
                            <i class="fas fa-comment"></i>
                            Message
                        </a>
                    `;
                } else {
                    // Re-enable the button if there was an error
                    button.disabled = false;
                    alert(data.message || 'Error canceling friend request');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                button.disabled = false;
            });
        }
    </script>
</body>
</html> 