<?php
// login.php
session_start();

$adminUsername = 'admin';
$adminPassword = 'password'; // Güçlü bir şifre kullanın

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
    if ($_POST['username'] === $adminUsername && $_POST['password'] === $adminPassword) {
        $_SESSION['authenticated'] = true;
        header('Location: index.html');
    } else {
        echo 'Invalid credentials';
    }
}
?>