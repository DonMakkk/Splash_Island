<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "splash_island_data";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, full_name, email, date, phone_number, message FROM user_inquiries";
$result = $conn->query($sql);

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

header('Content-Type: application/json');
echo json_encode($messages);
$conn->close();
?>
