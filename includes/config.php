<?php
// Iniciar sesión
session_start();

// Definir constantes
define('SITE_NAME', 'FashionShop');
define('ADMIN_EMAIL', 'yo_victor@yahoo.es');
define('DATA_PATH', __DIR__ . '/../data/');
define('LOGS_PATH', DATA_PATH . 'logs/');

// Crear directorios si no existen
if (!file_exists(DATA_PATH)) {
    mkdir(DATA_PATH, 0777, true);
}

if (!file_exists(LOGS_PATH)) {
    mkdir(LOGS_PATH, 0777, true);
}

// Función para comprobar si el usuario está logueado
function isLoggedIn() {
    return isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true;
}

// Función para registrar intentos de login
function logLoginAttempt($username, $success) {
    $logFile = LOGS_PATH . 'login_attempts.log';
    $timestamp = date('Y-m-d H:i:s');
    $status = $success ? 'CORRECTO' : 'FALLIDO';
    
    $logEntry = "$timestamp | $username | $status\n";
    file_put_contents($logFile, $logEntry, FILE_APPEND);
}

// Función para redireccionar si el usuario no está logueado
function requireLogin() {
    if (!isLoggedIn()) {
        $_SESSION['error_message'] = "Debe iniciar sesión para acceder a esta página.";
        $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
        header("Location: login.php");
        exit;
    }
}

// Función para cargar productos desde archivos
function loadProducts($category) {
    $filename = DATA_PATH . "productos_$category.txt";
    $products = [];
    
    if (file_exists($filename)) {
        $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($lines as $line) {
            $data = explode('|', $line);
            if (count($data) >= 6) {
                $products[] = [
                    'id' => trim($data[0]),
                    'name' => trim($data[1]),
                    'description' => trim($data[2]),
                    'price' => floatval(trim($data[3])),
                    'image' => trim($data[4]),
                    'discount' => isset($data[5]) ? intval(trim($data[5])) : 0
                ];
            }
        }
    }
    
    return $products;
}

// Función para mostrar mensajes flash
function displayMessage() {
    $output = '';
    
    if (isset($_SESSION['success_message'])) {
        $output .= '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
        unset($_SESSION['success_message']);
    }
    
    if (isset($_SESSION['error_message'])) {
        $output .= '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
        unset($_SESSION['error_message']);
    }
    
    return $output;
}