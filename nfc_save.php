<?php

session_start();

header("Content-Type: application/json");

include "db.php";


if (!isset($_SESSION["registered_user_id"])) {

    echo json_encode([
        "success" => false,
        "message" => "Registration session expired."
    ]);

    exit();

}


$user_id =
    $_SESSION["registered_user_id"];


$nfc_uid =
    trim($_POST["nfc_uid"] ?? "");


if ($nfc_uid === "") {

    echo json_encode([
        "success" => false,
        "message" => "NFC UID is empty."
    ]);

    exit();

}


$check = $conn->prepare(
    "SELECT id
     FROM users
     WHERE nfc_uid = ?"
);

$check->bind_param(
    "s",
    $nfc_uid
);

$check->execute();

$result =
    $check->get_result();


if ($result->num_rows > 0) {

    echo json_encode([
        "success" => false,
        "message" => "This NFC card is already registered."
    ]);

    exit();

}


$stmt = $conn->prepare(
    "UPDATE users
     SET nfc_uid = ?,
         nfc_registered_at = NOW()
     WHERE id = ?"
);

$stmt->bind_param(
    "si",
    $nfc_uid,
    $user_id
);


if ($stmt->execute()) {

    unset(
        $_SESSION["registered_user_id"]
    );

    echo json_encode([
        "success" => true,
        "message" => "NFC card successfully connected to your account."
    ]);

} else {

    echo json_encode([
        "success" => false,
        "message" => "Unable to save NFC card."
    ]);

}

?>