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

    $title =
        trim($_POST["title"]);

    $message =
        trim($_POST["message"]);


    $stmt = $conn->prepare(
        "INSERT INTO announcements
        (title, message, posted_by)
        VALUES (?, ?, ?)"
    );


    $stmt->bind_param(
        "ssi",
        $title,
        $message,
        $_SESSION["user_id"]
    );


    $stmt->execute();

}


$announcements =
    $conn->query(
        "SELECT
            announcements.*,
            users.full_name
         FROM announcements
         JOIN users
         ON announcements.posted_by = users.id
         ORDER BY announcements.created_at DESC"
    );

?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Announcements</title>

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

<h1>📢 Announcements</h1>


<?php if ($_SESSION["role"] === "TEACHER"): ?>

<div class="dashboard-card">

<h2>Create Announcement</h2>

<form method="POST">

<label>Title</label>

<input
type="text"
name="title"
placeholder="Announcement title"
required
>


<label>Message</label>

<textarea
name="message"
rows="5"
placeholder="Write announcement..."
required
></textarea>


<button class="main-button">

Post Announcement

</button>

</form>

</div>

<?php endif; ?>


<?php while (
$announcement =
$announcements->fetch_assoc()
): ?>

<div class="announcement-card">

<h2>

<?php
echo htmlspecialchars(
$announcement["title"]
);
?>

</h2>

<p>

<?php
echo nl2br(
htmlspecialchars(
$announcement["message"]
)
);
?>

</p>

<small>

Posted by
<?php
echo htmlspecialchars(
$announcement["full_name"]
);
?>

</small>

</div>

<?php endwhile; ?>

</main>

</body>

</html>