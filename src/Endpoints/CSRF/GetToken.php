<?php
//Get the current CSRF token from session
if (isset($_SESSION['csrf_token'])) {
    echo json_encode(['csrf_token' => $_SESSION['csrf_token']]);
} else {
    echo json_encode(['csrf_token' => null]);
}
