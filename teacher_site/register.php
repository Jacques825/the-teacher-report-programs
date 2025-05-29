<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "school_marks";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO teachers (full_name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $full_name, $email, $password);

    if ($stmt->execute()) {
        echo "Wiyandikishije neza! <a href='login.php'>Injira</a>";
    } else {
        echo "Hari ikibazo: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kwiyandikisha</title>
    <link rel="stylesheet" href=".css">

</head>
<body>
    <h2>Kwiyandikisha kw’Umwarimu</h2>
    <form method="POST" action="">
        Amazina: <input type="text" name="full_name" required><br><br>
        Email: <input type="email" name="email" required><br><br>
        Ijambo banga: <input type="password" name="password" required><br><br>
        <button type="submit">Iyandikishe</button>
    </form>
</body>
</html>
