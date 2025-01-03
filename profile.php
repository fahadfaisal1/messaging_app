<?php
session_start();
require_once 'includes/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get user details
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($con, $sql);
$user = mysqli_fetch_assoc($result);

// Get user's posts
$posts_sql = "SELECT posts.*, users.username, users.profile_pic
              FROM posts 
              JOIN users ON posts.user_id = users.id 
              WHERE posts.user_id = $user_id 
              ORDER BY posts.created_at DESC";
$posts_result = mysqli_query($con, $posts_sql);
$posts_result = mysqli_query($con, $posts_sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile - <?php echo $user['username']; ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
    .post-image img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin-top: 10px;
}
  
.cover-photo {
    position: relative;
}

.cover-actions {
    position: absolute;
    bottom: 10px;
    right: 10px;
    display: flex; /* Use flexbox to align items in a row */
    gap: 10px; /* Space between the buttons */
}

.edit-cover, .remove-cover {
    margin-left: 10px;
    padding: 5px 10px;
    background-color: rgba(255, 255, 255, 0.7);
    border: none;
    border-radius: 5px;
    cursor: pointer;
    display: inline-block; /* Ensure buttons are inline */
}

.edit-cover:hover, .remove-cover:hover {
    background-color: rgba(255, 255, 255, 0.9);
}
    </style>
</head>
<body>
    <div class="header">
        <div class="header-left">
            <button class="toggle-sidebar" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <h1>Profile</h1>
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
            <div class="profile-container" >
                <!-- Cover Photo Section -->
                <div class="cover-photo">
                    <?php 
                    $cover_pic = !empty($user['cover_pic']) ? 'uploads/cover/' . $user['cover_pic'] : 'assets/images/default-cover.jpg';
                    ?>
                    <img src="<?php echo $cover_pic; ?>" alt="Cover Photo" id="coverImage">
                    <div class="cover-actions">
               <button class="edit-cover"  
                       onclick="document.getElementById('coverPicInput').click();" 
                       style="background-color: #add8e6; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
                   <i class="fas fa-camera"></i> Edit Cover Photo
               </button>
    <?php if (!empty($user['cover_pic'])): ?>
        <button class="remove-cover" 
                onclick="removeCoverPic()" 
                style="background-color: #add8e6; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
            <i class="fas fa-trash"></i> Remove Cover Photo
        </button>
    <?php endif; ?>
