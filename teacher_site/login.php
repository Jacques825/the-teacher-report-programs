<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "school_marks";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, full_name, password FROM teachers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $teacher = $result->fetch_assoc();
        if (password_verify($password, $teacher['password'])) {
            $_SESSION['teacher_id'] = $teacher['id'];
            $_SESSION['teacher_name'] = $teacher['full_name'];
            header("Location: dashboard.php");
            exit;
        } else {
            echo "Ijambo banga si ryo.";
        }
    } else {
        echo "Email ntabwo ibonetse.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Injira</title>
    <link rel="stylesheet" href=".css">
</head>
<body>
    <h2>Injira nk’Umwarimu</h2>
    <form method="POST" action="">
        Email: <input type="email" name="email" required><br><br>
        Ijambo banga: <input type="password" name="password" required><br><br>
        <button type="submit">Injira</button>
    </form>
</body>
</html>
