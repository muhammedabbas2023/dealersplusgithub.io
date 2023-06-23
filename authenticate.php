<?php
// Establish a connection to the database
$conn = mysqli_connect("localhost", "root", "", "mydatabase");

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the entered username and password from the form data
$username = $_POST['username'];
$password = $_POST['password'];


// Prepare the SQL statement to retrieve the user from the database
$sql = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $sql);

// Check if the user exists
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);

    // Validate the password using password_verify
    if (password_verify($password, $row['password'])) {
        // Password is correct, return a JSON response indicating authentication success
        $response = array(
            'authenticated' => true,
            'message' => 'Authentication successful'
        );
    } else {
        // Invalid password, return a JSON response indicating authentication failure
        $response = array(
            'authenticated' => false,
            'message' => 'Invalid username or password'
        );
    }
} else {
    // User not found, return a JSON response indicating authentication failure
    $response = array(
        'authenticated' => false,
        'message' => 'Invalid username or password'
    );
}

// Close the database connection
mysqli_close($conn);

// Return the JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
