<?php

session_start();

if (
    !isset($_SESSION["user_id"]) ||
    $_SESSION["role"] !== "STUDENT"
) {

    header("Location: login.php");

    exit();

}

include "db.php";

$user_id =
    $_SESSION["user_id"];


$stmt = $conn->prepare(
    "SELECT *
     FROM users
     WHERE id = ?"
);

$stmt->bind_param(
    "i",
    $user_id
);

$stmt->execute();

$user =
    $stmt->get_result()
    ->fetch_assoc();


$attendance =
    $conn->query(
        "SELECT COUNT(*) AS total
         FROM attendance
         WHERE student_id = $user_id"
    )->fetch_assoc()["total"];


$grades =
    $conn->query(
        "SELECT COUNT(*) AS total
         FROM grades
         WHERE student_id = $user_id"
    )->fetch_assoc()["total"];


$quizzes =
    $conn->query(
        "SELECT COUNT(*) AS total
         FROM quizzes
         WHERE student_id = $user_id"
    )->fetch_assoc()["total"];

?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Student Dashboard</title>

<link rel="stylesheet"
href="style.css">

</head>

<body class="dashboard-body">


<aside class="sidebar">

<h2>📡 NFC Portal</h2>

<p class="role-label">
STUDENT
</p>


<a href="student_dashboard.php">
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
<?php echo htmlspecialchars($user["full_name"]); ?>
</h1>

<p>
Student Dashboard
</p>

</div>


<div class="profile-circle">
🎓
</div>

</div>


<div class="profile-card">

<div>

<h2>
<?php echo htmlspecialchars(
$user["full_name"]
); ?>
</h2>

<p>
ID:
<?php echo htmlspecialchars(
$user["student_teacher_id"]
); ?>
</p>

<p>
<?php echo htmlspecialchars(
$user["course"]
); ?>
-
<?php echo htmlspecialchars(
$user["section"]
); ?>
</p>

</div>


<div class="nfc-badge">

<?php

if (!empty($user["nfc_uid"])) {

    echo "📡 NFC CONNECTED";

} else {

    echo "⚠ NFC NOT CONNECTED";

}

?>

</div>

</div>


<div class="stats-grid">


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

<h2>My NFC Information</h2>

<?php

if (!empty($user["nfc_uid"])) {

?>

<p>

<strong>NFC UID:</strong>

<?php
echo htmlspecialchars(
$user["nfc_uid"]
);
?>

</p>

<p class="connected">
✓ NFC Card Connected
</p>

<?php

} else {

?>

<p>
No NFC card is currently connected.
</p>

<?php

}

?>

</div>

</main>

</body>

</html>