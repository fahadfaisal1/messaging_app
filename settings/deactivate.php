<h2>Deactivate Account</h2>

<div class="warning-box">
    <p>Warning: Deactivating your account will:</p>
    <ul>
        <li>Hide your profile from other users</li>
        <li>Remove your posts from the timeline</li>
        <li>You can reactivate anytime by logging in</li>
    </ul>
</div>

<form method="POST" onsubmit="return confirm('Are you sure you want to deactivate your account?');">
    <div class="form-group">
        <label>Enter your password to confirm:</label>
        <input type="password" name="confirm_password" required>
    </div>

    <button type="submit" name="deactivate_account" class="btn-danger">Deactivate Account</button>
</form> 