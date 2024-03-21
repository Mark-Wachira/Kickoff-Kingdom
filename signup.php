<?php
header("Access-Control-Allow-Origin: *");

$serverName = "localhost";
$userName = "root";
$password = "";
$dataBaseName = "kickoff_kingdom";

$conn = new mysqli($serverName, $userName, $password, $dataBaseName);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $user_type = $_POST['user_type']; // Adding user type

        $sql = "INSERT INTO register (FullName, Email, password, user_type) VALUES ('$name', '$email', '$password', '$user_type')"; // Including user type in the query

        $res = $conn->query($sql);
        if ($res) {
            echo "<script>
                    alert('Sign up successful! Click OK to proceed to the login page.');
                    window.location.href = 'login.html';
                  </script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $sql = "SELECT * FROM register";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        echo json_encode($data);
    } else {
        echo "0 results";
    }
}

$conn->close();
?>
