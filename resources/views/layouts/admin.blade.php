<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title', 'Pertashop POS')
    </title>

</head>

<body>

    <header>
        <h2>PERTASHOP POS</h2>

        <p>
            Admin: {{ Auth::user()->nama }}
        </p>
    </header>


    <main>

        @yield('content')

    </main>

</body>

</html>