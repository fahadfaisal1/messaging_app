<?php
session_start();
include 'includes/config.php';

if(isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($con, $sql);
    
    if(mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if(password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Wrong password!";
        }
    } else {
        $error = "Email not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="header">
        <div class="header-left">
            <h1>MySocialApp</h1>
        </div>
        <div class="header-right">
            <button class="dark-mode-toggle" onclick="toggleDarkMode()">
                <i class="fas fa-moon"></i>
            </button>
        </div>
    </div>
    
    <form method="POST" style="margin-top: 100px;">
        <h2>Login</h2>
        <?php if(isset($error)) { ?>
            <div class="error"><?php echo $error; ?></div>
        <?php } ?>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="submit">Login</button>
        <p style="margin-top: 10px; text-align: center; color: var(--text-color);">
            Don't have an account? <a href="register.php" style="color: var(--primary-color);">Register here</a>
        </p>
    </form>

    <script>
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

        // Check dark mode preference on load
        window.addEventListener('load', () => {
            const darkMode = localStorage.getItem('darkMode');
            const icon = document.querySelector('.dark-mode-toggle i');
            
            if (darkMode === 'dark') {
                document.documentElement.setAttribute('data-theme', 'dark');
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            }
        });
    </script>
</body>
</html>
