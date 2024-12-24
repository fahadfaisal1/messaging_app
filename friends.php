<?php
session_start();
require_once 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get all users except current user
$sql = "SELECT id, username, email FROM users WHERE id != {$_SESSION['user_id']}";
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
            <div class="users-container">
                <input type="text" id="searchInput" class="search-box" placeholder="Search users...">
                
                <?php while($user = mysqli_fetch_assoc($result)): ?>
                    <div class="user-card">
                        <div class="user-info">
                            <div class="user-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="user-details">
                                <h3><?php echo htmlspecialchars($user['username']); ?></h3>
                                <p><?php echo htmlspecialchars($user['email']); ?></p>
                            </div>
                        </div>
                        <div class="action-buttons">
                            <a href="chat/messages.php?user=<?php echo $user['id']; ?>" class="btn btn-secondary">
                                <i class="fas fa-comment"></i>
                                Message
                            </a>
                            <button class="btn btn-primary">
                                <i class="fas fa-user-plus"></i>
                                Add Friend
                            </button>
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
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchText = this.value.toLowerCase();
            const userCards = document.getElementsByClassName('user-card');
            
            Array.from(userCards).forEach(card => {
                const username = card.querySelector('h3').textContent.toLowerCase();
                const email = card.querySelector('p').textContent.toLowerCase();
                
                if(username.includes(searchText) || email.includes(searchText)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html> 