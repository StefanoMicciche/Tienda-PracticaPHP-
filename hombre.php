<?php
$pageTitle = "Moda Hombre";
require_once 'includes/header.php';

// Verificar si el usuario está logueado
if (!isLoggedIn()) {
    requireLogin();
}

// Cargar productos de hombre
$productos = loadProducts('hombre');
?>

<div class="row mb-4">
    <div class="col-md-12">
        <h1 class="mb-3">Moda Hombre</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Hombre</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-12">
        <div class="card bg-light">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="mb-2">Colección Hombre</h4>
                        <p class="mb-md-0">Explora nuestra selección de moda masculina con las prendas más actuales y de mejor calidad.</p>
                    </div>
                    <div class="col-md-4 d-flex justify-content-md-end mt-3 mt-md-0">
                        <div class="input-group">
                            <label class="input-group-text" for="ordenProductos">Ordenar por:</label>
                            <select class="form-select" id="ordenProductos">
                                <option value="destacados">Destacados</option>
                                <option value="precio-asc">Precio: de menor a mayor</option>
                                <option value="precio-desc">Precio: de mayor a menor</option>
                                <option value="nombre">Nombre</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <?php if (count($productos) > 0): ?>
        <?php foreach ($productos as $producto): ?>
            <?php
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
                        <a href="producto.php?id=<?php echo $producto['id']; ?>&cat=hombre" class="btn btn-outline-primary mb-2 w-100">Ver detalles</a>
                        <button class="btn btn-buy w-100">Comprar</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12">
            <div class="alert alert-info">
                No se encontraron productos en esta categoría. Vuelve pronto para ver nuestras novedades.
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
require_once 'includes/footer.php';
?>