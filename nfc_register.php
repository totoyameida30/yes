<?php

session_start();

if (!isset($_SESSION["registered_user_id"])) {

    header("Location: register.php");

    exit();

}

include "db.php";

$user_id = $_SESSION["registered_user_id"];

$stmt = $conn->prepare(
    "SELECT *
     FROM users
     WHERE id = ?"
);

$stmt->bind_param("i", $user_id);

$stmt->execute();

$user = $stmt->get_result()->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>NFC Card Registration</title>

<link rel="stylesheet" href="style.css">

</head>

<body class="nfc-body">

<div class="nfc-card">

<div class="nfc-animation">

<div class="nfc-circle">

📡

</div>

</div>


<h1>Connect NFC Card</h1>

<p class="nfc-description">

Hello,
<strong>
<?php echo htmlspecialchars($user["full_name"]); ?>
</strong>

</p>

<p>

Place your NFC card near the back
of your Android phone.

</p>


<div id="status"
class="nfc-status">

Ready to scan your NFC card...

</div>


<button
id="scanButton"
class="main-button"
onclick="startNFC()">

📡 Scan NFC Card

</button>


<div
id="result"
class="nfc-result">
</div>


<a
href="login.php"
class="skip-link">

Skip for now

</a>

</div>


<script>

async function startNFC() {

    const status =
        document.getElementById("status");

    const result =
        document.getElementById("result");

    const button =
        document.getElementById("scanButton");


    if (!("NDEFReader" in window)) {

        status.innerHTML =
        "❌ Web NFC is not supported by this browser.";

        result.innerHTML = `
            <div class="warning">
            Use a compatible Android phone
            with NFC and Chrome.
            </div>
        `;

        return;

    }


    try {

        button.disabled = true;

        button.innerHTML =
            "📡 Waiting for card...";

        status.innerHTML =
            "Hold your NFC card near your phone...";


        const ndef =
            new NDEFReader();


        await ndef.scan();


        ndef.onreading = event => {

            const serialNumber =
                event.serialNumber;


            if (!serialNumber) {

                status.innerHTML =
                    "Unable to read NFC identifier.";

                return;

            }


            status.innerHTML =
                "✅ NFC card detected!";


            result.innerHTML = `
                <div class="success">
                    <strong>NFC Card Detected</strong>
                    <br>
                    UID:
                    ${serialNumber}
                </div>
            `;


            saveNFC(serialNumber);

        };


        ndef.onreadingerror = () => {

            status.innerHTML =
                "❌ Could not read the NFC card.";

        };


    } catch(error) {

        console.error(error);

        status.innerHTML =
            "❌ NFC scanning failed.";

        button.disabled = false;

        button.innerHTML =
            "📡 Scan NFC Card";

    }

}


async function saveNFC(uid) {

    const formData =
        new FormData();

    formData.append(
        "nfc_uid",
        uid
    );


    try {

        const response =
            await fetch(
                "nfc_save.php",
                {
                    method: "POST",
                    body: formData
                }
            );


        const data =
            await response.json();


        if (data.success) {

            document.getElementById("status")
                .innerHTML =
                "🎉 NFC card registered!";


            document.getElementById("result")
                .innerHTML = `
                    <div class="success">
                        ${data.message}
                        <br><br>
                        Redirecting to login...
                    </div>
                `;


            setTimeout(
                () => {
                    window.location.href =
                        "login.php";
                },
                2500
            );


        } else {

            document.getElementById("status")
                .innerHTML =
                "❌ Registration failed.";

            document.getElementById("result")
                .innerHTML = `
                    <div class="warning">
                        ${data.message}
                    </div>
                `;

        }


    } catch(error) {

        console.error(error);

        document.getElementById("status")
            .innerHTML =
            "❌ Server error.";

    }

}

</script>

</body>
</html>