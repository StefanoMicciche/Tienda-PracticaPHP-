<?php
$pageTitle = "Inicio";
require_once 'includes/header.php';
?>

<!-- Carrusel / Slider principal -->
<div id="mainCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="img/slider1.jpg" class="d-block w-100" alt="Nueva colección de verano">
            <div class="carousel-caption d-none d-md-block">
                <h2>Nueva Colección Verano</h2>
                <p>Descubre las últimas tendencias para esta temporada</p>
                <a href="mujer.php" class="btn btn-primary">Ver colección</a>
            </div>
        </div>
        <div class="carousel-item">
            <img src="img/slider2.jpg" class="d-block w-100" alt="Moda masculina">
            <div class="carousel-caption d-none d-md-block">
                <h2>Moda Masculina</h2>
                <p>Elegancia y confort en cada prenda</p>
                <a href="hombre.php" class="btn btn-primary">Explorar</a>
            </div>
        </div>
        <div class="carousel-item">
            <img src="img/slider3.jpg" class="d-block w-100" alt="Ofertas especiales">
            <div class="carousel-caption d-none d-md-block">
                <h2>Ofertas Especiales</h2>
                <p>Hasta 50% de descuento en productos seleccionados</p>
                <a href="ofertas.php" class="btn btn-primary">Ver ofertas</a>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Anterior</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Siguiente</span>
    </button>
</div>

<!-- Categorías destacadas -->
<section class="mb-5">
    <h2 class="text-center mb-4">Categorías Destacadas</h2>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100">
                <img src="img/categoria-mujer.jpg" class="card-img-top" alt="Moda Mujer">
                <div class="card-body text-center">
                    <h3 class="card-title">Mujer</h3>
                    <p class="card-text">Descubre nuestra colección de moda femenina con las últimas tendencias.</p>
                    <a href="mujer.php" class="btn btn-primary">Ver productos</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <img src="img/categoria-hombre.jpg" class="card-img-top" alt="Moda Hombre">
                <div class="card-body text-center">
                    <h3 class="card-title">Hombre</h3>
                    <p class="card-text">Explora nuestra selección de moda masculina para todas las ocasiones.</p>
                    <a href="hombre.php" class="btn btn-primary">Ver productos</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <img src="img/categoria-ofertas.jpg" class="card-img-top" alt="Ofertas Especiales">
                <div class="card-body text-center">
                    <h3 class="card-title">Ofertas</h3>
                    <p class="card-text">Aprovecha nuestros descuentos en productos seleccionados.</p>
                    <a href="ofertas.php" class="btn btn-primary">Ver ofertas</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Productos destacados -->
<section class="mb-5">
    <h2 class="text-center mb-4">Productos Destacados</h2>
    
    <?php if (isLoggedIn()): ?>
        <div class="row g-4">
            <?php
            // Cargar productos destacados de diferentes categorías
            $productosDestacados = array_merge(
                array_slice(loadProducts('mujer'), 0, 2),
                array_slice(loadProducts('hombre'), 0, 2),
                array_slice(loadProducts('ofertas'), 0, 2)
            );
            
            // Mostrar los productos
            foreach ($productosDestacados as $producto):
                $precioFinal = $producto['price'];
                $tieneDescuento = false;
                
                if ($producto['discount'] > 0) {
                    $tieneDescuento = true;
                    $precioFinal = $producto['price'] * (1 - $producto['discount'] / 100);
                }
            ?>
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="card product-card">
                    <div class="product-image">
                        <img src="img/productos/<?php echo htmlspecialchars($producto['image']); ?>" alt="<?php echo htmlspecialchars($producto['name']); ?>">
                        <?php if ($tieneDescuento): ?>
                            <span class="product-badge"><?php echo $producto['discount']; ?>% OFF</span>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($producto['name']); ?></h5>
                        <p class="card-text small"><?php echo htmlspecialchars($producto['description']); ?></p>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <?php if ($tieneDescuento): ?>
                                    <span class="product-price-old me-2">€<?php echo number_format($producto['price'], 2); ?></span>
                                <?php endif; ?>
                                <span class="product-price">€<?php echo number_format($precioFinal, 2); ?></span>
                            </div>
                        </div>
                        <button class="btn btn-buy w-100">Comprar</button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="card bg-light p-4 text-center">
            <div class="card-body">
                <h4>Inicia sesión para ver nuestros productos</h4>
                <p>Para acceder a nuestro catálogo de productos, por favor inicia sesión o regístrate.</p>
                <div>
                    <a href="login.php" class="btn btn-primary me-2">Iniciar sesión</a>
                    <a href="registro.php" class="btn btn-outline-primary">Registrarse</a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</section>

<!-- Banner promocional -->
<section class="bg-primary text-white p-4 mb-5 rounded">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h3>¡Suscríbete a nuestra newsletter!</h3>
            <p class="mb-md-0">Recibe las últimas novedades y ofertas exclusivas directamente en tu correo.</p>
        </div>
        <div class="col-md-4">
            <form class="d-flex">
                <input class="form-control me-2" type="email" placeholder="Tu email" aria-label="Email">
                <button class="btn btn-light" type="submit">Suscribir</button>
            </form>
        </div>
    </div>
</section>

<?php
require_once 'includes/footer.php';
?>