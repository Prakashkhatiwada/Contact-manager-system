<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Page</title>
    <style>
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body and Background */
        body {
            font-family: 'Arial', sans-serif;
            background-color:rgb(178, 252, 246);
            color: #333;
            line-height: 1.6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Page Container */
        .page {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px;
        }

        /* Form Styles */
        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        form input, form button {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        form button {
            background-color: #28a745;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form button:hover {
            background-color: #218838;
        }

        /* Error Message */
        .error {
            color: red;
            margin-top: 10px;
        }

        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        table th {
            background-color:rgb(129, 251, 255);
        }

        table img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 5px;
        }

        /* Action Buttons */
        .action-buttons button {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 5px;
        }

        .action-buttons button:hover {
            opacity: 0.8;
        }

        .action-buttons button:nth-child(1) {
            background-color: #007bff;
            color: white;
        }

        .action-buttons button:nth-child(2) {
            background-color: #dc3545;
            color: white;
        }

        /* Logout Button */
        #logoutButton {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        #logoutButton:hover {
            background-color: #c82333;
        }

        @media (max-width: 768px) {
            .page {
                padding: 20px;
            }

            table th, table td {
                padding: 8px;
            }

            .action-buttons button {
                padding: 5px;
                font-size: 14px;
            }
        }

        @media (max-width: 576px) {
            .page {
                padding: 15px;
            }

            table th, table td {
                padding: 6px;
            }

            .action-buttons button {
                padding: 4px;
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <!-- Contact Manager Page -->
    <div id="contactManager" class="page container">
        <h1>Contact Manager System</h1>
        <form id="contactForm" method="POST" action="add_contact.php" enctype="multipart/form-data" class="mb-4">
            <input type="text" id="name" name="name" placeholder="Name" required>
            <input type="email" id="email" name="email" placeholder="Email" required>
            <input type="tel" id="phone" name="phone" placeholder="Phone" pattern="\d{10}" required>
            <input type="text" id="address" name="address" placeholder="Address (optional)">
            <input type="file" id="imageUpload" name="image" accept=".jpg, .jpeg, .png">
            <input type="hidden" name="redirect" value="view_contact.php">
            <button type="submit">Add Contact</button> <!-- Corrected typo -->
        </form>
       
        <div class="error" id="errorMessage"></div>
        <table id="contactTable" class="table table-striped table-responsive">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Contacts will be added here -->
                <?php
                include 'db.php';
                $sql = "SELECT * FROM contacts";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['name']}</td>
                                <td>{$row['email']}</td>
                                <td>{$row['phone']}</td>
                                <td>{$row['address']}</td>
                                <td><img src='{$row['image']}' alt='{$row['name']}' style='width:50px;height:50px;'></td>
                                <td class='action-buttons'>
                                    <button onclick='editContact({$row['id']})'>Edit</button>
                                    <button onclick='deleteContact({$row['id']})'>Delete</button>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No contacts found</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
        <button id="logoutButton" class="btn btn-danger btn-block" onclick="logout()">Logout</button>
    </div>

    <script src="script.js"></script>
    <script>
        function logout() {
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = 'logout.php';
            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'logout';
            input.value = 'true';
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'db.php';

    $name = $_POST['name'];
    $email = strtolower(trim($_POST['email'])); // Ensure email is lowercase
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $image = '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploads_dir = 'uploads';
        if (!is_dir($uploads_dir)) {
            mkdir($uploads_dir, 0777, true);
        }
        $image = $uploads_dir . '/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }

    $sql = "INSERT INTO contacts (name, email, phone, address, image) VALUES ('$name', '$email', '$phone', '$address', '$image')";

    if ($conn->query($sql) === TRUE) {
        header('Location: manage.php');
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>