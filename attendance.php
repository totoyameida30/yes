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

    $student_id =
        intval($_POST["student_id"]);

    $status =
        $_POST["status"];

    $date =
        $_POST["attendance_date"];


    $stmt = $conn->prepare(
        "INSERT INTO attendance
        (student_id, attendance_date, status, recorded_by)
        VALUES (?, ?, ?, ?)"
    );


    $stmt->bind_param(
        "issi",
        $student_id,
        $date,
        $status,
        $_SESSION["user_id"]
    );


    $stmt->execute();

}


if ($_SESSION["role"] === "STUDENT") {

    $student_id =
        $_SESSION["user_id"];

    $records =
        $conn->query(
            "SELECT *
             FROM attendance
             WHERE student_id = $student_id
             ORDER BY attendance_date DESC"
        );

} else {

    $records =
        $conn->query(
            "SELECT
                attendance.*,
                users.full_name
             FROM attendance
             JOIN users
             ON attendance.student_id = users.id
             ORDER BY attendance_date DESC"
        );

}


$students =
    $conn->query(
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

<title>Attendance</title>

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

<h1>📅 Attendance</h1>

<?php if ($_SESSION["role"] === "TEACHER"): ?>

<div class="dashboard-card">

<h2>Record Attendance</h2>

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


<label>Date</label>

<input
type="date"
name="attendance_date"
value="<?php echo date('Y-m-d'); ?>"
required
>


<label>Status</label>

<select name="status">

<option value="PRESENT">
Present
</option>

<option value="LATE">
Late
</option>

<option value="ABSENT">
Absent
</option>

</select>


<button class="main-button">
Save Attendance
</button>

</form>

</div>

<?php endif; ?>


<div class="dashboard-card">

<h2>Attendance Records</h2>

<div class="table-container">

<table>

<tr>

<?php if ($_SESSION["role"] === "TEACHER"): ?>

<th>Student</th>

<?php endif; ?>

<th>Date</th>

<th>Status</th>

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
$row["attendance_date"]
);
?>
</td>

<td>

<span class="status
<?php echo strtolower($row["status"]); ?>">

<?php
echo htmlspecialchars(
$row["status"]
);
?>

</span>

</td>

</tr>

<?php endwhile; ?>

</table>

</div>

</div>

</main>

</body>

</html>