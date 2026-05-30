<?php
session_start();
if (!isset($_SESSION['usuario'])) {
  header("Location: index.php");
  exit();
}
$rol = $_SESSION['rol'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel Principal</title>
  <link rel="stylesheet" href="estilos.css">

</head>
<body class="dashboard-page">
  <div class="dashboard-container">
    <h2>Bienvenido, <?php echo $_SESSION['usuario']; ?> (<?php echo $_SESSION['rol']; ?>)</h2>

    <?php if ($rol == 'Administrador'): ?>
      <ul>
        <li><a href="libros.php">Gestión de Libros</a></li>
        <li><a href="usuarios.php">Gestión de Usuarios</a></li>
        <li><a href="prestamos.php">Gestión de Préstamos</a></li>
        <li><a href="reportes.php">Reportes</a></li>
      </ul>
    <?php else: ?>
      <ul>
        <li><a href="solicitar.php">Solicitar Libro</a></li>
      </ul>
    <?php endif; ?>

    <a href="index.php" class="logout">Cerrar sesión</a>
  </div>
</body>
</html>

