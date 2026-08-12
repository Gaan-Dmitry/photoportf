<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $link = $_POST['link'] ?? '';
    $comments = $_POST['comments'] ?? '';

    if ($email && $link) {
        $stmt = $db->prepare("INSERT INTO requests (email, link, comments) VALUES (?, ?, ?)");
        $stmt->execute([$email, $link, $comments]);
    }

    header('Location: /index.php?success=1');
    exit;
} else {
    header('Location: /index.php');
    exit;
}
