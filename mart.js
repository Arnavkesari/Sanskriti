// // Slider functionality for banners and regions
// document.addEventListener('DOMContentLoaded', function() {
//     const sliders = document.querySelectorAll('.slider');
//     sliders.forEach(slider => {
//         slider.addEventListener('wheel', (e) => {
//             e.preventDefault();
//             slider.scrollLeft += e.deltaY;
//         });
//     });
// });
console.log("Hello ");
// Quantity selector in product card functionality
// document.addEventListener('DOMContentLoaded', function() {
//     const quantitySelectors = document.querySelectorAll('.quantity-selector');

//     quantitySelectors.forEach(selector => {
//         const decrementButton = selector.querySelector('.decrement');
//         const incrementButton = selector.querySelector('.increment');
//         const quantityDisplay = selector.querySelector('.quantity');

//         let quantity = parseInt(quantityDisplay.textContent);

//         decrementButton.addEventListener('click', () => {
//             if (quantity > 1) {
//                 quantity--;
//                 quantityDisplay.textContent = quantity;
//             }
//         });

//         incrementButton.addEventListener('click', () => {
//             quantity++;
//             quantityDisplay.textContent = quantity;
//         });
//     });
// });

// banner slider
let currentSlide = 0;
const totalSlides = document.querySelectorAll(".slide").length;
const slidesContainer = document.getElementById("slidesContainer");
const paginationDots = document.querySelectorAll(".dot");

function updateSlidePosition() {
    slidesContainer.style.transform = `translateX(-${currentSlide * 100}vw)`;
    paginationDots.forEach((dot, index) => {
        dot.classList.toggle("active", index === currentSlide);
    });
}

function nextSlide() {
    currentSlide = (currentSlide + 1) % totalSlides;
    updateSlidePosition();
}

function prevSlide() {
    currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
    updateSlidePosition();
}

function goToSlide(slideIndex) {
    currentSlide = slideIndex;
    updateSlidePosition();
}

let slideInterval = setInterval(nextSlide, 5000);

function stopAutoSlide() {
    clearInterval(slideInterval);
    slideInterval = setInterval(nextSlide, 5000);
}

document.querySelector(".slider-nav.left").addEventListener("click", () => {
    prevSlide();
    stopAutoSlide();
});

document.querySelector(".slider-nav.right").addEventListener("click", () => {
    nextSlide();
    stopAutoSlide();
});

paginationDots.forEach((dot, index) => {
    dot.addEventListener("click", () => {
        goToSlide(index);
        stopAutoSlide();
    });
});





// Scroll functions for regions tiles
// Scroll functions
function scrollleft() {
    const container = document.getElementById('regionsContainer');
    if (container) {
        console.log("Scrolling Left"); // Debug message
        container.scrollBy({ left: -200, behavior: 'smooth' });
    } else {
        console.log("Container not found");
    }
}

function scrollRight() {
    const container = document.getElementById('regionsContainer');
    if (container) {
        console.log("Scrolling Right"); // Debug message
        container.scrollBy({ left: 200, behavior: 'smooth' });
    } else {
        console.log("Container not found");
    }
}



// Search functionality
document.getElementById('regionSearch').addEventListener('input', function() {
    const searchText = this.value.toLowerCase();
    const regionTiles = document.querySelectorAll('.region-tile');

    regionTiles.forEach(tile => {
        const regionName = tile.textContent.toLowerCase();
        if (regionName.includes(searchText)) {
            tile.style.display = 'flex';
        } else {
            tile.style.display = 'none';
        }
    });
});

function addToCart(productID) {
    const quantity = document.querySelector(`#quantity-${productID}`).value || 1;

    fetch("mart_add_to_cart.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `productID=${encodeURIComponent(productID)}&quantity=${encodeURIComponent(quantity)}`,
    })
        .then(response => response.text())
        .then(response => {
            if (response === "NOT_LOGGED_IN") {
                alert("Please log in to add products to your cart.");
            } else if (response === "INVALID_REQUEST") {
                alert("Invalid request. Please try again.");
            } else if (response === "INSUFFICIENT_STOCK") {
                alert("The requested quantity is not available.");
            } else if (response === "ADDED_TO_CART") {
                alert("Product successfully added to the cart!");
            } else if (response === "ERROR") {
                alert("An error occurred. Please try again.");
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("Failed to add product to cart. Please try again.");
        });
}

function updateQuantity(button, change) {
    const quantitySpan = button.parentElement.querySelector(".quantity");
    let quantity = parseInt(quantitySpan.textContent);
    quantity = Math.max(1, quantity + change); // Ensure quantity is at least 1
    quantitySpan.textContent = quantity;
}

function addToCart(button) {
    const productID = button.getAttribute("data-product-id");
    const quantity = button.parentElement.querySelector(".quantity").textContent;

    fetch("mart_add_to_cart.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `productID=${productID}&quantity=${quantity}`
    })
    .then(response => response.text())
    .then(data => {
        alert(data); // Show success or error message
    })
    .catch(error => {
        console.error("Error:", error);
    });
}




