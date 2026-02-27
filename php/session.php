<?php
// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$unique_id = $_SESSION['unique_id'] ?? null;
