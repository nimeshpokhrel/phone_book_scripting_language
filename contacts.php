<?php
require_once 'db.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

$statement = $pdo->prepare("SELECT * FROM contacts");
$statement->execute();
$contacts = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacts</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        a {
            text-decoration: none;
            color: #4CAF50;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <h2>Your Contacts</h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Phone Number</th>
            <th>Action</th>
        </tr>
        <?php foreach ($contacts as $contact): ?>
            <tr>
                <td>
                    <?php echo $contact['name']; ?>
                </td>
                <td>
                    <?php echo $contact['phone_number']; ?>
                </td>
                <td>
                    <?php
                    if ($contact['user_id'] == $user_id) {
                        echo '<a href="edit_contact.php?id=' . $contact['id'] . '">Edit</a> | ';
                        echo '<a href="delete_contact.php?id=' . $contact['id'] . '">Delete</a>';
                    }
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <br>
    <a href="add_contact.php" style="padding: 10px;">Add Contact</a>
    <br>
    <br>
    <a href="logout.php" style="padding: 10px;">Logout</a>
</body>

</html>