</div>
                    <input type="file" id="coverPicInput" style="display: none;" accept="image/*" onchange="uploadCoverPic(this)">
                </div>


                <!-- Profile Info Section -->
                <div class="profile-info">
                    <div class="profile-picture">
                        <?php 
                        $profile_pic = !empty($user['profile_pic']) ? 'uploads/profile/' . $user['profile_pic'] : 'assets/images/default-avatar.jpg';
                        ?>
                        <img src="<?php echo $profile_pic; ?>" alt="Profile Picture" id="profileImage">
                        <button class="edit-profile-pic" onclick="document.getElementById('profilePicInput').click();">
                            <i class="fas fa-camera"></i>
                        </button>
                        <input type="file" id="profilePicInput" style="display: none;" accept="image/*" onchange="uploadProfilePic(this)">
                    </div>
                    <div class="profile-details">
                        <h2><?php echo htmlspecialchars($user['username']); ?></h2>
                        <p class="bio">Click to add bio</p>
                        <div class="profile-stats">
                            <div class="stat">
                                <i class="fas fa-users"></i>
                                <span>0 Friends</span>
                            </div>
                            <div class="stat">
                                <i class="fas fa-image"></i>
                                <span>0 Photos</span>
                            </div>
                            <div class="stat">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Add Location</span>
                            </div>
                        </div>
                    </div>
                    <button class="edit-profile-btn">
                        <i class="fas fa-edit"></i> Edit Profile
                    </button>
                </div>

                <!-- Profile Navigation -->
                <div class="profile-nav">
                    <a href="#posts" class="active">Posts</a>
                    <a href="#about">About</a>
                    <a href="#friends">Friends</a>
                    <a href="#photos">Photos</a>
                </div>

                <!-- Posts Section -->
                <div class="profile-posts">
                    <!-- Create Post -->
                    <form method="POST" action="create_post.php" class="create-post">
                        <textarea name="content" placeholder="What's on your mind?"></textarea>
                        <div class="post-actions">
                            <button type="button" class="post-action">
                                <i class="fas fa-image"></i> Photo
                            </button>
                            <button type="submit" name="submit">Post</button>
                        </div>
                    </form>

                    <!-- Posts Display -->
                    <!-- Posts Display -->
                    <div class="posts">
                        <?php if(mysqli_num_rows($posts_result) > 0): ?>
                            <?php while($post = mysqli_fetch_assoc($posts_result)) { ?>
                                <div class="post">
                                    <div class="post-header">
                                        <?php 
                                        $post_profile_pic = !empty($post['profile_pic']) ? 'uploads/profile/' . $post['profile_pic'] : 'assets/images/default-avatar.jpg';
                                        ?>
                                        <img src="<?php echo $post_profile_pic; ?>" alt="Profile Picture">
                                        <div>
                                            <h3><?php echo htmlspecialchars($post['username']); ?></h3>
                                            <small><?php echo date('F j, Y g:i a', strtotime($post['created_at'])); ?></small>
                                        </div>
                                    </div>
                                    <p class="post-content"><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                                    <?php if(!empty($post['image'])): ?>
                                        <div class="post-image">
                                            <img src="uploads/posts/<?php echo htmlspecialchars($post['image']); ?>" alt="Post Image">
                                        </div>
                                    <?php endif; ?>
                                    <div class="post-actions">
                                        <button onclick="likePost(<?php echo $post['id']; ?>)">
                                            <i class="far fa-thumbs-up"></i> Like
                                        </button>
                                        <button>
                                            <i class="far fa-comment"></i> Comment
                                        </button>
                                        <button>
                                            <i class="far fa-share-square"></i> Share
                                        </button>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php else: ?>
                            <div class="no-posts">
                                <p>No posts yet. Create your first post!</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
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

        // Profile picture upload
        function uploadProfilePic(input) {
            if (input.files && input.files[0]) {
                const formData = new FormData();
                formData.append('profile_pic', input.files[0]);

                fetch('upload_profile_pic.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('profileImage').src = data.image_url;
                        // Update all profile images on the page
                        const profileImages = document.querySelectorAll('.post-header img');
                        profileImages.forEach(img => {
                            img.src = data.image_url;
                        });
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while uploading the image');
                });
            }
        }
        function uploadCoverPic(input) {
    if (input.files && input.files[0]) {
        const formData = new FormData();
        formData.append('cover_pic', input.files[0]);

        fetch('upload_cover_pic.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update cover photo image
                document.getElementById('coverImage').src = data.image_url;

                // Show the "Remove Cover Photo" button
                const removeButton = document.querySelector('.remove-cover');
                if (!removeButton) {
                    const coverActions = document.querySelector('.cover-actions');
                    const removeButtonHTML = `
                        <button class="remove-cover" onclick="removeCoverPic()">
                            <i class="fas fa-trash"></i> Remove Cover Photo
                        </button>
                    `;
                    coverActions.innerHTML += removeButtonHTML;  // Re-append the remove button
                }
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while uploading the image');
        });
    }
}


function likePost(postId) {
    fetch('like_post.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'post_id=' + postId
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update the like count or change the button appearance
            console.log('Post liked successfully');
        } else {
            console.error('Failed to like post:', data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}
function removeCoverPic() {
    if (confirm('Are you sure you want to remove your cover photo?')) {
        fetch('upload_cover_pic.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'action=remove'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Change the cover photo to the default image
                document.getElementById('coverImage').src = data.default_image;

                // Remove the "Remove Cover Photo" button (optional)
                const removeButton = document.querySelector('.remove-cover');
                if (removeButton) {
                    removeButton.remove();
                }
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while removing the cover photo');
        });
    }
}

    </script>

</body>
</html> 