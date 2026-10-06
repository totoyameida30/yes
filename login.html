<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>NFC School Login</title>

    <link rel="stylesheet" href="style.css">

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .login-body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background:
                linear-gradient(135deg, #001f3f, #003d66, #006699);
        }

        .login-box {
            width: 400px;
            max-width: 92%;
            padding: 35px;
            border-radius: 20px;
            background: rgba(255,255,255,0.96);
            box-shadow: 0 20px 50px rgba(0,0,0,0.35);
            text-align: center;
        }

        .login-logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 15px;

            display: flex;
            justify-content: center;
            align-items: center;

            border-radius: 50%;

            background: #003d66;

            color: white;

            font-size: 38px;

            box-shadow: 0 8px 20px rgba(0,0,0,0.25);
        }

        h1 {
            margin: 5px 0;
            color: #002b49;
        }

        .muted {
            color: #777;
            margin-bottom: 25px;
        }

        form {
            text-align: left;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 7px;

            font-weight: bold;
            color: #333;
        }

        input {
            width: 100%;
            padding: 13px;

            border: 1px solid #ccc;
            border-radius: 10px;

            font-size: 15px;

            outline: none;
        }

        input:focus {
            border-color: #006699;
            box-shadow: 0 0 0 3px rgba(0,102,153,0.12);
        }

        button,
        .secondary-button {
            width: 100%;
            display: block;

            padding: 13px;

            border: none;
            border-radius: 10px;

            font-size: 16px;
            font-weight: bold;

            cursor: pointer;

            text-decoration: none;
            text-align: center;
        }

        .main-button {
            margin-top: 20px;

            background: #003d66;
            color: white;
        }

        .main-button:hover {
            background: #002b49;
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 10px;

            margin: 25px 0;

            color: #999;
            font-size: 13px;
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background: #ddd;
        }

        /* NFC AREA */

        .nfc-area {
            padding: 22px 15px;

            border: 2px dashed #006699;

            border-radius: 15px;

            background: #f4fbff;

            cursor: pointer;

            transition: 0.3s;
        }

        .nfc-area:hover {
            background: #e7f6ff;
            transform: translateY(-2px);
        }

        .nfc-icon {
            font-size: 45px;

            animation: pulse 1.8s infinite;
        }

        .nfc-title {
            margin-top: 8px;

            font-size: 18px;
            font-weight: bold;

            color: #003d66;
        }

        .nfc-status {
            margin-top: 8px;

            color: #777;

            font-size: 13px;
        }

        .nfc-button {
            margin-top: 15px;

            background: #006699;
            color: white;
        }

        .nfc-button:hover {
            background: #004d73;
        }

        .secondary-button {
            background: #e9f3f8;
            color: #003d66;
        }

        .secondary-button:hover {
            background: #d9ebf4;
        }

        .bottom-text {
            margin-top: 20px;

            font-size: 12px;

            color: #888;

            line-height: 1.5;
        }

        .success {
            color: #159447;
            font-weight: bold;
        }

        .error {
            color: #d62828;
            font-weight: bold;
        }

        @keyframes pulse {

            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.08);
            }

            100% {
                transform: scale(1);
            }

        }

    </style>

</head>


<body class="login-body">


<div class="login-box">

    <div class="login-logo">
        📡
    </div>


    <h1>NFC School</h1>

    <p class="muted">
        Student & Teacher Portal
    </p>


    <!-- NORMAL LOGIN -->

    <form action="login_process.php"
          method="POST">

        <label>
            Username or Email
        </label>

        <input
            type="text"
            name="identity"
            placeholder="Username or email"
            required
        >


        <label>
            Password
        </label>

        <input
            type="password"
            name="password"
            placeholder="Password"
            required
        >


        <button
            type="submit"
            class="main-button">

            Login

        </button>

    </form>


    <div class="divider">
        OR
    </div>


    <!-- NFC LOGIN -->

    <div class="nfc-area"
         onclick="startNFC()">

        <div class="nfc-icon">
            📡
        </div>

        <div class="nfc-title">
            Tap NFC Card
        </div>

        <div
            id="nfcStatus"
            class="nfc-status">

            Tap your registered NFC card to login automatically.

        </div>


        <button
            type="button"
            class="nfc-button"
            onclick="event.stopPropagation(); startNFC();">

            Scan NFC Card

        </button>

    </div>


    <br>


    <a
        href="register.php"
        class="secondary-button">

        Create Account

    </a>


    <p class="bottom-text">

        NFC identification is available
        after account registration.

        <br>

        Your NFC card must be registered
        to your student account.

    </p>

</div>


<script>

async function startNFC() {

    const status =
        document.getElementById("nfcStatus");


    /*
     * Check if Web NFC is available
     */

    if (!("NDEFReader" in window)) {

        status.innerHTML =
            '<span class="error">' +
            'NFC scanning is not supported by this browser/device.' +
            '</span><br>' +
            'Use a compatible NFC device or external NFC reader.';

        return;

    }


    try {

        status.innerHTML =
            "📡 Waiting for NFC card...";


        const ndef =
            new NDEFReader();


        await ndef.scan();


        status.innerHTML =
            "📡 Please tap your NFC card now...";


        ndef.addEventListener(
            "reading",
            ({ serialNumber }) => {

                console.log(
                    "NFC UID:",
                    serialNumber
                );


                status.innerHTML =
                    '<span class="success">' +
                    'Card detected! Logging in...' +
                    '</span>';


                /*
                 * Send NFC UID to PHP
                 */

                fetch("nfc_login.php", {

                    method: "POST",

                    headers: {
                        "Content-Type":
                            "application/x-www-form-urlencoded"
                    },

                    body:
                        "nfc_uid=" +
                        encodeURIComponent(serialNumber)

                })

                .then(response =>
                    response.json()
                )

                .then(data => {

                    if (data.success) {

                        status.innerHTML =
                            '<span class="success">' +
                            'Welcome, ' +
                            data.name +
                            '! Redirecting...' +
                            '</span>';


                        window.location.href =
                            data.redirect;

                    }

                    else {

                        status.innerHTML =
                            '<span class="error">' +
                            data.message +
                            '</span>';

                    }

                })

                .catch(error => {

                    console.error(error);

                    status.innerHTML =
                        '<span class="error">' +
                        'Unable to connect to the server.' +
                        '</span>';

                });

            }
        );


    }

    catch(error) {

        console.error(error);


        status.innerHTML =
            '<span class="error">' +
            'NFC scanning could not be started.' +
            '</span>';

    }

}

</script>


</body>

</html>
