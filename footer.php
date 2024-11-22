<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Ensure full height for the page */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        /* Flexbox layout for footer positioning */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100%;
        }

        .content {
            flex-grow: 1; /* Let the content take available space */
            width: 100%;
        }

        .footer {
            background-color: #000000; /* Dark background for the footer */
            color: #fff; /* White text for readability */
            padding: 20px;
            display: flex;
            justify-content: space-around;
            align-items: flex-start;
            flex-wrap: wrap;
            text-align: left;
            font-family: Arial, sans-serif;
        }

        .footer-section {
            flex: 1;
            padding: 0 1rem;
            min-width: 200px;
        }

        .footer-section h3 {
            color: #4CAF50; /* Green for headings */
            margin-bottom: 1rem;
        }

        .footer-section p {
            color: #ddd; /* Light gray for description text */
            margin-top: 0.5rem;
            font-size: 0.9rem;
        }

        .footer-section ul {
            list-style: none;
            padding: 0;
        }

        .footer-section ul li {
            margin-bottom: 0.5rem;
        }

        .footer-section ul li a {
            text-decoration: none;
            color: #ddd; /* Light gray links */
            transition: color 0.3s;
        }

        .footer-section ul li a:hover {
            color: #007bff; /* Blue color on hover */
        }

        /* Logo Styling */
        .footer-logo {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .footer-logo img {
            width: 250px; /* Adjusted large logo size */
            height: auto;
            margin-bottom: 0.5rem;
            margin-left: 40px;
        }

        .footer-logo h2 {
            color: #4CAF50;
            font-size: 1.5rem;
            margin-top: 0.5rem;
        }

        /* Bottom Bar Styling */
        .footer-bottom {
            background-color: #6c2c02; /* Orange bottom strip */
            color: white;
            text-align: center;
            padding: 1rem;
            font-size: 1rem;
        }

        .footer-bottom a {
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="content">
        <!-- Your main content goes here -->
    </div>

    <!-- Footer Section -->
    <footer>
        <div class="footer">
            <!-- Logo Section on the Left -->
            <div class="footer-logo">
                <img src="sanskriti_logo.jpeg" alt="Sanskriti Logo"> <!-- Update the path to your logo image -->
            </div>

            <!-- Footer Sections -->
            <div class="footer-section">
                <h3>Discover India's Soul</h3>
                <ul>
                    <li><a href="https://en.wikipedia.org/wiki/List_of_geographical_indications_in_India">Indian GI Tags</a></li>
                    <li><a href="https://whc.unesco.org/en/statesparties/in">Incredible India</a></li>
                    <li><a href="https://www.indiaculture.gov.in/">Ministry of Culture</a></li>
                    <li><a href="https://swachhbharatmission.ddws.gov.in/">Swachh Bharat</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Visit For More</h3>
                <ul>
                    <li><a href="https://www.india.gov.in/">My Government</a></li>
                    <li><a href="https://www.digitalindia.gov.in/">Digital India</a></li>
                    <li><a href="https://tourism.gov.in/">Ministry of Tourism</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Contact Us</h3>
                <ul>
                    <li>Kartik</li>
                    <li>Arnav</li>
                    <li>Ankit</li>
                    <li>Aryan</li>
                    <li>Himanshu</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            Developed by Kartik, Arnav, Ankit, Aryan, and Himanshu as part of our DBMS project;
        </div>
    </footer>
</body>
</html>
