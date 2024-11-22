<!-- index.html -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Indian Cultural Sites</title>
    <link rel="stylesheet" href="homepage.css" />
  </head>
  <body>
    <header>
      <?php include 'header.php'; ?>
    </header>

    <div class="video-section">
      <video autoplay muted loop class="background-video">
        <source
          src="./assets/videos/Welcome to India ! [CINEMATIC TRAVEL FILM]_Full-HD.mp4"
          type="video/mp4"
        />
      </video>
      <div class="overlay">
        <div class="slogan-slider">
          <span id="slogan-text"></span> <!-- Text will be injected by JavaScript -->
        </div>
        <a href="#section" id="read-more" class="view-more">Explore More</a>
      </div>
      <script>
        document.addEventListener("DOMContentLoaded", function () {
        const slogans = [
          "Celebrating India's Rich Culture",
          "Diversity in Every Corner",
          "Experience Timeless Traditions",
          "India: Where Culture Thrives",
          "Discover the Heart of Heritage",
        ];

        let sloganIndex = 0;
        let charIndex = 0;
        const typingSpeed = 100;
        const pauseBetweenSlogans = 2000;
        const sloganText = document.getElementById("slogan-text");

        function typeSlogan() {
          const currentSlogan = slogans[sloganIndex];

          if (charIndex < currentSlogan.length) {
            sloganText.textContent += currentSlogan.charAt(charIndex);
            charIndex++;
            setTimeout(typeSlogan, typingSpeed);
          } else {
            // Pause after completing the slogan, then reset for the next one
            setTimeout(() => {
              sloganText.textContent = ""; // Clear the text
              charIndex = 0; // Reset character index
              sloganIndex = (sloganIndex + 1) % slogans.length; // Move to the next slogan
              typeSlogan(); // Restart the typing effect
            }, pauseBetweenSlogans);
          }
        }

        typeSlogan();
      });


      document.getElementById("read-more").addEventListener("click", function (event) {
        event.preventDefault(); // Prevent the default anchor behavior
        window.scrollTo({
          top: window.innerHeight, // Scroll down to 100vh
          behavior: "smooth", // Enable smooth scrolling
        });
      });

      </script>
    </div>

    <div class="bigcontainer">
      <div class="map-container">
        <div class="map-text">
          <h2>Indian Map with Marked Cultural Sites</h2>
          <br />
          <p>Click on the marker of the states</p>
          <p>to know more about that state</p>
        </div>
        <!-- The image with the usemap attribute -->
        <img src="assets/map/map.jpg" alt="Map of India" usemap="#india-map" />

        <!-- Image map with clickable areas -->
        <map name="india-map">
          <!-- Define an area for each point on the map, matching original image size -->
          <area
            shape="circle"
            coords="84,289,20"
            href="state.php?id=ST104"
            alt="Gujarat"
          />
          <area
            shape="circle"
            coords="173,295,20"
            href="state.php?id=ST102"
            alt="MP"
          />
          <area
            shape="circle"
            coords="238,221,20"
            href="state.php?id=ST101"
            alt="UP"
          />
          <area
            shape="circle"
            coords="129,81,20"
            href="state.php?id=ST103"
            alt="Jammu"
          />
          <area
            shape="circle"
            coords="146,439,20"
            href="state.php?id=ST106"
            alt="Karnataka"
          />
          <area
            shape="circle"
            coords="437,226,20"
            href="state.php?id=ST105"
            alt="Assam"
          />
          <!-- Add more areas as needed -->
        </map>
      </div>
      <section class="cultural-sites" id="cultural-sites">
        <h3>Cultural Sites</h3>
        <div class="sites-grid">
          <!-- Adding uploaded images here -->
          <div class="site-item">
            <a href="state.php?id=ST101"><img src="./assets/cultural_sites/Uttar Pradesh/Taj_Mahal.jpg" alt="Taj Mahal" /></a>
            <p class="hover-text" style="display: none;">Taj Mahal</p>
          </div>
          <div class="site-item">
          <a href="state.php?id=ST106"><img src="./assets/cultural_sites/Karnataka/somanathapura_vishnu_temple.jpg" alt="" /></a>
            <p class="hover-text" style="display: none;">Somanathapura Vishnu Temple</p>
          </div>
          <div class="site-item">
          <a href="state.php?id=ST104"><img src="./assets/cultural_sites/Gujarat/The-Statue-of-Unity.jpg" alt="" /></a>
            <p class="hover-text" style="display: none;">The Statue of Unity</p>
          </div>
        </div>
      </section>

      <section class="artist-products">
        <h3>Local Artist Products</h3>
        <div class="products-grid">
          <div class="product-item">
            <a href="mart.php"><img src="./assets/products/Uttar Pradesh/Silh_Handloom_Banarasi_Saree.jpg" alt="" /></a>
            <p class="hover-text" style="display: none;">Handloom Banarasi Saree</p>
          </div>
          <div class="product-item">
            <a href="mart.php"><img src="./assets/products/Karnataka/Channapatna_Toys.jpg" alt="" /></a>
            <p class="hover-text" style="display: none;">Channapatna Toys</p>
          </div>
          <div class="product-item">
            <a href="mart.php"><img src="./assets/products/Assam/ThangkaPaintings.jpg" alt="" /></a>
            <p class="hover-text" style="display: none;">Thangka Paintings</p>
          </div>
          <div class="product-item">
            <a href="mart.php"><img src="./assets/products/Karnataka/Rosewood_decorative.jpg" alt="" /></a>
            <p class="hover-text" style="display: none;">Rosewood Decorative</p>
          </div>
        </div>
        
      </section>
      <script>
        document.querySelectorAll('.product-item').forEach(item => {
          item.addEventListener('mouseover', () => {
            item.querySelector('.hover-text').style.display = 'block';
          });
          item.addEventListener('mouseout', () => {
            item.querySelector('.hover-text').style.display = 'none';
          });
        });
      </script>
      <script>
        document.querySelectorAll('.site-item').forEach(item => {
          item.addEventListener('mouseover', () => {
            item.querySelector('.hover-text').style.display = 'block';
          });
          item.addEventListener('mouseout', () => {
            item.querySelector('.hover-text').style.display = 'none';
          });
        });
      </script>
    </div>

    <footer>
      <?php include 'footer.php'; ?>
    </footer>
  </body>
</html>