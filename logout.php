<?php
require_once __DIR__ . '/includes/media_lib.php';

// Çıkış yalnızca POST + CSRF ile yapılır (başkası bir link ile sizi çıkaramasın)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && csrf_check()) {
    unset($_SESSION['user_id']);
    session_regenerate_id(true);
}
redirect('login.php');
