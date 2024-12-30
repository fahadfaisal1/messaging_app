<h2>Blocked Users</h2>

<div class="blocked-users">
    <?php
    // Get blocked users
    $query = "SELECT users.* FROM users 
              JOIN blocked_users ON blocked_users.blocked_id = users.id 
              WHERE blocked_users.user_id = {$_SESSION['user_id']}";
    $result = mysqli_query($con, $query);
    
    if(mysqli_num_rows($result) > 0):
        while($blocked = mysqli_fetch_assoc($result)):
    ?>
        <div class="blocked-user">
            <span><?php echo htmlspecialchars($blocked['username']); ?></span>
            <button onclick="unblockUser(<?php echo $blocked['id']; ?>)">Unblock</button>
        </div>
    <?php 
        endwhile;
    else:
    ?>
        <p>You haven't blocked any users.</p>
    <?php endif; ?>
</div> 