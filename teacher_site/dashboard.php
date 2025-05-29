<?php
session_start();
if (!isset($_SESSION['teacher_id'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <style>
    
    </style>
    
    <title>Dashboard</title>
    <link rel="stylesheet" href=".css">
</head>
<body>
    <h2>Murakaza neza, <?php echo $_SESSION['teacher_name']; ?>!</h2>
    <ul>
        <li><a href="add_student.php">Andika abanyeshuri n’amanota</a></li>
        <li><a href="view_report.php">Reba raporo</a></li>
        <li><a href="logout.php">Sohoka</a></li>
    </ul>
</body>
</html>
