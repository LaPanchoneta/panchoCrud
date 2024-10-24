<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];

    $stmt = $pdo->prepare("INSERT INTO productos (nombre, descripcion, precio, cantidad) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nombre, $descripcion, $precio, $cantidad]);

    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pancho-Sport</title>
    <link rel="icon" href="source/icono_pancho.ico">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="script.js">
</head>

<body>
    <header>
        <div id="contenedor_titulo">
            <div id="titulo">
                <h1>Pancho</h1>
                <h1>Sport</h1>
                <h2>Nada mejor que arrancar el dia con una buena salchicha</h2>
            </div>
            <div id="foto">
                <img src="source/icono_pancho.png" rel="Logo_Pancho">
            </div>
        </div>
    </header>
    <div class="menu">
        <div class="interior">
            <nav class="navegacion">
                <ul>
                    <li><a href="./index.html">🌭inicio🌭</a></li>
                    <li><a href="./productos.html">🌭productos🌭 </a></li>
                    <li><a href="./nosotros.html">🌭nosotros🌭</a></li>
                    <li><a href="./crud.php">🌭admin🌭</a></li>
                </ul>
            </nav>
        </div>
    </div>
    <button id="play">botoncito</button>
    <script src="./script.js"></script>
</body>

</html>


