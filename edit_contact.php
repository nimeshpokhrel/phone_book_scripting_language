<?php
require_once 'db.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if contact ID is provided in the URL
if (!isset($_GET['id'])) {
    header('Location: contacts.php');
    exit();
}

$contact_id = $_GET['id'];

// Fetch the contact based on ID and user ID
$statement = $pdo->prepare("SELECT * FROM contacts WHERE id = ? AND user_id = ?");
$statement->execute([$contact_id, $user_id]);
$contact = $statement->fetch(PDO::FETCH_ASSOC);

// Check if the contact exists and belongs to the logged-in user
if (!$contact) {
    header('Location: contacts.php');
    exit();
}

// Update the contact in the database (assuming you have a form to edit contact details)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $phone_number = $_POST['phone_number'];

    $updateStatement = $pdo->prepare("UPDATE contacts SET name = ?, phone_number = ? WHERE id = ?");
    $updateStatement->execute([$name, $phone_number, $contact_id]);

    header('Location: contacts.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Contact</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            width: 300px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #45a049;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #4CAF50;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <h2>Edit Contact</h2>
    <form method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?= $contact['name'] ?>" required>
        <br>
        <label for="phone_number">Phone Number:</label>
        <input type="text" id="phone_number" name="phone_number" value="<?= $contact['phone_number'] ?>" required>
        <br>
        <button type="submit">Save Changes</button>
    </form>
    <br>
    <a href="contacts.php">Back to Contacts</a>
</body>

</html>