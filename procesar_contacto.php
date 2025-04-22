<?php
require_once 'includes/config.php';

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener y filtrar los datos del formulario
    $nombre = isset($_POST['nombre']) ? trim(filter_var($_POST['nombre'], FILTER_SANITIZE_STRING)) : '';
    $email = isset($_POST['email']) ? trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL)) : '';
    $telefono = isset($_POST['telefono']) ? trim(filter_var($_POST['telefono'], FILTER_SANITIZE_STRING)) : '';
    $asunto = isset($_POST['asunto']) ? trim(filter_var($_POST['asunto'], FILTER_SANITIZE_STRING)) : '';
    $mensaje = isset($_POST['mensaje']) ? trim(filter_var($_POST['mensaje'], FILTER_SANITIZE_STRING)) : '';
    
    // Validar los datos
    $errores = [];
    
    if (empty($nombre)) {
        $errores[] = "El nombre es obligatorio.";
    }
    
    if (empty($email)) {
        $errores[] = "El correo electrónico es obligatorio.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El formato del correo electrónico no es válido.";
    }
    
    if (empty($asunto)) {
        $errores[] = "El asunto es obligatorio.";
    }
    
    if (empty($mensaje)) {
        $errores[] = "El mensaje es obligatorio.";
    }
    
    // Si hay errores, mostrar mensaje y redirigir
    if (!empty($errores)) {
        $_SESSION['error_message'] = implode("<br>", $errores);
        header("Location: contacto.php");
        exit;
    }
    
    // Preparar el correo
    $destinatario = ADMIN_EMAIL;
    $asuntoEmail = "Contacto web: " . $asunto;
    
    // Construir el cuerpo del mensaje
    $cuerpoEmail = "Has recibido un nuevo mensaje desde el formulario de contacto de tu sitio web.\n\n";
    $cuerpoEmail .= "Nombre: " . $nombre . "\n";
    $cuerpoEmail .= "Email: " . $email . "\n";
    
    if (!empty($telefono)) {
        $cuerpoEmail .= "Teléfono: " . $telefono . "\n";
    }
    
    $cuerpoEmail .= "Asunto: " . $asunto . "\n\n";
    $cuerpoEmail .= "Mensaje:\n" . $mensaje . "\n";
    
    // Cabeceras del correo
    $cabeceras = "From: " . $email . "\r\n";
    $cabeceras .= "Reply-To: " . $email . "\r\n";
    $cabeceras .= "X-Mailer: PHP/" . phpversion();
    
    // Intentar enviar el correo
    $envioExitoso = mail($destinatario, $asuntoEmail, $cuerpoEmail, $cabeceras);
    
    // Guardar el mensaje en un archivo de log (alternativa al email)
    $mensajeLog = "Fecha: " . date('Y-m-d H:i:s') . "\n";
    $mensajeLog .= "Nombre: " . $nombre . "\n";
    $mensajeLog .= "Email: " . $email . "\n";
    if (!empty($telefono)) {
        $mensajeLog .= "Teléfono: " . $telefono . "\n";
    }
    $mensajeLog .= "Asunto: " . $asunto . "\n";
    $mensajeLog .= "Mensaje: " . $mensaje . "\n";
    $mensajeLog .= "------------------------------------------------\n\n";
    
    $logFile = DATA_PATH . 'contactos.log';
    file_put_contents($logFile, $mensajeLog, FILE_APPEND);
    
    // Redirigir con mensaje de éxito o error
    if ($envioExitoso) {
        $_SESSION['success_message'] = "Tu mensaje ha sido enviado correctamente. Nos pondremos en contacto contigo lo antes posible.";
    } else {
        // Aún si el email falla, tenemos el log como respaldo
        $_SESSION['success_message'] = "Tu mensaje ha sido recibido. Nos pondremos en contacto contigo lo antes posible.";
    }
    
    header("Location: contacto.php");
    exit;
} else {
    // Si se intenta acceder directamente a este script, redirigir
    header("Location: contacto.php");
    exit;
}
?>