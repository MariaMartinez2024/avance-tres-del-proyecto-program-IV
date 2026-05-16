
<?php
session_start();
include('conexion.php');

if (isset($_POST['login'])) {
  $usuario = $_POST['usuario'];
  $contraseña = $_POST['contraseña'];
  $rol = $_POST['rol'];

  // Si la contraseña está en texto plano:
  $sql = "SELECT * FROM usuarios WHERE usuario='$usuario' AND contraseña='$contraseña' AND rol='$rol'";

  // Si la contraseña está en MD5:
  // $sql = "SELECT * FROM usuarios WHERE usuario='$usuario' AND contraseña=MD5('$contraseña') AND rol='$rol'";

  $resultado = $conexion->query($sql);

  if ($resultado->num_rows > 0) {
    $_SESSION['usuario'] = $usuario;
    $_SESSION['rol'] = $rol;
    header("Location: dashboard.php");
    exit(); // <- importante para cortar la ejecución
  } else {
    $error = "Credenciales incorrectas";
  }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login Biblioteca</title>
  <link rel="stylesheet" href="estilos.css">
</head>
<body>
  <div class="login-container">
    <h2>Inicio de Sesión</h2>
    <form method="POST">
      <input type="text" name="usuario" placeholder="Usuario" required>
      <input type="password" name="contraseña" placeholder="Contraseña" required>
      <select name="rol">
        <option value="Administrador">Administrador</option>
        <option value="Estudiante">Estudiante</option>
        <option value="Docente">Docente</option>
      </select>
      <button type="submit" name="login">Ingresar</button>
    </form>
    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
  </div>
</body>
</html>

