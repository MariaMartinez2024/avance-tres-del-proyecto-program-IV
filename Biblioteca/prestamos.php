<?php include('conexion.php'); session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="estilos.css">
  <title>Préstamos</title>
</head>
<body>
  <h2>Solicitar Préstamo</h2>
<?php
$libros = $conexion->query("SELECT * FROM libros WHERE estado='Disponible'");
echo "<form method='POST'><select name='id_libro'>";
while ($fila = $libros->fetch_assoc()) {
  echo "<option value='{$fila['id_libro']}'>{$fila['titulo']}</option>";
}
echo "</select><button type='submit' name='solicitar'>Solicitar</button></form>";

if (isset($_POST['solicitar'])) {
  $id_libro = $_POST['id_libro'];
  $usuario = $_SESSION['usuario'];
  $id_usuario = $conexion->query("SELECT id_usuario FROM usuarios WHERE usuario='$usuario'")->fetch_assoc()['id_usuario'];

  $conexion->query("INSERT INTO prestamos (id_usuario, id_libro, fecha_prestamo, fecha_devolucion) VALUES ($id_usuario, $id_libro, CURDATE(), DATE_ADD(CURDATE(), INTERVAL 7 DAY))");
  $conexion->query("UPDATE libros SET estado='Prestado' WHERE id_libro=$id_libro");
  echo "<p class='success'>Préstamo registrado correctamente</p>";
}
?>
</body>
</html>

