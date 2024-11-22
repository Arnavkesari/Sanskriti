document.addEventListener('DOMContentLoaded', function() {
    // Slider functionality for banners and regions
    const sliders = document.querySelectorAll('.slider');
    sliders.forEach(slider => {
        slider.addEventListener('wheel', (e) => {
            e.preventDefault();
            slider.scrollLeft += e.deltaY;
        });
    });

    // Event listener for state selection
    const regionTiles = document.querySelectorAll('.region-tile');
    regionTiles.forEach(tile => {
        tile.addEventListener('click', () => {
            const stateName = tile.textContent.trim();
            fetchProductsByState(stateName);
        });
    });

    // function fetchProductsByState(stateName) {
    //     fetch(`fetch_products_by_state.php?state=${encodeURIComponent(stateName)}`)
    //         .then(response => response.text())
    //         .then(data => {
    //             const productGrid = document.querySelector('.product-grid');
    //             productGrid.innerHTML = data;
    //         })
    //         .catch(error => {
    //             console.error("Error fetching products:", error);
    //         });
    // }
});

// Quantity selector in product card functionality
document.addEventListener('DOMContentLoaded', function() {
    const quantitySelectors = document.querySelectorAll('.quantity-selector');

    quantitySelectors.forEach(selector => {
        const decrementButton = selector.querySelector('.decrement');
        const incrementButton = selector.querySelector('.increment');
        const quantityDisplay = selector.querySelector('.quantity');

        let quantity = parseInt(quantityDisplay.textContent);

        decrementButton.addEventListener('click', () => {
            if (quantity > 1) {
                quantity--;
                quantityDisplay.textContent = quantity;
            }
        });

        incrementButton.addEventListener('click', () => {
            quantity++;
            quantityDisplay.textContent = quantity;
        });
    });
});

// Other functionality unchanged

document.addEventListener('DOMContentLoaded', function () {
    // Quantity selector functionality
    const quantitySelectors = document.querySelectorAll('.quantity-selector');
    quantitySelectors.forEach(selector => {
        const decrementButton = selector.querySelector('.decrement');
        const incrementButton = selector.querySelector('.increment');
        const quantityDisplay = selector.querySelector('.quantity');

        let quantity = parseInt(quantityDisplay.textContent);

        decrementButton.addEventListener('click', () => {
            if (quantity > 1) {
                quantity--;
                quantityDisplay.textContent = quantity;
            }
        });

        incrementButton.addEventListener('click', () => {
            quantity++;
            quantityDisplay.textContent = quantity;
        });
    });

    // Add to Cart functionality
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function () {
            const productCard = this.closest('.product-card');
            const productId = this.getAttribute('data-product-id');
            const quantity = productCard.querySelector('.quantity').textContent;

            fetch('add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ productId, quantity })
            })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                })
                .catch(error => {
                    console.error("Error adding product to cart:", error);
                });
        });
    });
});
