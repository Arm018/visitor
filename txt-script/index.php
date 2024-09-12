<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Загрузка файла</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Download File .txt</h1>

<form action="index.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="uploaded_file" accept=".txt" required>
    <button type="submit" name="upload">Download</button>
</form>

<?php

if (isset($_POST['upload'])) {
    $upload_dir = __DIR__ . '/files/';
    $uploadedFileTmpName = $_FILES['uploaded_file']['tmp_name'];
    $uploadedFileName = $_FILES['uploaded_file']['name'];
    $uploadedFile = $upload_dir . $uploadedFileName;

    if (move_uploaded_file($uploadedFileTmpName, $uploadedFile)) {
        echo '<div class="status success"></div>';
        echo "<p style='color: green'>File <strong>$uploadedFileName</strong> uploaded.</p>";

        $fileContent = file_get_contents($uploadedFile);
        $lines = explode(',', $fileContent);

        foreach ($lines as $line) {
            $digits_count = preg_match_all('/\d/', $line);
            echo "<p>Line: \"$line\" = $digits_count numbers</p>";
        }

    } else {
        echo '<div class="status error"></div>';
        echo "<p style='color: red;'>Error uploading the file</p>";
    }


}
?>


</body>
</html>
