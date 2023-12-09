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

  <?php
  //esta parte la he sacado de w3schools
  $nombreErr = $apellidosErr = $fechaErr = $sueldoErr = $categoriaErr = $sexoErr = $aficionesErr = "Te falta esto";
  $nombre = $apellidos = $fecha = $sueldo = $categoria = $sexo = $aficiones = "";

  // Verificamos si se ha enviado el formulario
  
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar el nombre
    if (empty($_POST["Nombre"])) {
      $nombreErr = "Debe aparecer el Nombre";
    } else {
      $nombre = test_input($_POST["Nombre"]);

    }

    if (empty($_POST["Apellidos"])) {
      $apellidosErr = "Apellidos is required";
    } else {
      $apellidos = test_input($_POST["Apellidos"]);
    }

    // Validate Fecha
    if (empty($_POST["Fecha"])) {
      $fechaErr = "Fecha de nacimiento is required";
    } else {
      $fecha = test_input($_POST["Fecha"]);
    }

    // Validate Sueldo
    if (empty($_POST["Sueldo"])) {
      $sueldoErr = "Sueldo is required";
    } else {
      $sueldo = test_input($_POST["Sueldo"]);
    }

    // Validate Sexo
    if (empty($_POST["gender"])) {
      $sexoErr = "Gender is required";
    } else {
      $sexo = test_input($_POST["gender"]);
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

</body>

</html>