<?php
//logout
// after logout will redirect to home page

include '../../init.php';
if(isset($_SESSION)) {
    if(isset($_SESSION['UserID'])) {
        session_destroy();
    }
}
header('Location: '. HOME_URL);
?>