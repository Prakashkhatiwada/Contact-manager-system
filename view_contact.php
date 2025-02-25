<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM contacts WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $contact = $result->fetch_assoc();
    } else {
        echo "Contact not found.";
        exit;
    }
} else {
    echo "No contact ID provided.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Contact</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .contact-details img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <h1 class="text-center mt-5">Contact Details</h1>
                <div class="bg-white p-4 rounded shadow-sm contact-details">
                    <p><strong>Name:</strong> <?php echo $contact['name']; ?></p>
                    <p><strong>Email:</strong> <?php echo $contact['email']; ?></p>
                    <p><strong>Phone:</strong> <?php echo $contact['phone']; ?></p>
                    <p><strong>Address:</strong> <?php echo $contact['address']; ?></p>
                    <p><strong>Image:</strong> <img src="<?php echo $contact['image']; ?>" alt="<?php echo $contact['name']; ?>" class="img-fluid" style="width:50px;height:50px;"></p>
                    <a href="manage.php" class="btn btn-primary btn-block">Back to Contacts</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
