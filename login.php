<?php
session_start();

// Incluir el archivo de conexión
include('conexion.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];

    // Buscar al usuario en la base de datos
    $query = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
    $result = mysqli_query($conexion, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        // Verificar la contraseña (usando password_hash y password_verify para mayor seguridad)
        if (password_verify($clave, $user['clave'])) {
            $_SESSION['usuario'] = $usuario;  // Establecer sesión
            echo "Bienvenido, $usuario!";
            // Redirigir o hacer lo que necesites al iniciar sesión
            header("Location: index.php"); // Redirigir a la página de inicio
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Usuario no encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Tienda de Mascotas</title>
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
        <section class="login">
            <h2>Iniciar sesión</h2>
            <form method="POST" action="">
                <label for="usuario">Usuario</label>
                <input type="text" name="usuario" id="usuario" placeholder="Usuario" required>
                
                <label for="clave">Contraseña</label>
                <input type="password" name="clave" id="clave" placeholder="Contraseña" required>
                
                <button type="submit" class="btn-main">Iniciar sesión</button>
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
