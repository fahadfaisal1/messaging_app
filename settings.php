<?php
session_start();
require_once 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get current user data
$user_id = $_SESSION['user_id'];
$result = mysqli_query($con, "SELECT * FROM users WHERE id=$user_id");
$user = mysqli_fetch_assoc($result);

// Get current section (default to general)
$section = isset($_GET['section']) ? $_GET['section'] : 'general';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Settings</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .settings-container {
            display: flex;
            gap: 20px;
            padding: 20px;
        }

        .settings-sidebar {
            width: 300px;
            background: var(--bg-secondary);
            border-radius: 8px;
            padding: 15px;
            height: fit-content;
        }

        .settings-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .settings-menu-header {
            padding: 10px 15px;
            font-weight: bold;
            color: var(--text-secondary);
            border-bottom: 1px solid var(--border-color);
            margin-bottom: 5px;
        }

        .settings-menu li a {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: var(--text-color);
            text-decoration: none;
            border-radius: 6px;
            margin: 2px 0;
            gap: 10px;
        }

        .settings-menu li a:hover {
            background: var(--hover-color);
        }

        .settings-menu li a.active {
            background: var(--primary-color);
            color: white;
        }

        .settings-content {
            flex: 1;
            background: var(--bg-secondary);
            border-radius: 8px;
            padding: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--text-color);
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            background: var(--bg-color);
            color: var(--text-color);
        }

        .btn-save {
            background: var(--primary-color);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn-save:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-left">
            <button class="toggle-sidebar" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <h1>Settings</h1>
        </div>
        <div class="header-right">
            <span class="username">Welcome, <?php echo $_SESSION['username']; ?></span>
            <button class="dark-mode-toggle" onclick="toggleDarkMode()">
                <i class="fas fa-moon"></i>
            </button>
        </div>
    </div>

    <div class="container" id="container">
        <?php include 'includes/sidebar.php'; ?>

        <div class="main-content">
            <div class="settings-container">
                <!-- Settings Sidebar -->
                <div class="settings-sidebar">
                    <ul class="settings-menu">
                        <li class="settings-menu-header">Account Settings</li>
                        <li>
                            <a href="?section=general" class="<?php echo $section == 'general' ? 'active' : ''; ?>">
                                <i class="fas fa-cog"></i> General
                            </a>
                        </li>
                        <li>
                            <a href="?section=security" class="<?php echo $section == 'security' ? 'active' : ''; ?>">
                                <i class="fas fa-shield-alt"></i> Security and Login
                            </a>
                        </li>
                        <li>
                            <a href="?section=privacy" class="<?php echo $section == 'privacy' ? 'active' : ''; ?>">
                                <i class="fas fa-lock"></i> Privacy
                            </a>
                        </li>

                        <li class="settings-menu-header">Profile Settings</li>
                        <li>
                            <a href="?section=profile" class="<?php echo $section == 'profile' ? 'active' : ''; ?>">
                                <i class="fas fa-user"></i> Profile Information
                            </a>
                        </li>
                        <li>
                            <a href="?section=notifications" class="<?php echo $section == 'notifications' ? 'active' : ''; ?>">
                                <i class="fas fa-bell"></i> Notifications
                            </a>
                        </li>

                        <li class="settings-menu-header">Additional Settings</li>
                        <li>
                            <a href="?section=language" class="<?php echo $section == 'language' ? 'active' : ''; ?>">
                                <i class="fas fa-language"></i> Language
                            </a>
                        </li>
                        <li>
                            <a href="?section=blocking" class="<?php echo $section == 'blocking' ? 'active' : ''; ?>">
                                <i class="fas fa-user-slash"></i> Blocking
                            </a>
                        </li>
                        <li>
                            <a href="?section=deactivate" class="<?php echo $section == 'deactivate' ? 'active' : ''; ?>">
                                <i class="fas fa-user-times"></i> Deactivate Account
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Settings Content -->
                <div class="settings-content">
                    <?php
                    switch($section) {
                        case 'general':
                            include 'settings/general.php';
                            break;
                        case 'security':
                            include 'settings/security.php';
                            break;
                        case 'privacy':
                            include 'settings/privacy.php';
                            break;
                        case 'profile':
                            include 'settings/profile.php';
                            break;
                        case 'notifications':
                            include 'settings/notifications.php';
                            break;
                        case 'language':
                            include 'settings/language.php';
                            break;
                        case 'blocking':
                            include 'settings/blocking.php';
                            break;
                        case 'deactivate':
                            include 'settings/deactivate.php';
                            break;
                        default:
                            include 'settings/general.php';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Dark Mode Toggle with localStorage
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

        // Check dark mode preference on page load
        window.addEventListener('load', () => {
            // Check sidebar state
            const isHidden = localStorage.getItem('sidebarHidden') === 'true';
            if (isHidden) {
                document.getElementById('container').classList.add('sidebar-hidden');
            }
            
            // Check and apply dark mode
            const darkMode = localStorage.getItem('darkMode');
            const icon = document.querySelector('.dark-mode-toggle i');
            
            if (darkMode === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            }
        });

        // Sidebar toggle function
        function toggleSidebar() {
            const container = document.getElementById('container');
            container.classList.toggle('sidebar-hidden');
            localStorage.setItem('sidebarHidden', container.classList.contains('sidebar-hidden'));
        }
    </script>
</body>
</html>