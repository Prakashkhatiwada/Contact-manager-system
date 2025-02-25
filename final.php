<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Manager</title>
    <link rel="stylesheet" href="styles.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .hero-images {
            display: flex;
            flex-direction: row; /* Arrange images in a column */
            justify-content: center;
            align-items: center;
            gap: 20px; /* Add space between images */
        }
        .hero-images img {
            width: 200px; /* Adjust the width to be bigger */
            height: auto; /* Maintain aspect ratio */
            border-radius: 10px; /* Add rounded corners */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add a subtle shadow */
            transition: transform 0.3s ease; /* Smooth zoom effect */
        }
        .hero-images img:hover {
            transform: scale(1.1); /* Zoom in the image on hover */
        }
        .hero-content {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px; /* Add space between elements */
            flex-direction: row; /* Change to row to align items horizontally */
        }
        .hero-content img {
            width: 200px; /* Adjust the width to be bigger */
            height: auto; /* Maintain aspect ratio */
            border-radius: 10px; /* Add rounded corners */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add a subtle shadow */
            transition: transform 0.3s ease; /* Smooth zoom effect */
        }
        .hero-content img:hover {
            transform: scale(1.1); /* Zoom in the image on hover */
        }
        .feature-list {
            display: flex;
            justify-content: space-around; /* Distribute space evenly */
            flex-wrap: wrap; /* Allow items to wrap to the next line if needed */
        }
        .feature-item {
            flex: 1;
            margin: 10px;
            min-width: 200px; /* Ensure a minimum width for each item */
            max-width: 300px; /* Ensure a maximum width for each item */
            text-align: center;
        }
        /* New styles for advanced features */
        .hero-content h1 {
            font-size: 3rem;
            font-weight: bold;
            color: #fff;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .section {
            padding: 80px 0;
        }
        .btn {
            background-color: #28a745;
            color: white;
            padding: 12px 30px;
            border-radius: 5px;
            font-size: 18px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #218838;
        }
        .feature-item i {
            font-size: 50px;
            color: #28a745;
            margin-bottom: 20px;
        }
        .feature-item h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
        }
        .feature-item p {
            font-size: 1rem;
        }
        footer {
            background-color: #333;
            color: white;
            padding: 15px 0;
            text-align: center;
        }
    </style>
</head> 
<body>
    <header class="bg-dark text-white py-3">         
        <nav class="container d-flex justify-content-between">
            <ul class="nav">
                <li class="nav-item"><a class="nav-link text-white" href="#home">Home</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#features">Features</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="#about">About</a></li>
            </ul>
            <a href="#" id="goToLogin" class="btn btn-success">Sign Up</a>
        </nav>
    </header>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="hero-content text-center">
            <img src="Contact.jpg" alt="Contact Manager Left" class="img-fluid mb-3">
            <h1 class="display-4">CONTACTS</h1>
            <h1 class="display-4">MANAGER </h1>
            <h1 class="display-4">SYSTEM!</h1>
            <img src="cont1.gif" alt="Contact Manager Right" class="img-fluid mt-3">
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="section">
        <div class="container">
            <h2 class="mb-5">Features</h2>
            <div class="row feature-list">
                <div class="col-md-4 feature-item">
                    <i class="fas fa-users"></i>
                    <h3>Contact Management</h3>
                    <p>Easily manage your contacts with intuitive tools and a user-friendly interface.</p>
                </div>
                <div class="col-md-4 feature-item">
                    <i class="fas fa-search"></i>
                    <h3>Quick Search</h3>
                    <p>Find your contacts instantly using powerful and fast search functionality.</p>
                </div>
                <div class="col-md-4 feature-item">
                    <i class="fas fa-lock"></i>
                    <h3>Secure</h3>
                    <p>Your privacy is our priority. We use the latest encryption technology to keep your data safe.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="section">
        <div class="container">
            <h2 class="mb-5">About Us</h2>
            <p>Contact Manager helps you stay organized, connected, and productive—whether personally or professionally.</p>
            <p>From personal connections to professional networks, manage them all in one place.</p>
            <p>Transform chaos into clarity with our intuitive contact management solution.</p>
        </div>
    </section>

    <footer class="bg-dark text-white py-3">
        <p>&copy; 2025 Contact Manager,develop by Prakash & jivan.</p>
    </footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="script.js"></script>
<script>
// JavaScript to handle page navigation
document.getElementById('goToLogin').onclick = function() {
    window.location.href = "login.php";
};


</script>

</body>
</html>
