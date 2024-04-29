<?php
session_start();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dysie - Iniciar o Crear Cuenta</title>
    <link rel="shortcut icon" href="../assets/justLogoDysie.png" type="image/x-icon">
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="registro.css">

    <link rel="stylesheet" href="aos-master/dist/aos.css" /> <!-- AOS ANIMATE -->
    <link rel="preconnect" href="https://fonts.googleapis.com"> <!-- OUTFIT GOOGLE FONT -->
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin> <!-- OUTFIT GOOGLE FONT -->
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Outfit:wght@100..900&display=swap"
        rel="stylesheet"> <!-- OUTFIT GOOGLE FONT -->

</head>

<body>
    <?php
    if (isset($_SESSION["error"])) {
        echo '<div class="alert alert-danger">' . $_SESSION["error"] . '</div>';
        unset($_SESSION["error"]); // Limpia la variable de sesión
    }

    if (isset($_SESSION["registro_exitoso"]) && $_SESSION["registro_exitoso"]) {
        echo '<div class="alert alert-success">Registro exitoso. Puedes iniciar sesión ahora.</div>';
        unset($_SESSION["registro_exitoso"]); // Limpia la variable de sesión
    }
    if (isset($_SESSION["error"])) {
        echo '<div class="alert alert-danger">';
        echo $_SESSION["error"];
        echo '</div>';
        unset($_SESSION["error"]);
    }
    if (isset($_SESSION["success"])) {
        echo '<div class="alert alert-success">';
        echo $_SESSION["success"];
        echo '</div>';
        unset($_SESSION["success"]);
    }

    ?>
    <!-- Logo -->
    <div class="logo">
        <a href="../index.html"><img src="../assets/logoDysie.png" alt=""></a>
    </div>
    <main>
        <div class="contenedor__todo">
            <div class="caja__trasera">
                <div class="caja__trasera-login">
                    <h3>¿Ya tienes una cuenta?</h3>
                    <p>Inicia sesión para entrar en la página</p>

                    <button id="btn__iniciar-sesion" class="botonDysie"
                        style="font-size: 20px; box-shadow: 0px 20px 60px -20px rgba(0,0,0, 0.5);">
                        Iniciar
                    </button>

                    <!--<button id="btn__iniciar-sesion">Iniciar Sesión</button>-->
                </div>
                <div class="caja__trasera-register">
                    <h3>¿Aún no tienes una cuenta?</h3>
                    <p>Regístrate para que puedas iniciar sesión</p>


                    <button id="btn__registrarse" class="botonDysie"
                        style="font-size: 20px; box-shadow: 0px 20px 60px -20px rgba(0,0,0, 0.5);">
                        Registrarme
                    </button>

                    <!--<button id="btn__registrarse">Registrarse</button>-->

                </div>
            </div>
            <div class="contenedor__login-register">
            <form id="formularioL" method="POST" action="procesar_login.php" class="formulario__login">
    <h2>Iniciar Sesión</h2>
    <input type="email" class="form-control" id="txt_emailL" placeholder="Email" name="txt_emailL" required>
    <input type="password" class="form-control" id="txt_contraseñaL" placeholder="Contraseña" name="txt_contraseñaL" minlength="8" required>
    <br><br>

    <!-- Botón para iniciar sesión como administrador -->
    <button type="button" class="botonDysie" onclick="setTipoUsuario('administrador')">Ingresar como Administrador</button>
    <input type="hidden" id="tipo_usuario" name="tipo_usuario" value="estudiante"> <!-- Valor por defecto -->

    <button type="submit" class="botonDysie" style="margin-top: 30px;">Entrar</button>

    <div class="contenedor-linkVolver">
        <a class="link-Volver" href="../index.html">Volver a Inicio</a>
    </div>
</form>

<script>
    function setTipoUsuario(tipo) {
        document.getElementById("tipo_usuario").value = tipo;
        if (tipo === "administrador") {
            document.getElementById("txt_emailL").placeholder = "Email de Administrador";
            document.getElementById("txt_contraseñaL").placeholder = "Contraseña de Administrador";
        } else {
            document.getElementById("txt_emailL").placeholder = "Email";
            document.getElementById("txt_contraseñaL").placeholder = "Contraseña";
        }
    }
</script>





                <form id="formulario" method="POST" action="procesar_registro.php" class="formulario__register">
                    <h2>Registrarse</h2>

                    <input type="text" class="form-control" id="txt_nombre" placeholder="Nombres" name="txt_nombre"
                        required>
                    <input type="text" class="form-control" id="txt_apellido" placeholder="Apellidos"
                        name="txt_apellido" required>
                    <input type="email" class="form-control" id="txt_email" placeholder="Email" name="txt_email"
                        required>
                    <input type="password" class="form-control" id="txt_contraseña" placeholder="Contraseña"
                        name="txt_contraseña" minlength="8" required><br><br>
                    <p style="color:white;">Fecha de nacimiento:</p>

                    <input type="date" id="txt_fecha" name="txt_fecha" required>

                    <button type="submit" class="botonDysie" style="margin-top: 30px;">
                        Registrar
                    </button>

                    <div class="contenedor-linkVolver">
                        <a class="link-Volver" href="../index.html">Volver a Inicio</a>
                    </div>
                    <!--<button type="submit" class="boton_inicio">Registrar</button>-->
                </form>
            </div>
        </div>
    </main>
    <script src="../javasS/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>