<?php 
include('conexion.php'); 
session_start();

# --- AGREGAR ---
if (isset($_POST['agregar'])) {
  $titulo = $_POST['titulo'];
  $autor = $_POST['autor'];
  $categoria = $_POST['categoria'];
  $conexion->query("INSERT INTO libros (titulo, autor, categoria, estado) VALUES ('$titulo','$autor','$categoria','Disponible')");
  header("Location: libros.php"); // refresca la página
}

# --- ELIMINAR ---
if (isset($_GET['eliminar'])) {
  $id = $_GET['eliminar'];
  $conexion->query("DELETE FROM libros WHERE id_libro=$id");
  header("Location: libros.php"); // refresca la página
}

# --- ACTUALIZAR ---
if (isset($_POST['actualizar'])) {
  $id = $_POST['id_libro'];
  $titulo = $_POST['titulo'];
  $autor = $_POST['autor'];
  $categoria = $_POST['categoria'];
  $estado = $_POST['estado'];
  $conexion->query("UPDATE libros SET titulo='$titulo', autor='$autor', categoria='$categoria', estado='$estado' WHERE id_libro=$id");
  header("Location: libros.php"); // refresca la página
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Gestión de Libros</title>
  <link rel="stylesheet" href="estilos.css">
</head>
<body>
  <h2>Gestión de Libros</h2>

  <!-- Formulario para agregar -->
  <form method="POST">
    <input type="text" name="titulo" placeholder="Título" required>
    <input type="text" name="autor" placeholder="Autor" required>
    <input type="text" name="categoria" placeholder="Categoría" required>
    <button type="submit" name="agregar">Agregar Libro</button>
  </form>

  <!-- Tabla de libros -->
  <?php
  $resultado = $conexion->query("SELECT * FROM libros");
  echo "<table><tr><th>Título</th><th>Autor</th><th>Categoría</th><th>Estado</th><th>Acciones</th></tr>";
  while ($fila = $resultado->fetch_assoc()) {
    echo "<tr>
            <td>{$fila['titulo']}</td>
            <td>{$fila['autor']}</td>
            <td>{$fila['categoria']}</td>
            <td>{$fila['estado']}</td>
            <td>
              <a href='libros.php?editar={$fila['id_libro']}'>Editar</a> | 
              <a href='libros.php?eliminar={$fila['id_libro']}'>Eliminar</a>
            </td>
          </tr>";
  }
  echo "</table>";
  ?>

  <!-- Formulario de edición -->
  <?php
  if (isset($_GET['editar'])) {
    $id = $_GET['editar'];
    $libro = $conexion->query("SELECT * FROM libros WHERE id_libro=$id")->fetch_assoc();
    echo "
    <h3>Editar Libro</h3>
    <form method='POST'>
      <input type='hidden' name='id_libro' value='{$libro['id_libro']}'>
      <input type='text' name='titulo' value='{$libro['titulo']}' required>
      <input type='text' name='autor' value='{$libro['autor']}' required>
      <input type='text' name='categoria' value='{$libro['categoria']}' required>
      <select name='estado'>
        <option value='Disponible' ".($libro['estado']=='Disponible'?'selected':'').">Disponible</option>
        <option value='Prestado' ".($libro['estado']=='Prestado'?'selected':'').">Prestado</option>
      </select>
      <button type='submit' name='actualizar'>Actualizar</button>
    </form>
    ";
  }
  ?>
</body>
</html>
