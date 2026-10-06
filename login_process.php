<?php

session_start();

include "db.php";


if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: login.php");

    exit();

}


$identity =
    trim($_POST["identity"]);

$password =
    $_POST["password"];


$stmt = $conn->prepare(
    "SELECT *
     FROM users
     WHERE username = ?
     OR email = ?
     LIMIT 1"
);


$stmt->bind_param(
    "ss",
    $identity,
    $identity
);

$stmt->execute();


$result =
    $stmt->get_result();


if ($result->num_rows !== 1) {

    die("Invalid username/email or password.");

}


$user =
    $result->fetch_assoc();


if (
    !password_verify(
        $password,
        $user["password"]
    )
) {

    die("Invalid username/email or password.");

}


session_regenerate_id(true);


$_SESSION["user_id"] =
    $user["id"];

$_SESSION["full_name"] =
    $user["full_name"];

$_SESSION["role"] =
    $user["role"];

$_SESSION["nfc_uid"] =
    $user["nfc_uid"];


if ($user["role"] === "STUDENT") {

    header(
        "Location: student_dashboard.php"
    );

    exit();

}


if ($user["role"] === "TEACHER") {

    header(
        "Location: teacher_dashboard.php"
    );

    exit();

}

?>