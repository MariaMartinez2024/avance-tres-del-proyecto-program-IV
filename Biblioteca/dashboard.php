
<?php
session_start();
if (!isset($_SESSION['usuario'])) {
  header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="estilos.css">
  <title>Panel Principal</title>
</head>
<body>
  <div class="menu">
    <h2>Bienvenido, <?php echo $_SESSION['usuario']; ?></h2>
    <p>Rol: <?php echo $_SESSION['rol']; ?></p>
    <a href="libros.php">Gestión de Libros</a>
    <a href="prestamos.php">Préstamos</a>
    <?php if ($_SESSION['rol'] == 'Administrador') { ?>
      <a href="usuarios.php">Gestión de Usuarios</a>
    <?php } ?>
    <a href="index.php">Cerrar Sesión</a>
  </div>
</body>
</html>
