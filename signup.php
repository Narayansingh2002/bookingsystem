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
                <li><a href="index.php">Home</a></li>
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

    <div class="screen-container">
    <div class="signup-container">
        <h1 class="form-title">Create an account</h1>
        <form action="signup-process.php" class="form" method="post" novalidate>
        <div class="input-text">
                <label for="name">Full Name</label>
                <input type="name" placeholder="Sarah Williams" name="name">
            </div>

            <div class="input-text">
                <label for="email">Email</label>
                <input type="email" placeholder="sarah@gmail.com" name="email">
            </div>

            <div class="input-text">
                <label for="passwords">Password</label>
                <input type="password" name="passwords">
        </div>

        <div class="input-text">
                <label for="passwords">Repeat Password</label>
                <input type="password" name="repeatpassword">
        </div>

            <div class="input-text">
                <label for="type">Account Type:</label>
                <select class="types" name="types" id="types">
                    <option class="options" value="">Select</option>
                    <option class="options" value="Owner">Business Owner</option>
                    <option class="options" value="Customer">Customer</option>
                    <option class="options" value="Admin">Admin</option>
                </select>
        </div>

            <button type="submit" name="submit" class="login-button">Sign Up</button>
        </form>
    </div>
    </div>

    <hr class="section-line signup-line">

<footer class="footer signup-footer">
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