<?php
include 'db.php';

$contact = null; // Initialize the contact variable

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize the id
    $sql = "SELECT * FROM contacts WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $contact = $result->fetch_assoc();
    } else {
        echo "Contact not found.";
        exit;
    }
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']); // Sanitize the id
    $name = $_POST['name'];
    $email = strtolower(trim($_POST['email'])); // Ensure email is lowercase
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $image = isset($contact['image']) ? $contact['image'] : '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploads_dir = 'uploads';
        if (!is_dir($uploads_dir)) {
            mkdir($uploads_dir, 0777, true);
        }
        $image = $uploads_dir . '/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }

    $sql = "UPDATE contacts SET name=?, email=?, phone=?, address=?, image=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssi", $name, $email, $phone, $address, $image, $id);

    if ($stmt->execute() === TRUE) {
        header('Location: manage.php');
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Contact</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media (max-width: 576px) {
            .container {
                padding: 0 15px;
            }

            .form-group {
                margin-bottom: 15px;
            }
        }
    </style>
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <h1 class="text-center mt-5">Edit Contact</h1>
                <form id="editForm" method="POST" action="edit.php" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm">
                    <input type="hidden" id="editId" name="id" value="<?php echo isset($contact['id']) ? $contact['id'] : ''; ?>">
                    <div class="form-group">
                        <label for="editName">Name</label>
                        <input type="text" id="editName" name="name" value="<?php echo isset($contact['name']) ? $contact['name'] : ''; ?>" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="editEmail">Email</label>
                        <input type="email" id="editEmail" name="email" value="<?php echo isset($contact['email']) ? $contact['email'] : ''; ?>" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="editPhone">Phone</label>
                        <input type="tel" id="editPhone" name="phone" value="<?php echo isset($contact['phone']) ? $contact['phone'] : ''; ?>" pattern="\d{10}" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="editAddress">Address</label>
                        <input type="text" id="editAddress" name="address" value="<?php echo isset($contact['address']) ? $contact['address'] : ''; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="editImageUpload">Image</label>
                        <input type="file" id="editImageUpload" name="image" accept=".jpg, .jpeg, .png" class="form-control-file">
                    </div>
                    <button type="submit" class="btn btn-success btn-block">Update Contact</button>
                </form>
                <div class="error text-danger text-center mt-3" id="errorMessage"></div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.getElementById('editForm').addEventListener('submit', function(event) {
            const emailInput = document.getElementById('editEmail');
            if (emailInput.value !== emailInput.value.toLowerCase()) {
                event.preventDefault();
                document.getElementById('errorMessage').textContent = 'Email must be in lowercase.';
                return false;
            }
        });
    </script>
</body>
</html>
