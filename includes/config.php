<?php
$con = mysqli_connect("localhost","root","","social_media_db");

// Check connection
if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if friends table exists, if not create it

?>