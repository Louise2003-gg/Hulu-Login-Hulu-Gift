<?php
// signup_backend.php
header("Content-Type: application/json");

// Get POST data
$data = json_decode(file_get_contents("php://input"), true);
$uid = $data['uid'];
$email = $data['email'];
$name = $data['name'];

// MySQL connection
$servername = "localhost";
$username = "root"; // default XAMPP
$password = "";     // default XAMPP
$dbname = "mydatabase"; // create this in phpMyAdmin

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Insert into MySQL
$stmt = $conn->prepare("INSERT INTO users (uid, email, name) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $uid, $email, $name);

if ($stmt->execute()) {
  echo json_encode(["status" => "success"]);
} else {
  echo json_encode(["status" => "error", "message" => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
