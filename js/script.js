// Script para inicializar y gestionar el comportamiento del carrusel
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar el carrusel con un intervalo de 5 segundos
    const myCarousel = document.getElementById('mainCarousel');
    if (myCarousel) {
        const carousel = new bootstrap.Carousel(myCarousel, {
            interval: 5000,
            pause: 'hover'
        });
    }
    
    // Validación del formulario de contacto
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function(event) {
            if (!contactForm.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            
            contactForm.classList.add('was-validated');
        });
    }
    
    // Validación del formulario de login
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function(event) {
            if (!loginForm.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            
            loginForm.classList.add('was-validated');
        });
    }
    
    // Efecto hover en las tarjetas de productos
    const productCards = document.querySelectorAll('.product-card');
    productCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            const buyButton = this.querySelector('.btn-buy');
            if (buyButton) {
                buyButton.classList.add('btn-lg');
            }
        });
        
        card.addEventListener('mouseleave', function() {
            const buyButton = this.querySelector('.btn-buy');
            if (buyButton) {
                buyButton.classList.remove('btn-lg');
            }
        });
    });
    
    // Botones de cantidad para productos
    const quantityBtns = document.querySelectorAll('.quantity-btn');
    quantityBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.parentNode.querySelector('input[type="number"]');
            const currentValue = parseInt(input.value);
            
            if (this.classList.contains('quantity-minus') && currentValue > 1) {
                input.value = currentValue - 1;
            } else if (this.classList.contains('quantity-plus')) {
                input.value = currentValue + 1;
            }
            
            // Disparar evento de cambio para que se actualicen otros elementos
            const event = new Event('change');
            input.dispatchEvent(event);
        });
    });
});