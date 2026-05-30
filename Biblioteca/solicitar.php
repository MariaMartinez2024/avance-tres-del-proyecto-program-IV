
<?php 
include('conexion.php'); 
session_start();

if (!isset($_SESSION['usuario']) || ($_SESSION['rol'] != 'Estudiante' && $_SESSION['rol'] != 'Docente')) {
  header("Location: index.php");
  exit();
}

if (isset($_POST['solicitar'])) {
  $id_libro = $_POST['id_libro'];
  $usuario = $_SESSION['usuario'];

  # Obtener el id del usuario
  $id_usuario = $conexion->query("SELECT id_usuario FROM usuarios WHERE usuario='$usuario'")->fetch_assoc()['id_usuario'];

  $fecha_prestamo = date("Y-m-d");
  $fecha_devolucion = date("Y-m-d", strtotime("+7 days"));

  # Registrar préstamo correctamente
  $conexion->query("INSERT INTO prestamos (id_usuario, id_libro, fecha_prestamo, fecha_devolucion, estado) 
                    VALUES ($id_usuario, $id_libro, '$fecha_prestamo', '$fecha_devolucion', 'Activo')");
  $conexion->query("UPDATE libros SET estado='Prestado' WHERE id_libro=$id_libro");

  $mensaje = "Solicitud realizada con éxito. El libro ha sido prestado.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Solicitar Libro</title>
  <link rel="stylesheet" href="estilos.css">
</head>
<body>
  <h2>Solicitar Libro</h2>
  <p>Usuario: <?php echo $_SESSION['usuario']; ?> (<?php echo $_SESSION['rol']; ?>)</p>

  <?php if(isset($mensaje)) echo "<p class='success'>$mensaje</p>"; ?>

  <h3>Libros Disponibles</h3>
  <?php
  $resultado = $conexion->query("SELECT * FROM libros WHERE estado='Disponible'");
  echo "<table><tr><th>ID</th><th>Título</th><th>Autor</th><th>Categoría</th><th>Acción</th></tr>";
  while ($fila = $resultado->fetch_assoc()) {
    echo "<tr>
            <td>{$fila['id_libro']}</td>
            <td>{$fila['titulo']}</td>
            <td>{$fila['autor']}</td>
            <td>{$fila['categoria']}</td>
            <td>
              <form method='POST' style='display:inline;'>
                <input type='hidden' name='id_libro' value='{$fila['id_libro']}'>
                <button type='submit' name='solicitar'>Solicitar</button>
              </form>
            </td>
          </tr>";
  }
  echo "</table>";
  ?>
</body>
</html>

