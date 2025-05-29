<?php
session_start();
if (!isset($_SESSION['teacher_id'])) {
    header("Location: login.php");
    exit;
}

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "school_marks";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_name = $_POST['student_name'];
    $exam_score = floatval($_POST['exam_score']);
    $test_score = floatval($_POST['test_score']);
    $average = ($exam_score + $test_score) / 2;
    $teacher_id = $_SESSION['teacher_id'];

    $stmt = $conn->prepare("INSERT INTO students (teacher_id, student_name, exam_score, test_score, average_score) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isddd", $teacher_id, $student_name, $exam_score, $test_score, $average);

    if ($stmt->execute()) {
        $msg = "Umunyeshuri yanditswe neza!";
    } else {
        $msg = "Habaye ikibazo: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href=".css">
    <title>Andika Umwanya w’Umunyeshuri</title>
</head>
<body>
    <h2>Andika Umwanya w’Umunyeshuri</h2>
    <?php if (isset($msg)) echo "<p><strong>$msg</strong></p>"; ?>
    <form method="POST" action="">
        Izina ry’umunyeshuri: <input type="text" name="student_name" required><br><br>
        Amanota y’Ikizamini: <input type="number" step="0.01" name="exam_score" required><br><br>
        Amanota ya test / continuous: <input type="number" step="0.01" name="test_score" required><br><br>
        <button type="submit">Andika</button>
    </form>

    <p><a href="dashboard.php">Subira kuri Dashboard</a></p>
</body>
</html>
