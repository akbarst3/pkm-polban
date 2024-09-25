<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initialscale=1.0">
    <title>Daftar Mahasiswa</title>
</head>

<body>
    <form action="{{ route('operator.logout') }}" method="post">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
