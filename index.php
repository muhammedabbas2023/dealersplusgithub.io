<!DOCTYPE html>
<html>
<head>
    <title>House Post Submission</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="rented.css">
</head>
   
<body>
   
    <div class="buttons">
        <button id="login-btn">Login</button>
        <button id="signup-btn">Sign Up</button>
    </div>

<?php
$servername = "localhost";
$username = "root";
$password = ""; // Leave it empty if you didn't set a password during XAMPP installation
$database = "mydatabase";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, name, mobile, location, rental_price, description, image1, image1_type, timestamp FROM users";
$result = $conn->query($sql);

echo "<div class='container'>";
echo "<h1>House Available In Sahiwal For Rent:</h1>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Check if an image is presented
        if (!empty($row['image1'])) {
            echo "<div class='house-item'>";
            
            // Image container
            echo "<div class='image-container'>";
            $imageType1 = $row['image1_type'];
            $imageData1 = base64_decode($row['image1']);
            
            // Create a temporary image resource from the decoded image data
            $sourceImage = imagecreatefromstring($imageData1);
            
            // Calculate the new dimensions
            $maxWidth = 400; // Set the maximum width of the container
            $maxHeight = 200; // Set the maximum height of the container
            
            $sourceWidth = imagesx($sourceImage);
            $sourceHeight = imagesy($sourceImage);
            
            $aspectRatio = $sourceWidth / $sourceHeight;
            
            if ($sourceWidth > $maxWidth || $sourceHeight > $maxHeight) {
                if ($aspectRatio > 1) {
                    $newWidth = $maxWidth;
                    $newHeight = $maxWidth / $aspectRatio;
                } else {
                    $newWidth = $maxHeight * $aspectRatio;
                    $newHeight = $maxHeight;
                }
            } else {
                $newWidth = $sourceWidth;
                $newHeight = $sourceHeight;
            }
            
            // Create a new image with the calculated dimensions
            $compressedImage = imagecreatetruecolor($newWidth, $newHeight);
            
            // Resize the image
            imagecopyresampled($compressedImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $sourceWidth, $sourceHeight);
            
            // Output the compressed image
            ob_start();
            imagejpeg($compressedImage, null, 80); // Adjust the image quality as needed
            $compressedImageData = ob_get_clean();
            $compressedImageBase64 = base64_encode($compressedImageData);
            $compressedImageSrc = "data:image/jpeg;base64," . $compressedImageBase64;
            
            // Display the compressed image
            echo "<img src='" . $compressedImageSrc . "' alt='User Image 1' class='house-image'>";
            
            // Clean up the resources
            imagedestroy($sourceImage);
            imagedestroy($compressedImage);
            
            echo "</div>"; // Close image container
            
            // ...
            
            // Text container
            echo "<div class='text-container'>";
            echo "<p>ID: " . $row['id'] . "</p>";
            echo "<p>Name: " . $row['name'] . "</p>";
            echo "<p>Mobile: " . $row['mobile'] . "</p>";
            echo "<p>Location: " . $row['location'] . "</p>";   
            echo "<p>Rental Price: " . $row['rental_price'] . "</p>";
            echo "<p>Description: " . $row['description'] . "</p>";
            echo "</div>"; // Close text container
            
            echo "</div>"; // Close house-item container
        }
    }
} else {
    echo "No users found.";
}

echo "</div>"; // Closing the main container

$conn->close();
?>


<script src="rented.js"></script>
</body>
</html>