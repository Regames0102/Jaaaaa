<!DOCTYPE HTML>
<html>

<head>
  <style>
    .error {
      color: #FF0000;
    }
    .peon {
            background-color: #ff9999;
        }

    .oficial {
            background-color: #99ff99;
        }

    .jefe-departamento {
            background-color: #9999ff;
        }

    .director {
            background-color: #ffcc00;
        }
    table {
            border-collapse: collapse;
            width: 100%;
        }

    th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

  </style>
</head>

<body>

  <?php
  //esta parte la he sacado de w3schools
  $nombreErr = $apellidosErr = $fechaErr = $sueldoErr = $categoriaErr = $sexoErr = $aficionesErr = "Te falta esto";
  $nombre = $apellidos = $fecha = $sueldo = $categoria = $sexo = $aficiones = "";

  // Verificamos si se ha enviado el formulario
  $empleados = []; // Inicializar el array de empleados
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["Nombre"];
    $apellidos = $_POST["Apellidos"];
    $categoria = $_POST["Categoria"];
    $sexo = isset($_POST["gender"]) ? $_POST["gender"] : "";
    $aficiones = isset($_POST["Deportes"]) ? "Deportes " : "";
    $aficiones .= isset($_POST["Lectura"]) ? "Lectura " : "";
    $aficiones .= isset($_POST["Musica"]) ? "Musica " : "";
    $aficiones .= isset($_POST["Cine"]) ? "Cine " : "";
    $aficiones .= isset($_POST["Idiomas"]) ? "Idiomas " : "";
  


    $categoriaCssClass = '';
    switch (strtolower($categoria)) { // Convertir a minúsculas para comparación sin distinción de mayúsculas
        case 'peon':
            $categoriaCssClass = 'peon';
            break;
        case 'oficial':
            $categoriaCssClass = 'oficial';
            break;
        case 'jefe-departamento':
            $categoriaCssClass = 'jefe-departamento';
            break;
        case 'director':
            $categoriaCssClass = 'director';
            break;
        default:
            $categoriaCssClass = ''; // Categoría no reconocida
            break;
    }

    $empleado = array(
      'nombre' => $nombre,
      'apellidos' => $apellidos,
      'sueldo' => $sueldo,
      'fecha' => $fecha,
      'categoria' => $categoria,
      'sexo' => $sexo,
      'aficiones' => $aficiones,
      'categoriaCssClass' => $categoriaCssClass
  );

  $empleadosJson = file_get_contents('empleados.json');
  $empleados = json_decode($empleadosJson, true);
    
    // Añadir el nuevo empleado al array
    $empleados[] = $empleado;
    
    // Convertir el array de empleados en una cadena JSON y guardarla en el archivo
    $empleadosJson = json_encode($empleados);
    file_put_contents('empleados.json', $empleadosJson);

    $empleadosJson = file_get_contents('empleados.json');
    $empleados = json_decode($empleadosJson, true);
  }

     // Crear un array con los datos del formulario
  ?>
    <table>
        <tr>
            <th>Nombre</th>
            <th>Apellidos</th>
            <th>Sueldo</th>
            <th>Categoría</th>
            <th>Sexo</th>
            <th>Aficiones</th>
        </tr>
        <?php foreach ($empleados as $empleado): ?>
            <tr class="<?php echo htmlspecialchars($empleado['categoriaCssClass']); ?>">
                <td><?php echo htmlspecialchars($empleado['nombre']); ?></td>
                <td><?php echo htmlspecialchars($empleado['apellidos']); ?></td>
                <td><?php echo htmlspecialchars($empleado['sueldo']); ?></td>
                <td><?php echo htmlspecialchars($empleado['categoria']); ?> </td>
                <td><?php echo htmlspecialchars($empleado['sexo']); ?></td>
                <td><?php echo htmlspecialchars($empleado['aficiones']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>