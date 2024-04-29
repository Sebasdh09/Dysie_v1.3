<?php
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['email'])) {
    $_SESSION["error"] = "Debes iniciar sesión para acceder a esta página.";
    header("Location: ../registro/login.php");
    exit();
}

// Conexión a la base de datos (configura con tus propios valores)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dysie";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta SQL para obtener los tableros del usuario actual
$email = $_SESSION['email'];
$sql = "SELECT * FROM tablero WHERE email = '$email'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Kanban Dysie</title>

    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />

    <link rel="stylesheet" href="../aos-master/dist/aos.css" /> <!-- AOS ANIMATE -->
    <link rel="preconnect" href="https://fonts.googleapis.com"> <!-- OUTFIT GOOGLE FONT -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> <!-- OUTFIT GOOGLE FONT -->
    <link
    href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Outfit:wght@100..900&display=swap"
    rel="stylesheet"> <!-- OUTFIT GOOGLE FONT -->

    <!-- Bootstrap icons
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />-->

    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="../estilos/styles.css" rel="stylesheet" />

    <link href="estilosIndex.css" rel="stylesheet" />
    <link href="../index.css" rel="stylesheet" />

</head>

<!-- HEADER -->

<header>
    <a href="" class="logo"><img class="" src="../assets/logoDysie.png" alt=""></a>
    <nav>
        <ul>
            <li><a href="../index.html">Inicio</a></li>
            <a href="../logout.php" class="botonDysie"
                style="font-size: 20px; box-shadow: 0px 20px 60px -20px rgba(0,0,0, 0.5); padding: 10px 30px; margin: 0px 10px;">
                Cerrar Sesión
            </a>
            <a href="../usuario/view_accounts.php" class="botonDysie"
                style="font-size: 20px; box-shadow: 0px 20px 60px -20px rgba(0,0,0, 0.5); padding: 10px 30px; margin: 0px 10px;">
                Mi Perfil
            </a>
        </ul>
    </nav>
</header>
<!-- SCRIPT CANIMACIÓN HEADER -->
<script type="text/javascript">
    window.addEventListener("scroll", function () {
        var header = document.querySelector("header");
        header.classList.toggle("abajo", window.scrollY > 0);
    })
</script>

<!-- Responsive navbar HEADER BOOSTRAP
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container px-5">
        <a class="logo" href="index.php">
            <img src="../assets/Dysie (3).png" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span
                class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="btn btn-outline-light" href="../logout.php" style="margin-right: 10px;">Cerrar Sesion</a></li>
                <li class="nav-item"><a class="btn btn-primary" href="../usuario/view_accounts.php">Perfil</a></li>
            </ul>
        </div>
    </div>
</nav>-->
</head>

