<?php
session_start();
if (!isset($_SESSION['gallery'])) {
    $_SESSION['gallery'] = array();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
    <!-- main class -->
    <main class=wrapper>
            <h1>Image Gallery</h1>
            <em>This page displays the list of uploaded image</em>
            <br>
            <button>Upload More!</button>
            <br>
            <br>
            <form action="#" method="post" enctype="multipart/form-data">
                <label>Select image to upload:</label>
                <br>
                <input type="file" name="fileToUpload" id="fileToUpload" />
                <input type="submit" id="button" value="Upload Image" name="submit" />
                <button type="button" id="button_n" hidden> Upload Image</button>
            </form>
            <!-- php for image upload -->
<?php
            if (isset($_POST["submit"])) 
            {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if ($check !== false) {

                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
            // Check if file already exists
            if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
            }
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif") {
                $uploadOk = 0;
            }
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
                    array_push($_SESSION['gallery'], $_FILES["fileToUpload"]["name"]);
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
            // session traversal for image display
            echo "<div class = 'image__box'>";
            foreach ($_SESSION['gallery'] as $key => $value) {
                echo "<div class='wrapper_img'>";
                echo "<img src='./uploads/$value'></img>";
                echo "<h4>$value</h4></div>";
            }
            echo "</div>";
        }
        // for clearing the session 
        // unset($_SESSION['gallery']);
        // session_destroy();
?>
    </main>
</body>
</html>