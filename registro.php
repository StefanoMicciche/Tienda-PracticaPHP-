<?php
$pageTitle = "Registro";
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
                <h2 class="card-title text-center mb-4">Crear una cuenta</h2>
                
                <form id="registroForm" action="procesar_registro.php" method="POST" class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre completo</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                        <div class="invalid-feedback">
                            Por favor ingresa tu nombre completo.
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="username" class="form-label">Nombre de usuario</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                        <div class="invalid-feedback">
                            Por favor elige un nombre de usuario.
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                        <div class="invalid-feedback">
                            Por favor ingresa un correo electrónico válido.
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required minlength="6">
                        <div class="invalid-feedback">
                            La contraseña debe tener al menos 6 caracteres.
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirmar contraseña</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        <div class="invalid-feedback">
                            Las contraseñas no coinciden.
                        </div>
                    </div>
                    
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                        <label class="form-check-label" for="terms">
                            Acepto los <a href="terminos.php">términos y condiciones</a> y la <a href="privacidad.php">política de privacidad</a>.
                        </label>
                        <div class="invalid-feedback">
                            Debes aceptar los términos y condiciones para registrarte.
                        </div>
                    </div>
                    
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary btn-lg">Crear cuenta</button>
                    </div>
                </form>
            </div>
            <div class="card-footer bg-light p-3 text-center">
                <p class="mb-0">¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a></p>
            </div>
        </div>
    </div>
</div>

<script>
// Validación personalizada para que las contraseñas coincidan
document.addEventListener('DOMContentLoaded', function() {
    const registroForm = document.getElementById('registroForm');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    
    registroForm.addEventListener('submit', function(event) {
        if (password.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity("Las contraseñas no coinciden");
        } else {
            confirmPassword.setCustomValidity("");
        }
        
        if (!registroForm.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
        }
        
        registroForm.classList.add('was-validated');
    });
    
    // Limpiar el mensaje de error cuando el usuario cambie el valor
    confirmPassword.addEventListener('input', function() {
        if (password.value === confirmPassword.value) {
            confirmPassword.setCustomValidity("");
        } else {
            confirmPassword.setCustomValidity("Las contraseñas no coinciden");
        }
    });
});
</script>

<?php
require_once 'includes/footer.php';
?>