<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div id="registerPage" class="register-form mt-5">
            <h1 class="text-center">Register</h1>
            <form action="register.php" method="POST" id="registerForm" class="mt-4">
                <div class="form-group">
                    <input type="text" id="registerName" name="name" class="form-control" placeholder="Name" required>
                </div>
                <div class="form-group">
                    <input type="email" id="registerEmail" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <input type="password" id="registerPassword" name="password" class="form-control" placeholder="Password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Register</button>
            </form>
            <p class="text-center mt-3">Already have an account? <a href="login.php" id="showLogin">Login Here</a></p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
    <script>
        $(document).ready(function() {
            $('#registerForm').on('submit', function(event) {
                var isValid = true;
                var name = $('#registerName').val().trim();
                var email = $('#registerEmail').val().trim();
                var password = $('#registerPassword').val().trim();

                if (name === '') {
                    alert('Name is required.');
                    isValid = false;
                } else if (email === '') {
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
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $password);

        if ($stmt->execute()) {
            echo "Registration successful!";
            header("Location: login.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Database connection failed.";
    }
}
?>