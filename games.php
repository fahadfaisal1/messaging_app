<?php
session_start();
require_once 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get current game if selected
$current_game = isset($_GET['game']) ? $_GET['game'] : '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Games</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .games-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }

        .games-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px 0;
        }

        .game-card {
            background: var(--bg-secondary);
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s;
            box-shadow: 0 2px 5px var(--shadow-color);
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .game-card:hover {
            transform: translateY(-5px);
        }

        .game-thumbnail {
            width: 100%;
            aspect-ratio: 16/9;
            background: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3em;
        }

        .game-info {
            padding: 15px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .game-info h3 {
            margin: 0;
            color: var(--text-color);
        }

        .game-info p {
            color: var(--text-secondary);
            font-size: 0.9em;
            margin: 5px 0;
            flex-grow: 1;
        }

        .play-btn {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            text-align: center;
            text-decoration: none;
            margin-top: auto;
        }

        .play-btn:hover {
            opacity: 0.9;
        }

        /* Dark mode specific styles */
        [data-theme="dark"] .game-info h3,
        [data-theme="dark"] .game-info p {
            color: white;
        }

        [data-theme="dark"] .game-card {
            background: var(--bg-secondary);
        }

        /* Game container styles */
        .game-container {
            background: var(--bg-secondary);
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }

        .back-to-games {
            margin-bottom: 20px;
            padding: 8px 16px;
            background: var(--bg-color);
            border: 1px solid var(--border-color);
            border-radius: 5px;
            color: var(--text-color);
            cursor: pointer;
        }

        /* Existing game-specific styles */
        .memory-game {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            max-width: 600px;
            margin: 0 auto;
        }

        .card {
            aspect-ratio: 3/4;
            background: var(--primary-color);
            border-radius: 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2em;
            color: white;
            transition: transform 0.3s;
        }

        /* Add more game-specific styles here */

        /* Dark mode text colors */
        [data-theme="dark"] .game-info h3 {
            color: #ffffff;
        }

        [data-theme="dark"] .game-info p {
            color: #e4e6eb;
        }

        [data-theme="dark"] .game-title {
            color: #ffffff;
        }

        [data-theme="dark"] .game-status {
            color: #ffffff;
        }

        [data-theme="dark"] .game-stats {
            color: #ffffff;
        }

        [data-theme="dark"] .back-to-games {
            color: #ffffff;
        }

        [data-theme="dark"] .username {
            color: #ffffff;
        }

        [data-theme="dark"] h1 {
            color: #ffffff;
        }

        /* Make sure all text in dark mode is visible */
        [data-theme="dark"] {
            color-scheme: dark;
        }

        /* Ensure buttons and interactive elements maintain contrast */
        [data-theme="dark"] .play-btn {
            color: #ffffff;
        }

        [data-theme="dark"] .btn-game {
            color: #ffffff;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-left">
            <button class="toggle-sidebar" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <h1>Games</h1>
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
            <div class="games-container">
                <?php if(empty($current_game)): ?>
                    <!-- Games Grid -->
                    <div class="games-grid">
                        <!-- Memory Game Card -->
                        <div class="game-card">
                            <div class="game-thumbnail">
                                🎮
                            </div>
                            <div class="game-info">
                                <h3>Memory Match</h3>
                                <p>Match pairs of cards to test your memory</p>
                                <a href="?game=memory" class="play-btn">Play Now</a>
                            </div>
                        </div>

                        <!-- Tic Tac Toe Card -->
                        <div class="game-card">
                            <div class="game-thumbnail">
                                ⭕
                            </div>
                            <div class="game-info">
                                <h3>Tic Tac Toe</h3>
                                <p>Classic X's and O's game</p>
                                <a href="?game=tictactoe" class="play-btn">Play Now</a>
                            </div>
                        </div>

                        <!-- Snake Game Card -->
                        <div class="game-card">
                            <div class="game-thumbnail">
                                🐍
                            </div>
                            <div class="game-info">
                                <h3>Snake</h3>
                                <p>Classic snake game - eat and grow longer</p>
                                <a href="?game=snake" class="play-btn">Play Now</a>
                            </div>
                        </div>

                        <!-- Word Guess Card -->
                        <div class="game-card">
                            <div class="game-thumbnail">
                                📝
                            </div>
                            <div class="game-info">
                                <h3>Word Guess</h3>
                                <p>Guess the hidden word</p>
                                <a href="?game=wordguess" class="play-btn">Play Now</a>
                            </div>
                        </div>
                    </div>

                <?php else: ?>
                    <!-- Individual Game Container -->
                    <button class="back-to-games" onclick="window.location.href='games.php'">
                        <i class="fas fa-arrow-left"></i> Back to Games
                    </button>

                    <div class="game-container">
                        <?php
                        switch($current_game) {
                            case 'memory':
                                include 'games/memory.php';
                                break;
                            case 'tictactoe':
                                include 'games/tictactoe.php';
                                break;
                            case 'snake':
                                include 'games/snake.php';
                                break;
                            case 'wordguess':
                                include 'games/wordguess.php';
                                break;
                            default:
                                echo "<p>Game not found!</p>";
                        }
                        ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        // Dark Mode Toggle
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

        // Check dark mode on load
        window.addEventListener('load', () => {
            const darkMode = localStorage.getItem('darkMode');
            if (darkMode === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
                const icon = document.querySelector('.dark-mode-toggle i');
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            }
        });

        // Sidebar toggle
        function toggleSidebar() {
            const container = document.getElementById('container');
            container.classList.toggle('sidebar-hidden');
            localStorage.setItem('sidebarHidden', container.classList.contains('sidebar-hidden'));
        }
    </script>
</body>
</html> 