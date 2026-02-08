<?php
session_start();
header('Content-Type: application/json');
echo json_encode(['session_works' => true, 'user_id' => $_SESSION['user_id'] ?? 'none']);
exit;
