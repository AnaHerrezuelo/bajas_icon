<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> layout </title>
        <style>
            *{
                margin: 0;     
            }

            body {
                width: 100%;
                margin: 0; 
                background-color: rgb(186, 217, 255);
            }

            header{
                position: fixed;
                background-color: rgb(255, 97, 97);
                height:4em;
                width: 100%;  
                top: 0;
                left: 0;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            }
            
            h1{
                text-align:center;
                padding:0.5em;
            }

            #content{
                background-color:  rgb(239, 239, 239);
                /* height: calc(100vh - 4em); */
                min-height: calc(100vh - 4em); 
                width: 80%;  
                margin: 4em auto 0; 
                padding:1em;
            }

            table { 
                border-collapse: collapse; 
                width: 100%; 
                overflow:hidden;
            }

            th, td { 
                border: 0.10em solid black; 
                padding: 0.5em; 
                text-align: left; 
            }

            th{
                background-color: #ddd;
            }

            .bt1{
                color: black;
                text-decoration: none; 
                background-color: skyblue;
                padding:0.25em;
                border-radius:1em;
                display: inline-block; 
            }
            .bt1:hover {
                color: white; 
                box-shadow: 0 0 5px rgba(0,0,0,0.3); 
                transform: scale(1.07); 
                transition: all 0.3s ease; 
            }


            .form {
                max-width: 90%;
                margin: 2em auto;
                padding: 2em;
                background-color:rgb(254, 145, 67);
                border-radius: 1.5em;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            /* Estilos para las etiquetas */
            .form label {
                display: block;
                margin-bottom: 0.5em;
                font-weight: bold;
                color: #333;
            }

            .form input[type="date"],
            .form input[type="text"] {
                width: 90%;
                padding: 0.6em;
                margin-bottom: 1.5em;
                border: 0.1em solid black;
                border-radius: 4px;
                font-size: 1em;
            }

            @media (max-width: 768px) {
            
                #content{
                    min-height: calc(100vh - 4em); 
                    width: 100% ;  
                    padding:1em;
                }
                .form {
                    padding: 1em;
                    margin: 1em;
                }
            }

        </style>
</head>
<body>
        @yield('header')
        @yield('content')
    </body>
</html>