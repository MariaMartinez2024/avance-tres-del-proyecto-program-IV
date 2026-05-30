<?php 
include('conexion.php'); 
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'Administrador') {
  header("Location: index.php");
  exit();
}

# --- REGISTRAR PRÉSTAMO ---
if (isset($_POST['agregar'])) {
  $id_libro = $_POST['id_libro'];
  $usuario = $_POST['usuario'];
  $id_usuario = $conexion->query("SELECT id_usuario FROM usuarios WHERE usuario='$usuario'")->fetch_assoc()['id_usuario'];

  $fecha_prestamo = date("Y-m-d");
  $fecha_devolucion = date("Y-m-d", strtotime("+7 days"));

  $conexion->query("INSERT INTO prestamos (id_usuario, id_libro, fecha_prestamo, fecha_devolucion, estado) 
                    VALUES ($id_usuario, $id_libro, '$fecha_prestamo', '$fecha_devolucion', 'Activo')");
  $conexion->query("UPDATE libros SET estado='Prestado' WHERE id_libro=$id_libro");
  header("Location: prestamos.php");
}

# --- DEVOLVER LIBRO ---
if (isset($_GET['devolver'])) {
  $id = $_GET['devolver'];
  $prestamo = $conexion->query("SELECT * FROM prestamos WHERE id_prestamo=$id")->fetch_assoc();
  $conexion->query("UPDATE prestamos SET estado='Devuelto', fecha_devolucion=CURDATE() WHERE id_prestamo=$id");
  $conexion->query("UPDATE libros SET estado='Disponible' WHERE id_libro={$prestamo['id_libro']}");
  header("Location: prestamos.php");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestión de Préstamos</title>
  <link rel="stylesheet" href="estilos.css">
</head>
<body>
  <h2>Gestión de Préstamos</h2>

  <form method="POST">
    <select name="id_libro" required>
      <option value="">Seleccione un libro</option>
      <?php
      $libros = $conexion->query("SELECT * FROM libros WHERE estado='Disponible'");
      while ($fila = $libros->fetch_assoc()) {
        echo "<option value='{$fila['id_libro']}'>{$fila['titulo']}</option>";
      }
      ?>
    </select>

    <input type="text" name="usuario" placeholder="Usuario" required>
    <button type="submit" name="agregar">Registrar Préstamo</button>
  </form>

  <h3>Listado de Préstamos</h3>
  <?php
  $resultado = $conexion->query("
    SELECT p.id_prestamo, l.titulo AS libro, u.usuario AS usuario,
           p.fecha_prestamo, p.fecha_devolucion, p.estado
    FROM prestamos p
    INNER JOIN libros l ON p.id_libro = l.id_libro
    INNER JOIN usuarios u ON p.id_usuario = u.id_usuario
  ");

  echo "<table><tr><th>Libro</th><th>Usuario</th><th>Fecha Préstamo</th><th>Fecha Devolución</th><th>Estado</th><th>Acciones</th></tr>";
  while ($fila = $resultado->fetch_assoc()) {
    echo "<tr>
            <td>{$fila['libro']}</td>
            <td>{$fila['usuario']}</td>
            <td>{$fila['fecha_prestamo']}</td>
            <td>{$fila['fecha_devolucion']}</td>
            <td>{$fila['estado']}</td>
            <td>";
    if ($fila['estado'] == 'Activo') {
      echo "<a href='prestamos.php?devolver={$fila['id_prestamo']}'>Devolver</a>";
    }
    echo "</td></tr>";
  }
  echo "</table>";
  ?>
</body>
</html>





