<?php

session_start();

// if the session 'userId' is not set, redirect back to the login page
if (!isset($_SESSION['userId'])) {
    header('Location: index.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <?php include 'includes/bootstrap-scripts.php'?>
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="icon" href="favicon.ico">
    <title>Tasks</title>
</head>

<body>
    <?php include 'components/sidebar.php';?>
    <div id="mainContent">
        <?php include 'components/navbar.php';?>
        <h1 class="display-4">My Tasks</h1>

        <div id="taskList"></div>
        <script src="js/tasklist.js"></script>
    </div>
</body>

</html>