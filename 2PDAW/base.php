<!DOCTYPE html>
<html>
<html lang="es-mx">

<head>
    <!--Import materialize.css-->
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" media="screen,projection" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <meta content="text/html; charset=UTF-8" http-equiv="content-type">
    <title>Examen de segundo parcial</title>
</head>

<body>
    <header></header>

    <main>

        <div class="navbar-fixed">
            <nav>
                <div class="blue darken-1 nav-wrapper">
                    <a href="index.php" class="brand-logo"><acronym title="Desarrollo de aplicaciones web y Bases de datos">Segundo parcial: DAW-BD</acronym></a>
                    <ul id="nav-mobile" class="right">
                        <li><a href="#">Consultas</a></li>
                    </ul>
                </div>
            </nav>
        </div>

        <div class="container">

            <h3>Zombis</h3>

            <a class="right btn-floating btn-large waves-effect waves-light red"><i class="material-icons">add</i></a>

            <table class="highlight">
                <thead>
                    <tr>
                        <th>Zombie</th>
                        <th>Estados</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Eduardo</td>
                        <td>infección (2003-08-11 07:05:00)
                            <br>desorientación (2005-08-14 11:35:00)
                            <br>violencia (2013-08-12 10:05:00)
                            <br>desmayo (2019-10-25 13:05:00)
                            <br>
                            <a class="waves-effect waves-light btn"><i class="material-icons left">add</i>Registrar estado</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Ricardo</td>
                        <td>infección (2005-08-14 11:35:00)
                            <br>desorientación (2013-08-12 10:05:00)
                            <br>violencia (2014-08-12 10:05:00)
                            <br>
                            <a class="waves-effect waves-light btn"><i class="material-icons left">add</i>Registrar estado</a>
                        </td>
                    </tr>
                    <tr>
                        <td>Tú</td>
                        <td>infección (2019-10-25 13:05:00)
                            <br>
                            <a class="waves-effect waves-light btn"><i class="material-icons left">add</i>Registrar estado</a></td>
                    </tr>
                </tbody>
            </table>

        </div>
    </main>

    <footer class="blue darken-1 page-footer">
        <div class="container">
            <p class="grey-text text-lighten-4">Powered by <a href="http://materializecss.com/" target="_blank" class="white-text text-lighten-4">Materialize</a>.</p>
        </div>
        <div class="footer-copyright">
            <div class="container">
                © 2019 Escuela de Ingeniería y Ciencias - Tecnológico de Monterrey en Querétaro.
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

</body>

</html>
