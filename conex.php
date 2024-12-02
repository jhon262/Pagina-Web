<?php
$servername = "fdb28.awardspace.net"; // Host de la base de datos
$username = "4557146_jairo";  // Usuario de la base de datos
$password = "162012tiendaM"; // Contraseña de la base de datos
$dbname = "4557146_jairo"; // Nombre de la base de datos

// Crear conexión
$conexion = new mysqli($servername, $username, $password, $dbname, 3306); // El puerto 3306 especificado

// Verificar la conexión
if ($conexion->connect_error) {
    die("La conexión falló: " . $conexion->connect_error);
}
?>
