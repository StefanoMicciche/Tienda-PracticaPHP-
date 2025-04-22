<?php
require_once 'includes/config.php';

// Registrar cierre de sesión en el log
if (isset($_SESSION['username'])) {
    logLoginAttempt($_SESSION['username'], 'LOGOUT');
}

// Eliminar todas las variables de sesión
$_SESSION = array();

// Si se desea destruir completamente la sesión, eliminar también la cookie de sesión
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Eliminar la cookie de "recordarme" si existe
if (isset($_COOKIE['remember_user'])) {
    setcookie('remember_user', '', time() - 3600, '/');
}

// Finalmente, destruir la sesión
session_destroy();

// Mensaje de éxito y redirección
session_start(); // Necesitamos iniciar una nueva sesión para el mensaje
$_SESSION['success_message'] = "Has cerrado sesión correctamente.";
header("Location: index.php");
exit;
?>