<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Options</title>
    <!-- Link Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #4e54c8, #8f94fb);
            /* Background gradient */
            height: 100vh;
            /* Set height to full viewport */
            display: flex;
            /* Use flexbox */
            align-items: center;
            /* Center vertically */
            justify-content: center;
            /* Center horizontally */
            margin: 0;
            /* Remove default margin */
        }

        .login-card {
            background-color: #FFC107;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            color: #000;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s, box-shadow 0.2s;
            text-decoration: none;
            display: block;
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
        }

        .login-card img {
            width: 80px;
            height: 80px;
            margin-bottom: 15px;
        }

        .gray-card {
            background-color: #6c757d;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row g-4 justify-content-center">
            <!-- Operator -->
            <div class="col-md-3">
                <a href="{{ route('operator.login') }}" class="login-card">
                    <img src="{{ asset('images/operator-icon.png') }}" alt="Operator Icon">
                    <h5 class="mt-2">OPERATOR</h5>
                </a>
            </div>
            <!-- Pengusul -->
            <div class="col-md-3">
                <a href="{{ route('pengusul.login') }}" class="login-card">
                    <img src="{{ asset('images/pengusul-icon.png') }}" alt="Pengusul Icon">
                    <h5 class="mt-2">PENGUSUL</h5>
                </a>
            </div>
            <!-- Dosen -->
            <div class="col-md-3">
                <a href="{{ route('dosen-pendamping.login') }}" class="login-card">
                    <img src="{{ asset('images/dosen-icon.png') }}" alt="Dosen Icon">
                    <h5 class="mt-2">DOSEN</h5>
                </a>
            </div>
            <!-- Pimpinan -->
            <div class="col-md-3">
                <a href="{{ route('perguruan-tinggi.login') }}" class="login-card gray-card">
                    <img src="{{ asset('images/pimpinan-icon.png') }}" alt="Pimpinan Icon">
                    <h5 class="mt-2">PIMPINAN PT</h5>
                </a>
            </div>
        </div>
        <div class="mt-4 text-center">
            <a href="/" class="btn btn-secondary">Kembali</a>
        </div>
    </div>

    <!-- Link Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
