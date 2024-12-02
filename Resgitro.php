<?php
// Incluir el archivo de conexión
include('conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];

    // Verificar si el usuario ya existe con una consulta preparada
    $query = $conexion->prepare("SELECT * FROM usuarios WHERE usuario = ?");
    $query->bind_param("s", $usuario);  // 's' es para una cadena de texto
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows == 0) {
        // Encriptar la contraseña antes de almacenarla
        $clave_encriptada = password_hash($clave, PASSWORD_DEFAULT);

        // Insertar el nuevo usuario usando una consulta preparada
        $query = $conexion->prepare("INSERT INTO usuarios (usuario, clave) VALUES (?, ?)");
        $query->bind_param("ss", $usuario, $clave_encriptada); // 'ss' son para cadenas de texto
        if ($query->execute()) {
            echo "Registro exitoso. <a href='login.php'>Iniciar sesión</a>";
        } else {
            echo "Error al registrar usuario: " . $query->error;
        }
    } else {
        $error = "El usuario ya existe.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Tienda de Mascotas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <h2>Tienda de Mascotas</h2>
            </div>
            <ul>
                <li><a href="index.html" class="nav-link">Inicio</a></li>
                <li><a href="productos.html" class="nav-link">Productos</a></li>
                <li><a href="login.php" class="nav-link">Login</a></li>
                <li><a href="registro.php" class="nav-link">Registro</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="register">
            <h2>Registrarse</h2>
            <form method="POST" action="">
                <label for="usuario">Usuario</label>
                <input type="text" name="usuario" id="usuario" placeholder="Usuario" required>
                
                <label for="clave">Contraseña</label>
                <input type="password" name="clave" id="clave" placeholder="Contraseña" required>
                
                <label for="confirmar-clave">Confirmar Contraseña</label>
                <input type="password" name="confirmar-clave" id="confirmar-clave" placeholder="Confirmar Contraseña" required>
                
                <button type="submit" class="btn-main">Registrarse</button>
                <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
            </form>
        </section>
    </main>

    <footer>
        <div class="contact-info">
            <p>&copy; 2024 Tienda de Mascotas. Todos los derechos reservados.</p>
            <p><a href="mailto:tiendademascotas@contacto.com">tiendademascotas@contacto.com</a></p> <!-- Cambié el correo -->
        </div>
    </footer>

</body>
</html>
