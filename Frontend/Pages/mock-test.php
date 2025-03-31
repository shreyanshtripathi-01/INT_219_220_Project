<?php
session_start();
require_once '../../Backend/PHP/config.php';
// Require login for mock test
if(!isset($_SESSION['user_id'])) {
    header("Location: /Frontend/Pages/login.php?error=Please login to access mock tests");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/Frontend/src/tailwind.css" rel="stylesheet">
    <title>Mock Test - HackProctor</title>
</head>
<body class="flex flex-col min-h-screen bg-gray-50">
    <!-- Copy the same header from index.php -->
    <!-- Add your mock test content -->
    <!-- Copy the same footer from index.php -->
</body>
</html> 