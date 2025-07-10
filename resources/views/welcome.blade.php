<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di Jowmail</title>
    <link href="https://fonts.googleapis.com/css?family=Inter:400,600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: #f9f9f9;
            color: #333;
        }
        header {
            background: #2d89ef;
            padding: 40px;
            text-align: center;
            color: white;
        }
        .content {
            max-width: 800px;
            margin: auto;
            padding: 40px 20px;
            text-align: center;
        }
        .button {
            display: inline-block;
            background: #2d89ef;
            color: white;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 20px;
            font-weight: bold;
        }
        footer {
            background: #eee;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 60px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Jowmail</h1>
        <p>Solusi Email Marketing Modern</p>
    </header>

    <div class="content">
        <h2>Bangun dan kirim campaign email dengan mudah</h2>
        <p>Gunakan kekuatan email marketing untuk menjangkau pelanggan Anda. Lacak open rate, atur jadwal pengiriman, dan kirim secara personal dengan mudah.</p>
        <a href="{{ url('/') }}" class="button">Masuk ke Panel</a>
    </div>

    <footer>
        &copy; {{ date('Y') }} Jowmail. All rights reserved.
    </footer>
</body>
</html>