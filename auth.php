<?php
session_start();
require_once __DIR__ . '/../config/database.php';

function cek_login() {
    if (empty($_SESSION['admin_id'])) {
        header('Location: login.php');
        exit;
    }
}
