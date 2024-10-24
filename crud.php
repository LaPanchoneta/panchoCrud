<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crud_hamburguesas</title>
</head>

<body>
    <?php

    if (isset($_REQUEST["action"])) {
        $action = $_REQUEST["action"];
    } else {
        $action = "mostrarListaProductos";  
    }

    $kiosco = new Kiosco();
    $kiosco->$action();

    class Kiosco {
        private $db = null;

        public function __construct() {
            $this->db = new mysqli("localhost", "root", "", "panchosports");
        }

        // --------------------------------- MOSTRAR LISTA DE PRODUCTOS ----------------------------------------
        public function mostrarListaProductos() {
            echo "<h1>Hamburguesas</h1>";

            if ($result = $this->db->query("SELECT * FROM productos ORDER BY name_prod")) {

                if ($result->num_rows != 0) {
                    echo "<form action='crud.php'>
                                <input type='hidden' name='action' value='buscarproductos'>
                                <input type='text' name='textoBusqueda'>
                                <input type='submit' value='Buscar'>
                                </form><br>";

                    echo "<table border='1'>";
                    echo "<tr><th>Nombre</th><th>Precio</th><th>Cantidad</th><th>Imagen</th><th>Acciones</th></tr>"; 
                    while ($fila = $result->fetch_object()) {
                        echo "<tr>";
                        echo "<td>" . $fila->name_prod . "</td>";
                        echo "<td>" . $fila->precio . "</td>";
                        echo "<td>" . $fila->cantidad_prod . "</td>";
                        echo "<td><img src='" . $fila->img . "' alt='Imagen' style='width: 50px; height: auto;'></td>"; 
                        echo "<td>
                                <a href='crud.php?action=formularioModificarProducto&idProducto=" . $fila->id_prod . "'>Modificar</a>
                                <a href='crud.php?action=borrarProducto&idProducto=" . $fila->id_prod . "'>Borrar</a>
                              </td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No se encontraron productos.";
                }
            } else {
                echo "Error al tratar de recuperar los datos de la base de datos. Por favor, inténtelo más tarde.";
            }
            echo "<p><a href='crud.php?action=formularioInsertarproductos'>Nuevo Producto</a></p>";
        }

        // --------------------------------- FORMULARIO ALTA DE PRODUCTOS ----------------------------------------
        public function formularioInsertarproductos() {
            echo "<h1>Nuevo Producto</h1>";

            echo "<form action='crud.php' method='post'>
                    Nombre: <input type='text' name='nombre'><br>
                    Precio: <input type='text' name='precio'><br>
                    Cantidad: <input type='text' name='cantidad_prod'><br>
                    URL de la imagen: <input type='text' name='img'><br> 
                    <input type='hidden' name='action' value='insertarProducto'>
                    <input type='submit' value='Insertar'>
                </form>";
            echo "<p><a href='crud.php'>Volver</a></p>";
        }

        // --------------------------------- INSERTAR PRODUCTO ----------------------------------------
        public function insertarProducto() {
            echo "<h1>Insertar Producto</h1>";

            $nombre = $_REQUEST["nombre"];
            $precio = $_REQUEST["precio"];
            $cantidad_prod = $_REQUEST["cantidad_prod"];
            $img = $_REQUEST["img"];

            $this->db->query("INSERT INTO productos (name_prod, precio, cantidad_prod, img) VALUES ('$nombre', '$precio','$cantidad_prod', '$img')");
            
            if ($this->db->affected_rows == 1) {
                echo "Producto insertado con éxito.";
            } else {
                echo "Ha ocurrido un error al insertar el producto. Por favor, inténtelo más tarde.";
            }
            echo "<p><a href='crud.php'>Volver</a></p>";
        }

        // --------------------------------- BORRAR PRODUCTO ----------------------------------------
        public function borrarProducto() {
            echo "<h1>Borrar Producto</h1>";

            $idProducto = $_REQUEST["idProducto"];
            $this->db->query("DELETE FROM productos WHERE id_prod = '$idProducto'");

            if ($this->db->affected_rows == 0) {
                echo "Ha ocurrido un error al borrar el producto. Por favor, inténtelo de nuevo.";
            } else {
                echo "Producto borrado con éxito.";
            }
            echo "<p><a href='crud.php'>Volver</a></p>";
        }

        // --------------------------------- FORMULARIO MODIFICAR PRODUCTO ----------------------------------------
        public function formularioModificarProducto() {
            echo "<h1>Modificar Producto</h1>";

            $idProducto = $_REQUEST["idProducto"];
            $result = $this->db->query("SELECT * FROM productos WHERE id_prod = '$idProducto'");
            $producto = $result->fetch_object();

            echo "<form action='crud.php' method='post'>
                    <input type='hidden' name='idProducto' value='$idProducto'>
                    Nombre: <input type='text' name='nombre' value='$producto->name_prod'><br>
                    Precio: <input type='text' name='precio' value='$producto->precio'><br>
                    Cantidad: <input type='text' name='cantidad_prod' value='$producto->cantidad_prod'><br>
                    Imagen actual: <img src='" . $producto->img . "' alt='Imagen' style='width: 50px; height: auto;'><br>
                    Nueva URL de imagen: <input type='text' name='img'><br>
                    <input type='hidden' name='action' value='modificarProducto'>
                    <input type='submit' value='Modificar'>
                </form>";
            echo "<p><a href='crud.php'>Volver</a></p>";
        }

        // --------------------------------- MODIFICAR PRODUCTO ----------------------------------------
        public function modificarProducto() {
            echo "<h1>Modificar Producto</h1>";

            $idProducto = $_REQUEST["idProducto"];
            $nombre = $_REQUEST["nombre"];
            $precio = $_REQUEST["precio"];
            $cantidad_prod = $_REQUEST["cantidad_prod"];
            $img = $_REQUEST["img"];

            $this->db->query("UPDATE productos SET name_prod = '$nombre', precio = '$precio', cantidad_prod = '$cantidad_prod', img = '$img' WHERE id_prod = '$idProducto'");

            if ($this->db->affected_rows == 1) {
                echo "Producto actualizado con éxito.";
            } else {
                echo "Ha ocurrido un error al modificar el producto. Por favor, inténtelo más tarde.";
            }
            echo "<p><a href='crud.php'>Volver</a></p>";
        }

        // --------------------------------- BUSCAR PRODUCTOS ----------------------------------------
        public function buscarproductos() {
            $textoBusqueda = $_REQUEST["textoBusqueda"];
            echo "<h1>Resultados de la búsqueda: \"$textoBusqueda\"</h1>";

            if ($result = $this->db->query("SELECT * FROM productos WHERE name_prod LIKE '%$textoBusqueda%' ORDER BY name_prod")) {

                if ($result->num_rows != 0) {
                    echo "<form action='crud.php'>
                            	<input type='hidden' name='action' value='buscarproductos'>
                            	<input type='text' name='textoBusqueda'>
                            	<input type='submit' value='Buscar'>
                            </form><br>";
                    echo "<table border='1'>";
                    echo "<tr><th>Nombre</th><th>Precio</th><th>Cantidad</th><th>Imagen</th><th>Acciones</th></tr>"; 
                    while ($fila = $result->fetch_object()) {
                        echo "<tr>";
                        echo "<td>" . $fila->name_prod . "</td>";
                        echo "<td>" . $fila->precio . "</td>";
                        echo "<td>" . $fila->cantidad_prod . "</td>";
                        echo "<td><img src='" . $fila->img . "' alt='Imagen' style='width: 50px; height: auto;'></td>"; 
                        echo "<td>
                                <a href='crud.php?action=formularioModificarProducto&idProducto=" . $fila->id_prod . "'>Modificar</a>
                                <a href='crud.php?action=borrarProducto&idProducto=" . $fila->id_prod . "'>Borrar</a>
                              </td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No se encontraron productos.";
                }
            } else {
                echo "Error al tratar de recuperar los datos de la base de datos. Por favor, inténtelo más tarde.";
            }
            echo "<p><a href='crud.php?action=formularioInsertarproductos'>Nuevo Producto</a></p>";
            echo "<p><a href='crud.php'>Volver</a></p>";
        }
    }
    ?>

</body>
</html>
