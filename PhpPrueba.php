<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos de Empleados</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
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
    </style>
</head>

<body>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos de Empleados</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
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
    </style>
</head>

<body>

<?php
$empleados = []; // Inicializar el array de empleados

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $nombre = $_POST["Nombre"];
    $apellidos = $_POST["usuario"];
    $sueldo = $_POST["email_alumno"];
    $categoria = $_POST["Categoria"];
    $sexo = isset($_POST["gender"]) ? $_POST["gender"] : "";
    $aficiones = isset($_POST["Deportes"]) ? "Deportes " : "";
    $aficiones .= isset($_POST["Lectura"]) ? "Lectura " : "";
    $aficiones .= isset($_POST["Musica"]) ? "Musica " : "";
    $aficiones .= isset($_POST["Cine"]) ? "Cine " : "";
    $aficiones .= isset($_POST["Idiomas"]) ? "Idiomas " : "";

    // Determinar la categoría del empleado
    $categoriaCssClass = '';
    switch ($categoria) {
        case 'Peon':
            $categoriaCssClass = 'peon';
            break;
        case 'Oficial':
            $categoriaCssClass = 'oficial';
            break;
        case 'JefeDepartamento':
            $categoriaCssClass = 'jefe-departamento';
            break;
        case 'Director':
            $categoriaCssClass = 'director';
            break;
        default:
            $categoriaCssClass = ''; // Categoría no reconocida
            break;
    }

    // Crear un array con los datos del formulario
    $empleado = array(
        'nombre' => $nombre,
        'apellidos' => $apellidos,
        'sueldo' => $sueldo,
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
}

$empleadosJson = file_get_contents('empleados.json');
$empleados = json_decode($empleadosJson, true);

// Verificar si hay empleados para mostrar

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
        <tr>
            <td><?php echo htmlspecialchars($empleado['nombre']); ?></td>
            <td><?php echo htmlspecialchars($empleado['apellidos']); ?></td>
            <td><?php echo htmlspecialchars($empleado['sueldo']); ?></td>
            <td class='{$categoriaCssClass}'>><?php echo htmlspecialchars($empleado['categoria']); ?></td>
            <td><?php echo htmlspecialchars($empleado['sexo']); ?></td>
            <td><?php echo htmlspecialchars($empleado['aficiones']); ?></td>
        </tr>
    <?php endforeach; ?>
</table>


foreach ($empleados as $empleado) {
        echo "<tr><td>Nombre:</td><td>{$empleado['Nombre']}</td></tr>";
        echo "<tr><td>Apellidos:</td><td>{$empleado['Apellidos']}</td></tr>";
        echo "<tr><td>Sueldo:</td><td>{$empleado['Sueldo']}</td></tr>";
        echo "<tr><td>Categoría:</td><td class='{$categoriaCssClass}'>{$empleado['Categoria']}</td></tr>";
        echo "<tr><td>Sexo:</td><td>{$empleado['Sexo']}</td></tr>";
        echo "<tr><td>Aficiones:</td><td>{$empleado['Aficiones']}</td></tr>";
    }
</body>
</html>
