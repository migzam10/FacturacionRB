<?php
require_once '../clases/Conexion.php'; // Archivo con la clase de conexión

// Validar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario']);
    $clave = trim($_POST['clave']);
    $tipo = trim($_POST['tipo']);
    $estado = trim($_POST['estado']);

    // Validación básica
    if (empty($usuario) || empty($clave) || empty($tipo) || empty($estado)) {
        $mensaje = "Todos los campos son obligatorios.";
    } else {
        // Encriptar la clave
        
       
        // Conexión a la base de datos e inserción de datos
        $conexion = new Conexion();
        $conn = $conexion->conectar();

        $clave_encriptada = mysqli_real_escape_string($conn,sha1(md5($clave)));
        $sql = "INSERT INTO usuarios (usuario, clave, tipo, estado) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $usuario, $clave_encriptada, $tipo, $estado);

        if ($stmt->execute()) {
            $mensaje = "Usuario registrado exitosamente.";
        } else {
            $mensaje = "Error al registrar el usuario: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h2>Registro de Usuario</h2>

        <?php if (!empty($mensaje)): ?>
            <div class="alert alert-info">
                <?= htmlspecialchars($mensaje) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="usuario" name="usuario" required>
            </div>

            <div class="mb-3">
                <label for="clave" class="form-label">Clave</label>
                <input type="password" class="form-control" id="clave" name="clave" required>
            </div>

            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo</label>
                <select class="form-select" id="tipo" name="tipo" required>
                    <option value="admin">Admin</option>
                    <option value="usuario">Usuario</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="estado" class="form-label">Estado</label>
                <select class="form-select" id="estado" name="estado" required>
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Registrar</button>
        </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.min.js"></script>
</body>

</html>