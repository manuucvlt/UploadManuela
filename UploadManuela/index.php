<?php
session_start();
header('Location: ' . (isset($_SESSION['id_usuario']) ? 'principal.php' : 'login.php'));
exit();