<?php
require_once 'includes/config.php';

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener y filtrar los datos del formulario
    $nombre = isset($_POST['nombre']) ? trim(filter_var($_POST['nombre'], FILTER_SANITIZE_STRING)) : '';
    $username = isset($_POST['username']) ? trim(filter_var($_POST['username'], FILTER_SANITIZE_STRING)) : '';
    $email = isset($_POST['email']) ? trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL)) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';
    $terms = isset($_POST['terms']) ? true : false;
    
    // Validar los datos
    $errores = [];
    
    if (empty($nombre)) {
        $errores[] = "El nombre completo es obligatorio.";
    }
    
    if (empty($username)) {
        $errores[] = "El nombre de usuario es obligatorio.";
    } elseif (strlen($username) < 3) {
        $errores[] = "El nombre de usuario debe tener al menos 3 caracteres.";
    }
    
    if (empty($email)) {
        $errores[] = "El correo electrónico es obligatorio.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El formato del correo electrónico no es válido.";
    }
    
    if (empty($password)) {
        $errores[] = "La contraseña es obligatoria.";
    } elseif (strlen($password) < 6) {
        $errores[] = "La contraseña debe tener al menos 6 caracteres.";
    }
    
    if ($password !== $confirm_password) {
        $errores[] = "Las contraseñas no coinciden.";
    }
    
    if (!$terms) {
        $errores[] = "Debes aceptar los términos y condiciones.";
    }
    
    // Verificar si el usuario ya existe
    $usuariosFile = DATA_PATH . 'usuarios.txt';
    $usuarioExiste = false;
    
    if (file_exists($usuariosFile)) {
        $usuarios = file($usuariosFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        
        foreach ($usuarios as $usuario) {
            $datos = explode('|', $usuario);
            
            if (count($datos) >= 3) {
                $usuarioGuardado = trim($datos[0]);
                $emailGuardado = trim($datos[2]);
                
                if ($username === $usuarioGuardado) {
                    $errores[] = "El nombre de usuario ya está en uso.";
                    $usuarioExiste = true;
                    break;
                }
                
                if ($email === $emailGuardado) {
                    $errores[] = "El correo electrónico ya está registrado.";
                    $usuarioExiste = true;
                    break;
                }
            }
        }
    }
    
    // Si hay errores, mostrar mensaje y redirigir
    if (!empty($errores)) {
        $_SESSION['error_message'] = implode("<br>", $errores);
        header("Location: registro.php");
        exit;
    }
    
    // En un sistema real, habría que hashear la contraseña
    // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Crear el archivo de usuarios si no existe
    if (!file_exists(dirname($usuariosFile))) {
        mkdir(dirname($usuariosFile), 0777, true);
    }
    
    // Guardar el nuevo usuario
    $nuevoUsuario = $username . '|' . $password . '|' . $email . '|' . $nombre . "\n";
    file_put_contents($usuariosFile, $nuevoUsuario, FILE_APPEND);
    
    // Registrar el evento
    logLoginAttempt($email, 'REGISTRO');
    
    // Iniciar sesión automáticamente
    $_SESSION['user_logged_in'] = true;
    $_SESSION['username'] = $username;
    
    // Mensaje de éxito y redirección
    $_SESSION['success_message'] = "¡Registro completado con éxito! Bienvenido/a a " . SITE_NAME;
    
    // Redirigir a la página solicitada o a la página principal
    if (isset($_SESSION['redirect_after_login'])) {
        $redirect = $_SESSION['redirect_after_login'];
        unset($_SESSION['redirect_after_login']);
        header("Location: $redirect");
    } else {
        header("Location: index.php");
    }
    
    exit;
} else {
    // Si se intenta acceder directamente a este script, redirigir
    header("Location: registro.php");
    exit;
}
?>