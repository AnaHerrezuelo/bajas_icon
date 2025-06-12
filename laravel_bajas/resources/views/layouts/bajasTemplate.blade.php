<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> layout </title>
    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}"> <!-- usar asset para q funcione con todso los entornos -->
</head>
<body>
        <header>
            <div id="logo">  </div>
            <nav><h1>navegador</h1>
             <ul class="menu">
                <li><a href="#"> Link 1 </a></li>
                <li><a href="#"> Link 2 </a></li>
                <li><a href="#"> Link 3 </a></li>
                <li><a href="#"> Link 4 </a></li>
            </ul>
            </nav>
        </header>
        @yield('content')
    </body>
</html>