<?php
session_start();
if (empty($_SESSION['logado']) || $_SESSION['logado'] == false) {
    header('location: FRONTEND/VIEWS/loginPg.php');
}
if (!empty($_SESSION['logado'])) {
    header('location: FRONTEND/VIEWS/profilePg.php');
}
?>