<?php
    session_start();
    session_destroy();
    echo "<script type='text/javascript'> alert('Logout berhasil'); document.location.href = 'login.php'; </script>";
?>
