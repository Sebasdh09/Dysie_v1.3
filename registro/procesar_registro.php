<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar los valores del formulario de registro

    // Expresiones regulares para validar los campos
    $expresiones = array(
        'txt_nombre' => '/^[a-zA-ZÀ-ÿ\s]{1,40}$/',
        'txt_apellido' => '/^[a-zA-ZÀ-ÿ\s]{1,40}$/',
        'txt_contraseña' => '/^.{4,12}$/',
        'txt_email' => '/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/',
    );

    // Recuperar los valores del formulario de registro

    $nombre = $_POST["txt_nombre"];
    $apellido = $_POST["txt_apellido"];
    $email = $_POST["txt_email"];
    $contrasena = $_POST["txt_contraseña"];
    $fechaNacimiento = $_POST["txt_fecha"];

    // Hashear la contraseña antes de almacenarla en la base de datos
    $hashContrasena = password_hash($contrasena, PASSWORD_DEFAULT);

    // Rol por defecto: estudiante
    $rol = "estudiante";

    // Conectar a la base de datos y realizar la inserción
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "dysie";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar si la conexión a la base de datos fue exitosa
    if ($conn->connect_error) {
        $_SESSION["error"] = "La conexión a la base de datos falló: " . $conn->connect_error;
        header("Location: login.php");
        exit();
    }

    // Insertar la información del usuario en la base de datos
    $stmt = $conn->prepare("INSERT INTO usuario (nombre_usu, apellidos_usu, email, contra, fecha_nacimiento, roles) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nombre, $apellido, $email, $hashContrasena, $fechaNacimiento, $rol);

    if ($stmt->execute()) {
        // Registro exitoso, puedes redirigir al usuario a donde desees
        $_SESSION["registro_exitoso"] = true;
        $stmt->close();
        $conn->close();
        header("Location: login.php");
        exit();
    } else {
        // Error en la inserción, puedes manejarlo adecuadamente
        $_SESSION["error"] = "Error al registrar el usuario: " . $stmt->error;
        $stmt->close();
        $conn->close();
        header("Location: login.php");
        exit();
    }
} else {
    // Redirigir de vuelta al formulario de registro si no se envió el formulario
    header("Location: login.php");
    exit();
}
