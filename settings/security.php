<h2>Security and Login</h2>

<form method="POST">
    <div class="form-group">
        <label>Current Password</label>
        <input type="password" name="current_password" required>
    </div>

    <div class="form-group">
        <label>New Password</label>
        <input type="password" name="new_password" required>
    </div>

    <div class="form-group">
        <label>Confirm New Password</label>
        <input type="password" name="confirm_password" required>
    </div>

    <button type="submit" name="save_security" class="btn-save">Change Password</button>
</form> 