<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
} else {
    header('Location: manage.php');
    exit;
}
?>
