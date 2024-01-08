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

// Delete the contact from the database
$deleteStatement = $pdo->prepare("DELETE FROM contacts WHERE id = ?");
$deleteStatement->execute([$contact_id]);

header('Location: contacts.php');
exit();
?>
