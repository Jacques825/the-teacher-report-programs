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

$teacher_id = $_SESSION['teacher_id'];

if (!isset($_GET['id'])) {
    header("Location: view_report.php");
    exit;
}

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM students WHERE id = ? AND teacher_id = ?");
$stmt->bind_param("ii", $id, $teacher_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    echo "Umunyeshuri ntabonetse.";
    exit;
}

$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_name = $_POST['student_name'];
    $exam_score = floatval($_POST['exam_score']);
    $test_score = floatval($_POST['test_score']);
    $average = ($exam_score + $test_score) / 2;

    $stmt = $conn->prepare("UPDATE students SET student_name=?, exam_score=?, test_score=?, average_score=? WHERE id=? AND teacher_id=?");
    $stmt->bind_param("sdddii", $student_name, $exam_score, $test_score, $average, $id, $teacher_id);

    if ($stmt->execute()) {
        header("Location: view_report.php?msg=updated");
        exit;
    } else {
        echo "Guhindura byanze: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hindura Umunyeshuri</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Hindura Amanota y’Umunyeshuri</h2>
    <form method="POST">
        Izina ry'umunyeshuri:<br>
        <input type="text" name="student_name" value="<?= htmlspecialchars($row['student_name']) ?>" required><br><br>
        Amanota y'ikizamini:<br>
        <input type="number" step="0.01" name="exam_score" value="<?= $row['exam_score'] ?>" required><br><br>
        Amanota ya test:<br>
        <input type="number" step="0.01" name="test_score" value="<?= $row['test_score'] ?>" required><br><br>
        <button type="submit">Hindura</button>
    </form>

    <p><a href="view_report.php">Subira kuri Raporo</a></p>
</body>
</html>
