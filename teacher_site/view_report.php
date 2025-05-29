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
$result = $conn->query("SELECT * FROM students WHERE teacher_id = $teacher_id ORDER BY average_score DESC");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Raporo y’Abanyeshuri</title>
    <style>
        table {
            width: 90%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        th, td {
            border: 1px solid #555;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #eee;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Raporo y’Abanyeshuri</h2>
    <table>
        <tr>
            <th>no</th>
            <th>Izina ry’Umunyeshuri</th>
            <th>Amanota y’Ikizamini</th>
            <th>Amanota ya Test</th>
            <th>Average</th>
            <th>Igihe Yanditswe</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            $i = 1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>$i</td>
                        <td>{$row['student_name']}</td>
                        <td>{$row['exam_score']}</td>
                        <td>{$row['test_score']}</td>
                        <td>{$row['average_score']}</td>
                        <td>{$row['created_at']}</td>
                      </tr>";
                $i++;
            }
        } else {
            echo "<tr><td colspan='6'>Nta munyeshuri wanditswe</td></tr>";
        }
        ?>
    </table>

    <div style="text-align:center;">
        <a href="dashboard.php">Subira kuri Dashboard</a>
    </div>
</body>
</html>
