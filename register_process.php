<?php

session_start();

include "db.php";


if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: register.php");
    exit();
}


$full_name = trim($_POST["full_name"]);
$username = trim($_POST["username"]);
$school_id = trim($_POST["school_id"]);
$email = trim($_POST["email"]);

$role = $_POST["role"];

$course = trim($_POST["course"] ?? "");
$section = trim($_POST["section"] ?? "");

$password = $_POST["password"];
$confirm_password = $_POST["confirm_password"];


if (
    empty($full_name) ||
    empty($username) ||
    empty($school_id) ||
    empty($email) ||
    empty($password)
) {

    die("Please complete all required fields.");

}


if ($password !== $confirm_password) {

    die("Passwords do not match.");

}


if (!in_array($role, ["STUDENT", "TEACHER"])) {

    die("Invalid role.");

}


$check = $conn->prepare(
    "SELECT id FROM users
     WHERE username = ? OR email = ?"
);

$check->bind_param(
    "ss",
    $username,
    $email
);

$check->execute();

$result = $check->get_result();


if ($result->num_rows > 0) {

    die("Username or email already exists.");

}


$hashed_password = password_hash(
    $password,
    PASSWORD_DEFAULT
);


$stmt = $conn->prepare(
    "INSERT INTO users
    (
        full_name,
        username,
        email,
        password,
        role,
        student_teacher_id,
        course,
        section
    )
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
);


$stmt->bind_param(
    "ssssssss",
    $full_name,
    $username,
    $email,
    $hashed_password,
    $role,
    $school_id,
    $course,
    $section
);


if ($stmt->execute()) {

    $_SESSION["registered_user_id"] =
        $stmt->insert_id;

    $_SESSION["registered_name"] =
        $full_name;

    $_SESSION["registered_role"] =
        $role;

    header("Location: nfc_register.php");

    exit();

}


echo "Registration failed.";

?>