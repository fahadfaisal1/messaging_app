<h2>Privacy Settings</h2>

<form method="POST">
    <div class="form-group">
        <label>Who can see your posts?</label>
        <select name="post_privacy">
            <option value="public">Everyone</option>
            <option value="friends">Friends Only</option>
            <option value="private">Only Me</option>
        </select>
    </div>

    <div class="form-group">
        <label>Who can send you friend requests?</label>
        <select name="friend_privacy">
            <option value="everyone">Everyone</option>
            <option value="friends_of_friends">Friends of Friends</option>
            <option value="none">Nobody</option>
        </select>
    </div>

    <button type="submit" name="save_privacy" class="btn-save">Save Privacy Settings</button>
</form> 