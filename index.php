<?php
session_start();
if (empty($_SESSION['logado']) || $_SESSION['logado'] == false) {
    header('location: VIEWS/loginPg.php');
}
if (!empty($_SESSION['logado'])) {
    header('location: VIEWS/profilePg.php');
}
?>