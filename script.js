// crear una variable constante y con texto(2da linea de texto) y hacer como un "print" (3ra linea) - Uziel
//const text= "hola momeros";
//console.log(text) 

// crea una variable constante y integra el texto y una comparacion (6ta linea de texto )- alexis
//console.log("esta pagina es visitada por mas de 50 mil personas por dia, y por mes: ", 50000 * 30);

// creo una variable constante con el contenido new Date() para obtener la fecha y luego hice la variable msg para que siempre que se llame lo haga con un mensaje
//const fecha= new Date();
//const msg= ('ingreso a la pagina: '+ fecha)
//console.log( msg)
//Nacho
//let play = document.getElementById("play")
    //function playAudio(){
        //let audio= new Audio("random.mp3")
        //audio.play()
    //}
    //play.addEventListener("click", playAudio);

//window.open("./ofertas.html"); // abre una ventana emergente al entrar a la pagina web (algunos navegadores la bloquean automaticamente) - uziel


//play.onclick = function() { // al clickear en "botoncito" este usa una animacion que lo cambia gradualmente a color rojo mediante CSS y JS -uziel
    //this.style.backgroundColor = '#C02514';
//};

// -------------------------------------------------------------------------------

// let talle = getElementsByClassName("talle");
// let boton_compra = getElementsByClassName("boton_comprar");

// Obtener elementos por clase
// Obtener elementos por clase
// script.js
// script.js
// script.js
// script.js
document.addEventListener('DOMContentLoaded', function() {
    // Elementos del DOM
    const listaTalles = document.querySelectorAll('.lista_talles li');
    const botonComprar = document.querySelector('.boton_comprar');
    const carritoIcono = document.getElementById('carrito');
    const modal = document.getElementById('modalCarrito');
    const spanCerrar = document.getElementsByClassName('cerrar')[0];
    const listaCarrito = document.getElementById('listaCarrito');
    const botonFinalizarCompra = document.getElementById('botonFinalizarCompra');
    const carritoCantidad = document.querySelector('.carrito-cantidad');
    const totalCarrito = document.getElementById('totalCarrito');

    let compras = [];
    let carritoVisible = false;

    // Función para actualizar el carrito
    function actualizarCarrito() {
        listaCarrito.innerHTML = '';
        let total = 0;

        compras.forEach(function(compra, index) {
            let li = document.createElement('li');

            let img = document.createElement('img');
            img.src = compra.imagen;

            let div = document.createElement('div');
            div.className = 'producto-info';

            let h4 = document.createElement('h4');
            h4.textContent = compra.nombre_producto;
            h4.style.color = "white";
            h4.style.fontSize = "3vh";

            let pTalle = document.createElement('p');
            pTalle.textContent = `Talle: ${compra.talle}`;

            let pPrecio = document.createElement('p');
            pPrecio.textContent = `Precio: $${compra.precio}`;

            let divCantidad = document.createElement('div');
            divCantidad.className = 'cantidad-container';

            let btnMenos = document.createElement('button');
            btnMenos.className = 'btn-cantidad';
            btnMenos.textContent = '-';
            btnMenos.addEventListener('click', function() {
                if (compra.cantidad > 1) {
                    compra.cantidad--;
                    actualizarCarrito();
                }
            });

            let spanCantidad = document.createElement('span');
            spanCantidad.className = 'cantidad';
            spanCantidad.textContent = compra.cantidad;

            let btnMas = document.createElement('button');
            btnMas.className = 'btn-cantidad';
            btnMas.textContent = '+';
            btnMas.addEventListener('click', function() {
                compra.cantidad++;
                actualizarCarrito();
            });

            divCantidad.appendChild(btnMenos);
            divCantidad.appendChild(spanCantidad);
            divCantidad.appendChild(btnMas);

            let btnEliminar = document.createElement('span');
            btnEliminar.className = 'eliminar';
            btnEliminar.textContent = 'X';
            btnEliminar.addEventListener('click', function() {
                eliminarProducto(index);
            });

            div.appendChild(h4);
            div.appendChild(pTalle);
            div.appendChild(pPrecio);
            div.appendChild(divCantidad);

            li.appendChild(img);
            li.appendChild(div);
            li.appendChild(btnEliminar);

            listaCarrito.appendChild(li);

            // Sumar al total
            total += compra.precio * compra.cantidad;
        });

        // Actualizar la cantidad en el carrito
        carritoCantidad.textContent = compras.length;

        // Actualizar el total en el carrito
        totalCarrito.textContent = `Total: $${total}`;

        // Habilitar o deshabilitar el botón de compra según el carrito
        if (compras.length > 0) {
            botonFinalizarCompra.style.display = "block";
        } else {
            botonFinalizarCompra.style.display = "none";
        }
    }

    // Función para eliminar un producto del carrito
    function eliminarProducto(index) {
        compras.splice(index, 1);
        actualizarCarrito();
    }

    // Agregar evento click a cada talle
    listaTalles.forEach(function(talle) {
        talle.addEventListener('click', function() {
            listaTalles.forEach(function(t) {
                t.classList.remove('active');
            });
            this.classList.add('active');
            botonComprar.dataset.talle = this.textContent;
        });
    });

    // Evento para abrir el carrito (modal)
    carritoIcono.addEventListener('click', function() {
        modal.style.display = 'block';
        carritoVisible = true;
    });

    // Evento para cerrar el modal
    spanCerrar.addEventListener('click', function() {
        modal.style.display = 'none';
        carritoVisible = false;
    });

    // Evento para agregar producto al carrito
    botonComprar.addEventListener('click', function() {
        const nombreProducto = this.dataset.nombre;
        const precioProducto = parseFloat(this.dataset.precio);
        const imagenProducto = this.dataset.imagen;
        const talleProducto = this.dataset.talle || 'S'; // Por defecto S si no se selecciona nada

        // Verificar si el producto ya está en el carrito
        const productoExistente = compras.find(function(compra) {
            return compra.nombre_producto === nombreProducto && compra.talle === talleProducto;
        });

        if (productoExistente) {
            productoExistente.cantidad++;
        } else {
            const producto = {
                nombre_producto: nombreProducto,
                precio: precioProducto,
                imagen: imagenProducto,
                talle: talleProducto,
                cantidad: 1
            };
            compras.push(producto);
        }

        actualizarCarrito();

        // Abrir el modal automáticamente al agregar al carrito
        if (!carritoVisible) {
            modal.style.display = 'block';
            carritoVisible = true;
        }
    });

    // Cerrar el modal si se hace clic fuera de él
    window.addEventListener('click', function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
            carritoVisible = false;
        }
    });

    // Deshabilitar el botón de compra si no se selecciona un talle
    botonComprar.disabled = true;
    listaTalles.forEach(function(talle) {
        talle.addEventListener('click', function() {
            botonComprar.disabled = false;
        });
    });
});

// pagina de compra
