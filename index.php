<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital@0;1&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto:ital,wght@0,600;1,600&display=swap" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <nav class="nav">
        <div class="logo">
            <img class="icon" src="Images/iconlogo.png" alt="logo">
            TechAthletics</div>
            <a href="#" class="mobile-view">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span> 
            </a>
        <div class="navbar-links">
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Contact Us</a></li>
                <li><a href="#">About Us</a></li>
                <div class="registration">
                    <a href="login.php" class="btnRegistration btnLog-in">Log In</a>
                    <a href="signup.php" class="btnRegistration btnSign-up">Sign Up</a>
                </div>
            </ul>
        </div>
    </nav>

    <section class="hero">
        <div class="hero-image">
        <div class="hero-content">
        <h1 class="hero-title">Manage Your Digital Fitness With Ease</h1>
        <p class="hero-subtext">Let TechAthletics ease the unnecessary admin work, from the bookings to the finance so you can focus on transforming customers fitness.</p>
        <button class="hero-button">Get started free</button>
    </div>
    </div>
    </section>

    <section class="social-proof">
        <h1 class="social-proof-title">Trusted By Everyone</h1>
        <p class="social-proof-text">Don't miss out on your chance to match your competitors who rely on us to ease their work flow and make them productive</p>
    <div class="social-proof-section">
        <div class="item">
            <div class="item-text">12,000+</div>
            <div class="item-title">Active Users</div>
        </div>

        <div class="item">
            <div class="item-text">1000+</div>
            <div class="item-title">Businesses</div>
        </div>

        <div class="item">
            <div class="item-text">4.6/50</div>
            <div class="item-title">Average Rating</div>
        </div>
    </div>
    </section>

    <section class="features">
        <h1 class="features-title">Our Features</h1>
        <div class="features-cards">
            <div class="feature-card">
                <div class="card-icon">
                    <img src="Images/users.png" class="icons" alt="Users">
                </div>
                <p class="card-title">User Roles</p>
                <p class="card-subtext">Different types of users access different parts of the system.</p>
                <p class="card-description">Each user can manage their clients, bookings and appointments, and we are working hard to expand this feature into "Teams", the user has their own account for security purposes.</p>
            </div>

            <div class="feature-card">
                <div class="card-icon">
                    <img src="Images/servicesicon.png" class="icons" alt="Services">
                </div>
                <p class="card-title">Services Management</p>
                <p class="card-subtext">Business owners list the services they offer</p>
                <p class="card-description">The business owner can add new services, change prices and durations, as well as edit their services according to their needs.</p>
            </div>

            <div class="feature-card">
                <div class="card-icon">
                    <img src="Images/book.png" class="icons" alt="Bookings">
                </div>
                <p class="card-title">Booking System</p>
                <p class="card-subtext">Clients can book appointments for services</p>
                <p class="card-description">You can now schedule and view bookings, as well as edit details about the booking, making you more productive to focus on what matters most to you.</p>
            </div>

            <div class="feature-card">
                <div class="card-icon">
                    <img src="Images/clientsicon.png" class="icons" alt="Clients">
                </div>
                <p class="card-title">Client Management</p>
                <p class="card-subtext">Business owners can keep track of their customers</p>
                <p class="card-description">Business owners can manage their clients and view clients information to keep in touch to avoid unnecessary disagreements.</p>
            </div>

            <div class="feature-card">
                <div class="card-icon">
                    <img src="Images/invoicesicon.png" class="icons" alt="Invoices">
                </div>
                <p class="card-title">Invoice Generation</p>
                <p class="card-subtext">Create and send invoices to clients</p>
                <p class="card-description">Invoice management has just got easier, create invoices according to the service you offer. After job completion, invoices will be automatically generated and sent to the client.</p>
            </div>

            <div class="feature-card">
                <div class="card-icon">
                    <img src="Images/dashboardicons.png" class="icons" alt="Dashboard">
                </div>
                <p class="card-title">Dashboard</p>
                <p class="card-subtext">An overview and summary of business activity</p>
                <p class="card-description">Sometimes you get tired reviewing all the data, thats why business owners can view their total clients, bookings and revenue monthly and view upcoming bookings.</p>
            </div>
        </div>
    </section>

    <section class="banner">
        <div class="banner-wrapper">
        <div class="banner-image">
            <img class="bannerimages" src="Images/computerimage.jpg" alt="Person using computer">
        </div>
        <div class="banner-text">
            <h2 class="banner-title">Digital Fitness For You</h2>
            <p class="banner-subtext"><span><img class="tick-image" src="Images/tick.png" alt="approve"></span>Seamless intergration on all devices</p>
            <p class="banner-subtext"><span><img class="tick-image" src="Images/tick.png" alt="approve"></span>Designed to boost productivity</p>
            <p class="banner-subtext"><span><img class="tick-image" src="Images/tick.png" alt="approve"></span>Booking management without stress</p>
            <p class="banner-subtext"><span><img class="tick-image" src="Images/tick.png" alt="approve"></span>Full control over your data</p>
            <p class="banner-subtext"><span><img class="tick-image" src="Images/tick.png" alt="approve"></span>100% privacy guaranteed</p>
            <p class="banner-subtext"><span><img class="tick-image" src="Images/tick.png" alt="approve"></span>Professional software for businesses</p>
            <button class="bannerBtn">Learn More</button>
        </div>
    </div>
    </section>

    <hr class="section-line">

    <footer class="footer">
        <div class="sections">
        <div class="section">
        <p class="footer-title">Services</p>  
        <a href="#">Home</a>
        <a href="#">Features</a>
        <a href="#">Contact Us</a>
        <a href="#">About Us</a>
        </div>

        <div class="section">
            <p class="footer-title">Resources</p>
            <a href="#">Blog</a>
            <a href="#">FAQ</a>
            <a href="#">Customer service center</a>
            <a href="#">Support</a>
            <a href="#">Community</a>
            <a href="#">Privacy</a>
        </div>

        <div class="section">
            <p class="footer-title">Contact Us</p>
            <a href="#">Email</a>
            <a href="#">Phone number</a>
            <a href="#">Form</a>
        </div>

        <div class="section">
            <p class="footer-title">About Us</p>
            <a href="#">Who we are</a>
            <a href="#">Values</a>
            <a href="#">Blog</a>
            <a href="#">Location</a>
            <a href="#">Data protection</a>
            <a href="#">Terms and Conditions</a>
        </div>
    </div>
    </footer>

    <script>
        const mobileView = document.getElementsByClassName('mobile-view')[0]
const navbarLinks = document.getElementsByClassName('navbar-links')[0]

mobileView.addEventListener('click', () => {
    navbarLinks.classList.toggle('active');
})

    </script>
    </body>
    </html>