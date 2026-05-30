
<?php 
include('conexion.php'); 
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['rol'] != 'Administrador') {
  header("Location: index.php");
  exit();
}

# --- AGREGAR ---
if (isset($_POST['agregar'])) {
  $usuario = $_POST['usuario'];
  $contraseña = $_POST['contraseña'];
  $rol = $_POST['rol'];
  $conexion->query("INSERT INTO usuarios (usuario, contraseña, rol) VALUES ('$usuario','$contraseña','$rol')");
  header("Location: usuarios.php");
}

# --- ELIMINAR ---
if (isset($_GET['eliminar'])) {
  $id = $_GET['eliminar'];
  $conexion->query("DELETE FROM usuarios WHERE id_usuario=$id");
  header("Location: usuarios.php");
}

# --- ACTUALIZAR ---
if (isset($_POST['actualizar'])) {
  $id = $_POST['id_usuario'];
  $usuario = $_POST['usuario'];
  $contraseña = $_POST['contraseña'];
  $rol = $_POST['rol'];
  $conexion->query("UPDATE usuarios SET usuario='$usuario', contraseña='$contraseña', rol='$rol' WHERE id_usuario=$id");
  header("Location: usuarios.php");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestión de Usuarios</title>
  <link rel="stylesheet" href="estilos.css">
</head>
<body>
  <h2>Gestión de Usuarios</h2>

  <form method="POST">
    <input type="text" name="usuario" placeholder="Usuario" required>
    <input type="password" name="contraseña" placeholder="Contraseña" required>
    <select name="rol">
      <option value="Administrador">Administrador</option>
      <option value="Estudiante">Estudiante</option>
      <option value="Docente">Docente</option>
    </select>
    <button type="submit" name="agregar">Agregar Usuario</button>
  </form>

  <?php
  $resultado = $conexion->query("SELECT * FROM usuarios");
  echo "<table><tr><th>Usuario</th><th>Rol</th><th>Acciones</th></tr>";
  while ($fila = $resultado->fetch_assoc()) {
    echo "<tr>
            <td>{$fila['usuario']}</td>
            <td>{$fila['rol']}</td>
            <td>
              <a href='usuarios.php?editar={$fila['id_usuario']}'>Editar</a> | 
              <a href='usuarios.php?eliminar={$fila['id_usuario']}'>Eliminar</a>
            </td>
          </tr>";
  }
  echo "</table>";

  if (isset($_GET['editar'])) {
    $id = $_GET['editar'];
    $usuario = $conexion->query("SELECT * FROM usuarios WHERE id_usuario=$id")->fetch_assoc();
    echo "
    <h3>Editar Usuario</h3>
    <form method='POST'>
      <input type='hidden' name='id_usuario' value='{$usuario['id_usuario']}'>
      <input type='text' name='usuario' value='{$usuario['usuario']}' required>
      <input type='password' name='contraseña' value='{$usuario['contraseña']}' required>
      <select name='rol'>
        <option value='Administrador' ".($usuario['rol']=='Administrador'?'selected':'').">Administrador</option>
        <option value='Estudiante' ".($usuario['rol']=='Estudiante'?'selected':'').">Estudiante</option>
        <option value='Docente' ".($usuario['rol']=='Docente'?'selected':'').">Docente</option>
      </select>
      <button type='submit' name='actualizar'>Actualizar</button>
    </form>
    ";
  }
  ?>
</body>
</html>

