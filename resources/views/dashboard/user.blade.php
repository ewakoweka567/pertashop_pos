<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard User</title>
</head>
<body>

    <h1>Dashboard User</h1>

    <p>Selamat datang, {{ Auth::user()->nama }}</p>

    <p>Role : {{ Auth::user()->role }}</p>

</body>
</html>