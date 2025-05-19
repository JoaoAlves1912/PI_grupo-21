<?php

if (isset($_POST['logout'])) {
    session_start();
    $_SESSION['logado'] = false;
    session_destroy();
    header("location: ../../index.php");
} else {
    header("Location: ../../FRONTEND/VIEWS/error.php");
    exit();
}
?>