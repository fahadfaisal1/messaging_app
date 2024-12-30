<?php
// Get current user data
$user_sql = "SELECT username, email, city FROM users WHERE id = {$_SESSION['user_id']}";
$user_result = mysqli_query($con, $user_sql);
$user_data = mysqli_fetch_assoc($user_result);

// Handle form submission
if(isset($_POST['save_general'])) {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $city = mysqli_real_escape_string($con, $_POST['city']);
    
    $query = "UPDATE users SET 
              username='$username', 
              email='$email', 
              city='$city' 
              WHERE id={$_SESSION['user_id']}";
    
    if(mysqli_query($con, $query)) {
        $_SESSION['username'] = $username;
        $success_msg = "General settings updated successfully!";
    } else {
        $error_msg = "Error updating settings: " . mysqli_error($con);
    }
}
?>

<h2>General Account Settings</h2>

<?php if(isset($success_msg)): ?>
    <div class="alert success"><?php echo $success_msg; ?></div>
<?php endif; ?>

<?php if(isset($error_msg)): ?>
    <div class="alert error"><?php echo $error_msg; ?></div>
<?php endif; ?>

<form method="POST">
    <div class="form-group">
        <label>Username</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($user_data['username']); ?>" required>
    </div>

    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user_data['email']); ?>" required>
    </div>

    <div class="form-group">
        <label>City</label>
        <input type="text" name="city" value="<?php echo htmlspecialchars($user_data['city']); ?>">
        <small style="color: var(--text-secondary);">Enter your city name (optional)</small>
    </div>

    <button type="submit" name="save_general" class="btn-save">Save Changes</button>
</form> 