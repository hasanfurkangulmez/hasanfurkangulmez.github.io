<?php
session_start();

$data = file_get_contents('chat.json');
$messages = json_decode($data, true);

function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
    $message = $_POST['message'];
    $computerName = $_POST['computerName'];
    $ipAddress = getUserIP();
    $messages[] = [
        'id' => uniqid(),
        'message' => $message,
        'computerName' => $computerName,
        'ipAddress' => $ipAddress
    ];
    file_put_contents('chat.json', json_encode($messages));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteId']) && isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
    $deleteId = $_POST['deleteId'];
    $messages = array_filter($messages, function($msg) use ($deleteId) {
        return $msg['id'] !== $deleteId;
    });
    file_put_contents('chat.json', json_encode(array_values($messages)));
}

echo json_encode($messages);
?>