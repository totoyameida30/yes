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

    $subject =
        trim($_POST["subject"]);

    $day =
        $_POST["day"];

    $start_time =
        $_POST["start_time"];

    $end_time =
        $_POST["end_time"];

    $room =
        trim($_POST["room"]);


    $stmt = $conn->prepare(
        "INSERT INTO schedules
        (
            teacher_id,
            subject,
            day,
            start_time,
            end_time,
            room
        )
        VALUES (?, ?, ?, ?, ?, ?)"
    );


    $stmt->bind_param(
        "isssss",
        $_SESSION["user_id"],
        $subject,
        $day,
        $start_time,
        $end_time,
        $room
    );


    $stmt->execute();

}


if ($_SESSION["role"] === "STUDENT") {

    $records =
        $conn->query(
            "SELECT
                schedules.*,
                users.full_name
             FROM schedules
             JOIN users
             ON schedules.teacher_id = users.id
             ORDER BY
                FIELD(
                    day,
                    'Monday',
                    'Tuesday',
                    'Wednesday',
                    'Thursday',
                    'Friday',
                    'Saturday'
                ),
                start_time"
        );

} else {

    $id =
        $_SESSION["user_id"];

    $records =
        $conn->query(
            "SELECT *
             FROM schedules
             WHERE teacher_id = $id
             ORDER BY start_time"
        );

}

?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Schedule</title>

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

<h1>🗓 Schedule</h1>


<?php if ($_SESSION["role"] === "TEACHER"): ?>

<div class="dashboard-card">

<h2>Add Schedule</h2>

<form method="POST">

<label>Subject</label>

<input
type="text"
name="subject"
required
>


<label>Day</label>

<select name="day">

<option>Monday</option>
<option>Tuesday</option>
<option>Wednesday</option>
<option>Thursday</option>
<option>Friday</option>
<option>Saturday</option>

</select>


<div class="two-column">

<div>

<label>Start Time</label>

<input
type="time"
name="start_time"
required
>

</div>


<div>

<label>End Time</label>

<input
type="time"
name="end_time"
required
>

</div>

</div>


<label>Room</label>

<input
type="text"
name="room"
placeholder="Room 301"
>


<button class="main-button">

Add Schedule

</button>

</form>

</div>

<?php endif; ?>


<div class="dashboard-card">

<h2>Class Schedule</h2>

<div class="table-container">

<table>

<tr>

<th>Subject</th>

<th>Day</th>

<th>Time</th>

<th>Room</th>

<?php if ($_SESSION["role"] === "STUDENT"): ?>

<th>Teacher</th>

<?php endif; ?>

</tr>


<?php while ($row = $records->fetch_assoc()): ?>

<tr>

<td>
<?php
echo htmlspecialchars(
$row["subject"]
);
?>
</td>

<td>
<?php
echo htmlspecialchars(
$row["day"]
);
?>
</td>

<td>

<?php
echo date(
"h:i A",
strtotime($row["start_time"])
);
?>

-

<?php
echo date(
"h:i A",
strtotime($row["end_time"])
);
?>

</td>

<td>
<?php
echo htmlspecialchars(
$row["room"]
);
?>
</td>


<?php if ($_SESSION["role"] === "STUDENT"): ?>

<td>
<?php
echo htmlspecialchars(
$row["full_name"]
);
?>
</td>

<?php endif; ?>

</tr>

<?php endwhile; ?>

</table>

</div>

</div>

</main>

</body>

</html>