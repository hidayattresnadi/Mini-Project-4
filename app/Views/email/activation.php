<!DOCTYPE html>
<html>

<head>
    <title>User Account Activation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
        }

        h2 {
            color: #333;
        }

        p {
            font-size: 16px;
            color: #555;
        }

        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #888;
        }
    </style>
</head>

<body>
    <p>This is activation email for your account on <?= site_url() ?>.</p>

    <p>To Complete Registration on your account please Confirm by click this url below:</p>

    <p><a href="<?= url_to('activate-account') . '?token=' . $hash ?>">Activate account</a>.</p>

    <br>

    <p>If you did not registered on this website, you can safely ignore this email.</p>

</body>

</html>