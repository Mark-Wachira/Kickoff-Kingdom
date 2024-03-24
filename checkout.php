<?php
session_start();

// Check if the cart exists in the session
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    // If the cart is empty, redirect to the shopping cart page
    header("Location: checkout.html");
    exit;
}

// Retrieve cart items from session
$cart_items = $_SESSION['cart'];

// Establish database connection
$serverName = "localhost";
$userName = "root";
$password = "";
$dataBaseName = "kickoff_kingdom";

$conn = new mysqli($serverName, $userName, $password, $dataBaseName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare statement for inserting cart items into the database
$stmt = $conn->prepare("INSERT INTO orders (FullName, product_name, product_price) VALUES (?, ?, ?)");

// Bind parameters
$stmt->bind_param("sss", $fullname, $product_name, $product_price);

// Get the full name from the session
$fullname = $_SESSION['customer_name'];

// Iterate through cart items and insert them into the database
foreach ($cart_items as $item) {
    $product_name = $item['name'];
    $product_price = $item['price'];

    // Execute the prepared statement
    if (!$stmt->execute()) {
        echo "Error inserting cart items: " . $stmt->error;
    }
}

// Close the prepared statement
$stmt->close();

// Clear the cart after checkout
unset($_SESSION['cart']);

// Close the database connection
$conn->close();

exit;
?>
