
<?php 
include('conexion.php'); 
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'Administrador') {
  header("Location: index.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Reportes Biblioteca</title>
  <link rel="stylesheet" href="estilos.css">
</head>
<body>
  <h2>Reportes de Libros</h2>

  <h3>Libros Disponibles</h3>
  <?php
  $resultado = $conexion->query("SELECT * FROM libros WHERE estado='Disponible'");
  echo "<table><tr><th>Título</th><th>Autor</th><th>Categoría</th></tr>";
  while ($fila = $resultado->fetch_assoc()) {
    echo "<tr><td>{$fila['titulo']}</td><td>{$fila['autor']}</td><td>{$fila['categoria']}</td></tr>";
  }
  echo "</table>";
  ?>

  <h3>Libros Prestados</h3>
  <?php
  $resultado = $conexion->query("SELECT * FROM libros WHERE estado='Prestado'");
  echo "<table><tr><th>Título</th><th>Autor</th><th>Categoría</th></tr>";
  while ($fila = $resultado->fetch_assoc()) {
    echo "<tr><td>{$fila['titulo']}</td><td>{$fila['autor']}</td><td>{$fila['categoria']}</td></tr>";
  }
  echo "</table>";
  ?>
</body>
</html>

