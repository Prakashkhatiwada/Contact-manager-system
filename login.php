<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div id="loginPage" class="register-form mt-5">
            <h1 class="text-center">Login</h1>
            <form action="login.php" method="POST" id="loginForm" class="mt-4">
                <div class="form-group">
                    <input type="email" id="loginEmail" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <input type="password" id="loginPassword" name="password" class="form-control" placeholder="Password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>
            <p class="text-center mt-3">Don't have an account? <a href="register.php" id="showRegister">Register Here</a></p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
    <script>
        $(document).ready(function() {
            $('#loginForm').on('submit', function(event) {
                var isValid = true;
                var email = $('#loginEmail').val().trim();
                var password = $('#loginPassword').val().trim();

                if (email === '') {
                    alert('Email is required.');
                    isValid = false;
                } else if (password === '') {
                    alert('Password is required.');
                    isValid = false;
                } else if (password.length < 8) {
                    alert('Password must be at least 8 characters long.');
                    isValid = false;
                }

                if (!isValid) {
                    event.preventDefault();
                }
            });
        });
    </script>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'db.php';

    if ($conn) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if ($password==$user['password']) {
                echo "Login successful!";
                header("Location:manage.php");
                exit();
            } else {
                echo "Invalid email or password.";
            }
        } else {
            echo "Invalid email or password.";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Database connection failed.";
    }
}
?>