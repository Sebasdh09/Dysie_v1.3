<?php
session_start();
// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['email'])) {
    $_SESSION["error"] = "Debes iniciar sesión para acceder a esta página.";
    header("Location: ../registro/login.php");
    exit();
}

    // Conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dysie";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

// Obtener el correo electrónico del usuario que ha iniciado sesión
$user_email = $_SESSION['email'];

// Consulta para obtener los datos del usuario que ha iniciado sesión
$sql = "SELECT id_usuario, nombre_usu, email FROM usuario WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();

$user = null;
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
}

$stmt->close();

// Cerrar la conexión a la base de datos
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Perfil de Usuario</title>

    <link rel="stylesheet" href="../aos-master/dist/aos.css" /> <!-- AOS ANIMATE -->
    <link rel="preconnect" href="https://fonts.googleapis.com"> <!-- OUTFIT GOOGLE FONT -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> <!-- OUTFIT GOOGLE FONT -->
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Outfit:wght@100..900&display=swap"
        rel="stylesheet"> <!-- OUTFIT GOOGLE FONT -->

    <link href="estilosIndex.css" rel="stylesheet" />
    <link href="../index.css" rel="stylesheet" />
    <link href="view_acc.css" rel="stylesheet" />

</head>

<body>

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

    <div class="perfil">
        <h2>Perfil de Usuario</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo Electrónico</th>
                <th>Acciones</th>
            </tr>
            <?php if ($user) { ?>
            <tr>
                <td><?php echo $user["id_usuario"]; ?></td>
                <td><?php echo $user["nombre_usu"]; ?></td>
                <td><?php echo $user["email"]; ?></td>
                <td>
                    <a class="btn-edit" href="edit_usu.php?id_usuario=<?php echo $user["id_usuario"]; ?>">Editar</a>
                    <a class="btn-eliminar"
                        href="delete_usu.php?id_usuario=<?php echo $user["id_usuario"]; ?>">Eliminar</a>
                </td>
            </tr>
            <?php } else { ?>
            <tr>
                <td colspan="4">No se encontró ningún usuario.</td>
            </tr>
            <?php } ?>
        </table>
    </div>


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
</body>

</html>