<?php
$pageTitle = "Iniciar Sesión";
require_once 'includes/header.php';

// Si el usuario ya está logueado, redirigir a la página principal
if (isLoggedIn()) {
    header("Location: index.php");
    exit;
}
?>

<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card auth-form shadow-sm">
            <div class="card-body p-4">
                <h2 class="card-title text-center mb-4">Iniciar Sesión</h2>
                
                <form id="loginForm" action="procesar_login.php" method="POST" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="username" class="form-label">Nombre de usuario</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                        <div class="invalid-feedback">
                            Por favor ingresa tu nombre de usuario.
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                        <div class="invalid-feedback">
                            Por favor ingresa tu contraseña.
                        </div>
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Recordarme</label>
                    </div>
                    
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary btn-lg">Iniciar Sesión</button>
                    </div>
                    
                    <div class="text-center">
                        <a href="recuperar_password.php">¿Olvidaste tu contraseña?</a>
                    </div>
                </form>
            </div>
            <div class="card-footer bg-light p-3 text-center">
                <p class="mb-0">¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a></p>
            </div>
        </div>
        
        <!-- Información de usuario demo -->
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">¿Quieres probar la aplicación?</h5>
                <p class="card-text">Puedes utilizar las siguientes credenciales de demostración:</p>
                <ul class="mb-0">
                    <li><strong>Usuario:</strong> demo</li>
                    <li><strong>Contraseña:</strong> demo123</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php
require_once 'includes/footer.php';
?>