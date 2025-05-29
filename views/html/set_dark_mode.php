<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (isset($data['dark_mode'])) {
        $_SESSION['dark_mode'] = (bool)$data['dark_mode'];
        echo json_encode(['success' => true]);
        exit();
    }
}

echo json_encode(['success' => false]);
?>