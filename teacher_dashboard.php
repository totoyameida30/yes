<?php

session_start();

if (
    !isset($_SESSION["user_id"]) ||
    $_SESSION["role"] !== "TEACHER"
) {

    header("Location: login.php");

    exit();

}

include "db.php";


$students =
    $conn->query(
        "SELECT COUNT(*) AS total
         FROM users
         WHERE role = 'STUDENT'"
    )->fetch_assoc()["total"];


$attendance =
    $conn->query(
        "SELECT COUNT(*) AS total
         FROM attendance"
    )->fetch_assoc()["total"];


$grades =
    $conn->query(
        "SELECT COUNT(*) AS total
         FROM grades"
    )->fetch_assoc()["total"];


$quizzes =
    $conn->query(
        "SELECT COUNT(*) AS total
         FROM quizzes"
    )->fetch_assoc()["total"];

?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Teacher Dashboard</title>

<link rel="stylesheet"
href="style.css">

</head>


<body class="dashboard-body">


<aside class="sidebar">

<h2>📡 NFC Portal</h2>

<p class="role-label">
TEACHER
</p>


<a href="teacher_dashboard.php">
🏠 Dashboard
</a>

<a href="attendance.php">
📅 Attendance
</a>

<a href="grades.php">
📊 Grades
</a>

<a href="quizzes.php">
📝 Quizzes
</a>

<a href="recitation.php">
🎤 Recitation
</a>

<a href="schedule.php">
🗓 Schedule
</a>

<a href="announcements.php">
📢 Announcements
</a>


<a
href="logout.php"
class="logout">
🚪 Logout
</a>

</aside>


<main class="main-content">


<div class="topbar">

<div>

<h1>
Welcome,
<?php echo htmlspecialchars(
$_SESSION["full_name"]
); ?>
</h1>

<p>
Teacher Dashboard
</p>

</div>


<div class="profile-circle">
👨‍🏫
</div>

</div>


<div class="stats-grid">


<div class="stat-card">

<div class="stat-icon">
🎓
</div>

<h3>
<?php echo $students; ?>
</h3>

<p>Total Students</p>

</div>


<div class="stat-card">

<div class="stat-icon">
📅
</div>

<h3>
<?php echo $attendance; ?>
</h3>

<p>Attendance Records</p>

</div>


<div class="stat-card">

<div class="stat-icon">
📊
</div>

<h3>
<?php echo $grades; ?>
</h3>

<p>Grade Records</p>

</div>


<div class="stat-card">

<div class="stat-icon">
📝
</div>

<h3>
<?php echo $quizzes; ?>
</h3>

<p>Quiz Records</p>

</div>

</div>


<div class="dashboard-card">

<h2>Teacher Functions</h2>

<div class="quick-grid">

<a href="attendance.php">
📅
<strong>Record Attendance</strong>
</a>

<a href="grades.php">
📊
<strong>Record Grades</strong>
</a>

<a href="quizzes.php">
📝
<strong>Record Quiz</strong>
</a>

<a href="recitation.php">
🎤
<strong>Record Recitation</strong>
</a>

<a href="schedule.php">
🗓
<strong>Manage Schedule</strong>
</a>

<a href="announcements.php">
📢
<strong>Announcements</strong>
</a>

</div>

</div>

</main>

</body>

</html>