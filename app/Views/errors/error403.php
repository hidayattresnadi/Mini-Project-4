<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <title>Error 404</title>
    <style>
        .four_zero_four_bg {
            background-image: url(https://cdn.dribbble.com/users/285475/screenshots/2083086/dribbble_1.gif);
            height: 400px;
            background-position: center;
            background-size: contain;
            background-repeat: no-repeat;
            position: relative;
        }

        .four_zero_four_text {
            font-size: 80px;
            font-weight: bold;
            color: black;
            /* Warna teks hitam */
            position: absolute;
            top: -50px;
            /* Geser teks ke atas */
            left: 50%;
            transform: translateX(-50%);
        }

        .contant_box_404 {
            text-align: center;
            max-width: 600px;
        }

        .link_404 {
            color: #fff !important;
            padding: 10px 20px;
            background: #39ac31;
            margin: 20px 0;
            display: inline-block;
            border-radius: 5px;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <section class="page_404 d-flex align-items-center justify-content-center vh-100">
        <div class="text-center">
            <div class="position-relative">
                <h1 class="four_zero_four_text">403</h1> <!-- Teks 404 dipindah ke atas -->
                <div class="four_zero_four_bg"></div>
            </div>
            <div class="contant_box_404">
                <h3 class="h2">Unauthenticated</h3>
                <p>The page you are looking for is not for your role!</p>
                <a href="<?= site_url('/') ?>" class="link_404">Go to Home</a>
            </div>
        </div>
    </section>
</body>

</html>