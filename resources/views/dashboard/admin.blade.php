<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
</head>
<body>

    <h1>Dashboard Admin</h1>

    <p>Selamat datang, {{ Auth::user()->nama }}</p>

    <p>Role : {{ Auth::user()->role }}</p>

</body>
</html>