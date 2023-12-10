<?php
$nombreErr = $apellidosErr = $fechaErr = $sueldoErr = $categoriaErr = $sexoErr = $aficionesErr = "";
$nombre = $apellidos = $fecha = $sueldo = $categoria = $sexo = $aficiones = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validación básica
    if (empty($_POST["Nombre"])) {
        $nombreErr = "El nombre es obligatorio";
    } else {
        $nombre = test_input($_POST["Nombre"]);
        // B. Validación de nombre
        if (!preg_match("/^[a-zA-Zá-úÁ-Ú]+(-[a-zA-Zá-úÁ-Ú]+)?$/", $nombre) || strlen($nombre) < 3) {
            $nombreErr = "Nombre inválido";
        }
    }

    if (empty($_POST["Apellidos"])) {
        $apellidosErr = "Los apellidos son obligatorios";
    } else {
        $apellidos = test_input($_POST["Apellidos"]);
        // C. Validación de apellidos
        if (!preg_match("/^[a-zA-Zá-úÁ-Ú]+(-[a-zA-Zá-úÁ-Ú]+)?\s[a-zA-Zá-úÁ-Ú]+(-[a-zA-Zá-úÁ-Ú]+)?$/", $apellidos)) {
            $apellidosErr = "Apellidos inválidos";
        }
    }

    if (empty($_POST["Fecha"])) {
        $fechaErr = "La fecha de nacimiento es obligatoria";
    } else {
        $fecha = test_input($_POST["Fecha"]);
        // D. Validación de fecha
        $fechaNacimiento = DateTime::createFromFormat('Y-m-d', $fecha);
        $fechaLimite = DateTime::createFromFormat('Y-m-d', '1950-01-01');
        $fechaActual = new DateTime();

        if (!$fechaNacimiento || $fechaNacimiento < $fechaLimite || $fechaNacimiento >= $fechaActual || $fechaActual->diff($fechaNacimiento)->y < 18) {
            $fechaErr = "Fecha de nacimiento inválida";
        }
    }

    if (empty($_POST["Sueldo"])) {
        $sueldoErr = "El sueldo es obligatorio";
    } else {
        $sueldo = test_input($_POST["Sueldo"]);
        // F. Validación de sueldo
        if (!is_numeric($sueldo) || $sueldo < 600 || $sueldo > 3000) {
            $sueldoErr = "Sueldo inválido";
        } else {
            // Restricciones adicionales para sueldo según la categoría
            $categoria = test_input($_POST["Categoria"]);
            switch ($categoria) {
                case "peon":
                    if ($sueldo < 600 || $sueldo > 1200) {
                        $sueldoErr = "Sueldo para Peón debe estar entre 600 y 1200";
                    }
                    break;
                case "oficial":
                    if ($sueldo < 900 || $sueldo > 1500) {
                        $sueldoErr = "Sueldo para Oficial debe estar entre 900 y 1500";
                    }
                    break;
                case "jefe-departamento":
                    if ($sueldo < 1400 || $sueldo > 2500) {
                        $sueldoErr = "Sueldo para Jefe de Departamento debe estar entre 1400 y 2500";
                    }
                    break;
                case "director":
                    if ($sueldo < 2000 || $sueldo > 3000) {
                        $sueldoErr = "Sueldo para Director debe estar entre 2000 y 3000";
                    }
                    break;
            }
        }
    }

    $categoria = test_input($_POST["Categoria"]);
    // E. Validación de categoría
    if (!in_array($categoria, ["peon", "oficial", "jefe-departamento", "director"])) {
        $categoriaErr = "Categoría inválida";
    }

    if (empty($_POST["gender"])) {
        $sexoErr = "El sexo es obligatorio";
    } else {
        $sexo = test_input($_POST["gender"]);
    }

    if (empty($_POST["Deportes"]) && empty($_POST["Lectura"]) && empty($_POST["Musica"]) && empty($_POST["Cine"]) && empty($_POST["Idiomas"])) {
        $aficionesErr = "Debes seleccionar al menos una afición";
    } else {
        $aficiones = implode(", ", array_keys($_POST));
    }

    // Validación adicional para hombres y deportes
    if ($sexo == "hombre" && $aficiones == "Deportes") {
        $aficionesErr = "Los hombres deben seleccionar más aficiones además de los deportes.";
    }

    // Si todas las validaciones pasan, puedes proceder a almacenar los datos
    if (empty($nombreErr) && empty($apellidosErr) && empty($fechaErr) && empty($sueldoErr) && empty($categoriaErr) && empty($sexoErr) && empty($aficionesErr)) {
        // Aquí puedes almacenar los datos en tu archivo JSON o base de datos
        // ...
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE HTML>
<html>

<head>
    <style>
        .error {
            color: #FF0000;
        }
    </style>
</head>

<body>

    <h2>Alta Datos Empleado</h2>

    <form method="post" action="https://sweating-piece.000webhostapp.com/PracticaCopia.php">

        <fieldset>
            <legend>Datos Personales</legend>

            <!-- A. Validación básica -->
            Nombre: <input type="text" name="Nombre" value="<?php echo $nombre; ?>" required>
            <span class="error">* <?php echo $nombreErr; ?></span>
            <br><br>

            <!-- B. Validación de nombre -->
            Apellidos: <input type="text" name="Apellidos" value="<?php echo $apellidos; ?>" required>
            <span class="error">* <?php echo $apellidosErr; ?></span>
            <br><br>

            <!-- C. Validación de apellidos -->
            Fecha de nacimiento: <input type="date" name="Fecha" value="<?php echo $fecha; ?>" required>
            <span class="error">* <?php echo $fechaErr; ?></span>
            <br><br>

            <!-- D. Validación de sueldo -->
            Sueldo: <input type="number" name="Sueldo" value="<?php echo $sueldo; ?>" required>
            <span class="error">* <?php echo $sueldoErr; ?></span>
            <br><br>

            <!-- E. Validación de categoría -->
            Categoría:
            <select name="Categoria" required>
                <option value="">--Elige--</option>
                <option value="peon" <?php if ($categoria == "peon") echo "selected"; ?>>Peón</option>
                <option value="oficial" <?php if ($categoria == "oficial") echo "selected"; ?>>Oficial</option>
                <option value="jefe-departamento" <?php if ($categoria == "jefe-departamento") echo "selected"; ?>>Jefe Departamento</option>
                <option value="director" <?php if ($categoria == "director") echo "selected"; ?>>Director</option>
            </select>
            <span class="error">* <?php echo $categoriaErr; ?></span>
            <br><br>

            <!-- F. Validación de sexo -->
            Sexo:
            <input type="radio" name="gender" value="femenino" <?php if ($sexo == "femenino") echo "checked"; ?> required>Female
            <input type="radio" name="gender" value="hombre" <?php if ($sexo == "hombre") echo "checked"; ?> required>Male
            <span class="error">* <?php echo $sexoErr; ?></span>
            <br><br>

            <!-- Validación de aficiones -->
            Aficiones:
            <input type="checkbox" name="Deportes" <?php if (isset($_POST["Deportes"])) echo "checked"; ?>>Deportes
            <input type="checkbox" name="Lectura" <?php if (isset($_POST["Lectura"])) echo "checked"; ?>>Lectura
            <input type="checkbox" name="Musica" <?php if (isset($_POST["Musica"])) echo "checked"; ?>>Musica
            <input type="checkbox" name="Cine" <?php if (isset($_POST["Cine"])) echo "checked"; ?>>Cine
            <input type="checkbox" name="Idiomas" <?php if (isset($_POST["Idiomas"])) echo "checked"; ?>>Idiomas
            <span class="error">* <?php echo $aficionesErr; ?></span>
            <br><br>

            <input type="submit" value="Enviar">
            <input type="reset" value="Limpiar">
        </fieldset>
    </form>

</body>

</html>
