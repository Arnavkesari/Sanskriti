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
