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

$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Check if an image is presented
        if (!empty($row['image1'])) {
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
            
            // Clean up the resources
            imagedestroy($sourceImage);
            imagedestroy($compressedImage);
            
            // Add the data to the array
            $data[] = array(
                'id' => $row['id'],
                'name' => $row['name'],
                'mobile' => $row['mobile'],
                'location' => $row['location'],
                'rental_price' => $row['rental_price'],
                'description' => $row['description'],
                'image1' => $compressedImageSrc
            );
        }
    }
}

$conn->close();

// Encode the data as JSON and send the response
header('Content-Type: application/json');
echo json_encode($data);
?>