<body>
    <div class="container ">
        <div class="board">
            <h1 class="titulo-index">Agrega, Edita y Elimina tableros</h1>
            <h3 class="parrafo-index">¡Agrega etiquetas dentro de tu tablero, editalas <br> y una vez completadas
                eliminalas!</h3>

            <div class="cuadrado-contenido">
                <h1 class="agrega-txt">Agrega un Tablero</h1>
                <form action="../tableros/guardar_tablero.php" method="POST">
                    <input type="text" name="nombre-tablero" class="tablero-nombre-i" placeholder="Nombre del tablero"
                        required><br><br>
                    <!-- ESTO ES OPCIONAL <label for="color-tablero" class="color-tablero">Color Del Tablero:</label>-->
                    <select class="seleccionar" name="color-tablero" required>
                        <option class="opciones" value="#4496ff">Azul</option>
                        <option class="opciones" value="#fe44ff">Rosado</option>
                        <option class="opciones" value="#a832ff">Morado</option>
                        <option class="opciones" value="#28bf2e">Verde</option>
                        <option class="opciones" value="#585858">Gris</option>
                        <hr>
                        <option class="opciones" value="linear-gradient(125deg, #ff5f60, #f9d423);">Amarillo / Naranja</option>
                        <option class="opciones" value="linear-gradient(125deg, #197fff, #ff75ed);">Azul / Rosado</option>
                        <option class="opciones" value="linear-gradient(125deg, #4bff00, #4d00ff);">Verde / Morado</option>
                        <option class="opciones" value="linear-gradient(125deg, #006ccf, #00ffaa);">Dysie Colors</option>
                    </select>
                    <button class="btn-tablero" type="submit">Añadir tablero</button>
            </div>
            <h1 class="mis-tableros-txt">Mis Tableros</h1>
            </form>
            <div class="row">

                <?php
                $tableros_per_row = 3; // Cantidad de tableros por fila
                $count = 0;

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        if ($count % $tableros_per_row === 0) {
                            if ($count > 0) {
                                echo '</div><div class="row">';
                            }
                        }
                        echo '<div class="col-md-' . 12 / $tableros_per_row . '">';
                        
                        echo '<div class="tablero-box" data-aos="fade-up" data-aos-duration="700" style="';

                        // Verifica si el color almacenado es un gradiente
                        if (strpos($row['color'], 'linear-gradient') !== false) {
                            // Si es un gradiente, aplica el estilo de fondo con background-image
                            echo 'background-image: ' . $row['color'] . ';';
                        } else {
                            // Si es un color sólido, aplica el estilo de fondo con background-color
                            echo 'background-color: ' . $row['color'] . ';';
                        }
                        
                        echo '">'; // Cierre del estilo inline

                        // POR SI TODO SE ME VA A LA MRDA =============== echo '<div class="tablero-box" style="background-color:' . $row['color'] . ';">'; // Agrega el color del tablero al estilo
                        //echo '<div class="tablero-box" style="background-color:' . $row['color'] . ';">'; // Agrega el color del tablero al estilo

                        // Agregar el botón de edición con el ícono de pincel al lado izquierdo del título
                        echo '<div class="btn-editar" style="background-color:none;">';
                        echo '<a class="btn" href="javascript:void(0);" onclick="mostrarEditor(\'' . $row['id_tablero'] . '\', \'' . $row['nom_tablero'] . '\')"><i class="bi bi-pencil-fill"></i> Editar</a>';
                        echo '</div>';

                        echo '<h1 class="tablero-title" id="tablero-title-' . $row['id_tablero'] . '">' . $row['nom_tablero'] . '</h1>';
                        echo '<a class="btn btn-danger btn-delete" href="../tableros/eliminar_tablero.php?id_tablero=' . $row['id_tablero'] . '">&#10006;</a>'; // Botón de eliminación


                        // Consulta SQL para obtener las tarjetas del tablero actual
                        $idTablero = $row['id_tablero'];
                        $sql_tarjetas = "SELECT * FROM tarjeta WHERE id_tablero = '$idTablero'";
                        $result_tarjetas = $conn->query($sql_tarjetas);

                        echo '<div class="tarjetas-container">';

                        if ($result_tarjetas->num_rows > 0) {
                            while ($row_tarjeta = $result_tarjetas->fetch_assoc()) {
                                echo '<div class="tarjeta" id="tarjeta-' . $row_tarjeta['id_tarjetas'] . '" style="background-color: ' . $row_tarjeta['color'] . ';">';
                                echo '<p class="tarjeta-nombre">' . $row_tarjeta['nom_tarjeta'] . '</p>';
                                echo '<div class="botones-tarjeta">';
                                echo '<a class="btn-editar-tarjeta" href="javascript:void(0);" onclick="mostrarEditorTarjeta(\'' . $row_tarjeta['id_tarjetas'] . '\', \'' . $row_tarjeta['nom_tarjeta'] . '\')"><i class="bi bi-pencil-fill"></i> Editar</a>';
                                echo '<a class="btn-eliminar-tarjeta btn btn-danger" href="../tarjetas/eliminar_tarjeta.php?id_tarjetas=' . $row_tarjeta['id_tarjetas'] . '">&#10006;</a>';
                                echo '</div>';
                                echo '</div>';
                            }
                        } else {
                            echo '<p class="parrafo-tarjeta">Aún no has creado ninguna tarjeta aquí <br> ¡Crea una ahora!</p>';
                        }

                        // Formulario para agregar tarjetas (asegúrate de incluir el ID del tablero)
                        echo '<form action="../tarjetas/agregar_tarjeta.php" method="POST" id="nueva_tarjeta">';
                        echo '<input type="hidden" name="id_tablero" value="' . $idTablero . '">';
                        echo '<input type="text" name="nombre-tarjeta" class="nombre-tarjeta" placeholder="Nombre de la tarjeta" required>';
                        echo '<button class="btn-tarjeta" type="submit">Agregar tarjeta</button>';
                        echo '</form>';

                        echo '</div>'; // Cierre de tarjetas-container
                        echo '</div>'; // Cierre de tablero-box
                        echo '</div>'; // Cierre de col-md-4
                        $count++;
                    }
                } else {
                    echo '<p class="parrafo-tablero">Opps! Parece que no has creado ningún tablero. <br> ¡Crea uno ahora!.</p>';
                }
                ?>
            </div>
        </div>
    </div>
    <!-- Formulario emergente para la edición de tableros -->
    <div id="modalEditar" class="modal">
        <div class="modal-content">
            <span class="close" onclick="cerrarEditor()">&times;</span>
            <h2>Editar Tablero</h2>
            <form id="formEditarTablero" action="../tableros/editar_tablero.php" method="POST">
                <input type="hidden" id="editTableroId" name="id_tablero">
                <label for="editTableroNombre">Nuevo Nombre:</label>
                <input type="text" id="editTableroNombre" name="nombre_tablero" required>
                <label for="editTableroColor">Nuevo Color:</label>
                <select id="editTableroColor" name="color_tablero" required>
                        <option class="opciones" value="#4496ff">Azul</option>
                        <option class="opciones" value="#fe44ff">Rosado</option>
                        <option class="opciones" value="#a832ff">Morado</option>
                        <option class="opciones" value="#28bf2e">Verde</option>
                        <option class="opciones" value="#585858">Gris</option>
                        <hr>
                        <option class="opciones" value="linear-gradient(125deg, #ff5f60, #f9d423);">Amarillo / Naranja</option>
                        <option class="opciones" value="linear-gradient(125deg, #197fff, #ff75ed);">Azul / Rosado</option>
                        <option class="opciones" value="linear-gradient(125deg, #4bff00, #4d00ff);">Verde / Morado</option>
                        <option class="opciones" value="linear-gradient(125deg, #006ccf, #00ffaa);">Dysie Colors</option>
                    <!-- Agrega más opciones según sea necesario -->
                </select>
                <button class="btn-tablero" type="submit">Guardar Cambios</button>
            </form>
        </div>
    </div>

    <div id="modalEditarTarjeta" class="modal">
        <div class="modal-content">
            <span class="close" onclick="cerrarEditorTarjeta()">&times;</span>
            <h2>Editar Nombre de Tarjeta</h2>
            <form id="formEditarTarjeta" action="../tarjetas/editar_tarjeta.php" method="POST">
                <input type="hidden" id="editTarjetaId" name="id_tarjetas">
                <label for="editTarjetaNombre">Nuevo Nombre:</label>
                <input type="text" id="editTarjetaNombre" name="nombre_tarjeta" required>
                <button onclick="guardarCambiosTarjeta()" class="btn-tablero" type="submit">Guardar Cambios</button>
            </form>
        </div>
    </div>

    <script>
        function mostrarEditor(idTablero, nombreTablero, colorTablero) {
            document.getElementById('editTableroId').value = idTablero;
            document.getElementById('editTableroNombre').value = nombreTablero;

            // Selecciona la opción correspondiente en la lista desplegable
            var select = document.getElementById('editTableroColor');
            for (var i = 0; i < select.options.length; i++) {
                if (select.options[i].value === colorTablero) {
                    select.selectedIndex = i;
                    break;
                }
            }

            document.getElementById('modalEditar').style.display = 'block';
        }

        function cerrarEditor() {
            document.getElementById('modalEditar').style.display = 'none';
        }
    </script>
    <!-- Aqui esta el de las tarjetas -->
    <script>
        function mostrarEditorTarjeta(idTarjeta, nombreTarjeta) {
            document.getElementById('editTarjetaId').value = idTarjeta;
            document.getElementById('editTarjetaNombre').value = nombreTarjeta;

            document.getElementById('modalEditarTarjeta').style.display = 'block';
        }

        function cerrarEditorTarjeta() {
            document.getElementById('modalEditarTarjeta').style.display = 'none';
        }
    </script>
    <!-- Scripts al final del documento -->
    <script>
        // Deshabilita el botón de retroceso del navegador
        history.pushState(null, null, location.href);
        window.onpopstate = function () {
            history.go(1);
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

<!-- FOOTER - PIE DE PÁGINA -->

<footer>
    <div class="contenedor-footer">
        <div class="footer-contentido">
            <div class="nombre-p">
                <h2>Dysie - </h2>
            </div>
            <div class="redes-sociales">
                <a href="#"><img src="../assets/redes-sociales/fb-logo.png" alt="Facebook"></a>
                <a href="#"><img src="../assets/redes-sociales/x-logo2.png" alt="Twitter"></a>
                <a href="#"><img src="../assets/redes-sociales/ig-logo.png" alt="Instagram"></a>
            </div>
        </div>
        <div class="derechos-reservados">
            <p>Derechos Reservados - Dysie &copy; 2024</p>
        </div>
    </div>
</footer>

<!-- 
<footer class="py-5 bg-dark">
    <div class="container px-5">
        <p class="m-0 text-center text-white">Copyright &copy; 2023 Kanban Dysie</p>
    </div>
</footer>-->

  <!-- SCRIPT ANIMACIONES AOS ANIMATE -->

  <script src="../aos-master/dist/aos.js"></script>
  <script>
    AOS.init({
      easing: 'ease-in-out-sine'
    });
  </script>

</html>