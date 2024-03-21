<?php
header("Access-Control-Allow-Origin: *");

$serverName = "localhost";
$userName = "root";
$password = "";
$dataBaseName = "kickoff_kingdom";

$conn = new mysqli($serverName, $userName, $password, $dataBaseName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT * FROM register WHERE Email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($password == $row['Password']) {
        if ($row['user_type'] == 'admin') {
            session_start();
            $_SESSION['admin_name'] = $row['FullName']; // assuming 'name' is 'FullName'
            header("Location: dashboardadmin.html");
            exit();
        } elseif ($row['user_type'] == 'customer') {
            session_start();
            $_SESSION['customer_name'] = $row['FullName']; // assuming 'name' is 'FullName'
            header("Location: dashboardcustomer.html");
            exit();
        }  else {
            $response = array("status" => "error", "message" => "Invalid user type");
            echo json_encode($response);
        }
    } else {
        $response = array("status" => "error", "message" => "Invalid password");
        echo json_encode($response);
    }
} else {
    $response = array("status" => "error", "message" => "User not found");
    echo json_encode($response);
}

$stmt->close();
$conn->close();
?>
