<?php
require_once 'includes/config.php';

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $remember = isset($_POST['remember']) ? true : false;
    
    // Validar que los campos no estén vacíos
    if (empty($username) || empty($password)) {
        $_SESSION['error_message'] = "Por favor completa todos los campos.";
        header('Location: login.php');
        exit;
    }
    
    // Verificar las credenciales
    // En un sistema real, esto se haría contra una base de datos con contraseñas hasheadas
    $usuariosFile = DATA_PATH . 'usuarios.txt';
    $loginExitoso = false;
    
    // Verificar si el archivo de usuarios existe
    if (file_exists($usuariosFile)) {
        $usuarios = file($usuariosFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($usuarios as $usuario) {
            $datos = explode('|', $usuario);
            
            if (count($datos) >= 2) {
                $usuarioGuardado = trim($datos[0]);
                $passwordGuardada = trim($datos[1]);
                
                // En un sistema real, verificar la contraseña con password_verify() en lugar de una comparación directa
                if ($username === $usuarioGuardado && $password === $passwordGuardada) {
                    $loginExitoso = true;
                    break;
                }
            }
        }
    }
    
    // Usuario de prueba para demostración
    if ($username === 'demo' && $password === 'demo123') {
        $loginExitoso = true;
    }
    
    // Registrar el intento de login
    logLoginAttempt($username, $loginExitoso ? 'CORRECTO' : 'FALLIDO');
    
    if ($loginExitoso) {
        // Iniciar sesión
        $_SESSION['user_logged_in'] = true;
        $_SESSION['username'] = $username;
        
        // Si se eligió "Recordarme", establecer una cookie
        if ($remember) {
            // En un sistema real, usar un token seguro en lugar del nombre de usuario
            setcookie('remember_user', $username, time() + (86400 * 30), "/"); // 30 días
        }
        
        // Mensaje de éxito
        $_SESSION['success_message'] = "Has iniciado sesión correctamente.";
        
        // Redirigir a la página solicitada o a la página principal
        if (isset($_SESSION['redirect_after_login'])) {
            $redirect = $_SESSION['redirect_after_login'];
            unset($_SESSION['redirect_after_login']);
            header("Location: $redirect");
        } else {
            header("Location: index.php");
        }
    } else {
        // Login fallido
        $_SESSION['error_message'] = "Nombre de usuario o contraseña incorrectos.";
        header("Location: login.php");
    }
    
    exit;
} else {
    // Si se intenta acceder directamente a este script, redirigir al login
    header("Location: login.php");
    exit;
}
?>