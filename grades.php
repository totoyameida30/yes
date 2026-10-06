<?php

session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

include "db.php";


if (
    $_SESSION["role"] === "TEACHER" &&
    $_SERVER["REQUEST_METHOD"] === "POST"
) {

    $student_id = intval($_POST["student_id"]);
    $subject = trim($_POST["subject"]);
    $grade = floatval($_POST["grade"]);


    $stmt = $conn->prepare(
        "INSERT INTO grades
        (student_id, subject, grade, recorded_by)
        VALUES (?, ?, ?, ?)"
    );


    $stmt->bind_param(
        "isdi",
        $student_id,
        $subject,
        $grade,
        $_SESSION["user_id"]
    );


    $stmt->execute();
}


if ($_SESSION["role"] === "STUDENT") {

    $id = $_SESSION["user_id"];

    $records = $conn->query(
        "SELECT *
         FROM grades
         WHERE student_id = $id
         ORDER BY created_at DESC"
    );

} else {

    $records = $conn->query(
        "SELECT
            grades.*,
            users.full_name
         FROM grades
         JOIN users
         ON grades.student_id = users.id
         ORDER BY grades.created_at DESC"
    );

}


$students = $conn->query(
    "SELECT id, full_name
     FROM users
     WHERE role = 'STUDENT'
     ORDER BY full_name"
);

?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Grades</title>

<link rel="stylesheet"
href="style.css">

</head>

<body class="dashboard-body">

<aside class="sidebar">

<h2>📡 NFC Portal</h2>

<a href="<?php echo $_SESSION["role"] === "STUDENT"
? "student_dashboard.php"
: "teacher_dashboard.php"; ?>">
🏠 Dashboard
</a>

<a href="attendance.php">📅 Attendance</a>
<a href="grades.php">📊 Grades</a>
<a href="quizzes.php">📝 Quizzes</a>
<a href="recitation.php">🎤 Recitation</a>
<a href="schedule.php">🗓 Schedule</a>
<a href="announcements.php">📢 Announcements</a>

<a href="logout.php" class="logout">
🚪 Logout
</a>

</aside>


<main class="main-content">

<h1>📊 Grades</h1>


<?php if ($_SESSION["role"] === "TEACHER"): ?>

<div class="dashboard-card">

<h2>Record Grade</h2>

<form method="POST">

<label>Student</label>

<select name="student_id" required>

<option value="">
Select Student
</option>

<?php while ($student = $students->fetch_assoc()): ?>

<option value="<?php echo $student["id"]; ?>">

<?php
echo htmlspecialchars(
$student["full_name"]
);
?>

</option>

<?php endwhile; ?>

</select>


<label>Subject</label>

<input
type="text"
name="subject"
placeholder="Example: Programming"
required
>


<label>Grade</label>

<input
type="number"
name="grade"
step="0.01"
min="0"
max="100"
required
>


<button class="main-button">
Save Grade
</button>

</form>

</div>

<?php endif; ?>


<div class="dashboard-card">

<h2>Grade Records</h2>

<div class="table-container">

<table>

<tr>

<?php if ($_SESSION["role"] === "TEACHER"): ?>

<th>Student</th>

<?php endif; ?>

<th>Subject</th>

<th>Grade</th>

</tr>


<?php while ($row = $records->fetch_assoc()): ?>

<tr>

<?php if ($_SESSION["role"] === "TEACHER"): ?>

<td>
<?php
echo htmlspecialchars(
$row["full_name"]
);
?>
</td>

<?php endif; ?>

<td>
<?php
echo htmlspecialchars(
$row["subject"]
);
?>
</td>

<td>

<strong>
<?php
echo htmlspecialchars(
$row["grade"]
);
?>
</strong>

</td>

</tr>

<?php endwhile; ?>

</table>

</div>

</div>

</main>

</body>

</html>