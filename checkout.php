<?php
// Start the session to access session variables
session_start();

// Check if the user is logged in
if (!isset($_SESSION['customer_name'])) {
    // If the user is not logged in, redirect to the login page
    header("Location: login.php");
    exit;
}

// Get the username from the session
$username = $_SESSION['username'];

// Establishing a connection to the MySQL database
$serverName = "localhost";
$userName = "root";
$password = "";
$dataBaseName = "kickoff_kingdom";

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


    if ($conn->query($sql) === TRUE) {
        // After inserting user data, you can also handle the cart items here
        // Retrieve cart items from session
        $cart_items = $_SESSION['cart'];

        // Iterate through cart items and process them
        foreach ($cart_items as $item) {
            $product_name = $item['name'];
            $product_price = $item['price'];

            // Insert cart items into the database
            $sql = "INSERT INTO orders (username, product_name, product_price) VALUES ('$username', '$product_name', '$product_price')";
            if ($conn->query($sql) !== TRUE) {
                echo "Error inserting cart items: " . $conn->error;
            }
        }

        // Clear the cart after checkout
        unset($_SESSION['cart']);

        echo "User data and cart items inserted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
     {
    // Redirect user if they try to access this page directly without submitting the form
    header("Location: login.html");
    exit;
}

// Close the database connection
$conn->close();
?>
