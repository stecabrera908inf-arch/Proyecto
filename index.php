
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Buena Compra - Sistema de Inventarios</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>

      <style>
        :root {
            /* Colores principales actualizados y ampliados */
            --principal: #d63384;
            --principal-claro: #f172a7;
            --secundario: #6610f2;
            --secundario-claro: #a78bfa;
            --verde: #198754;
            --verde-claro: #75b798;
            --rojo: #dc3545;
            --rojo-claro: #ea868f;
            --amarillo: #ffc107;
            --amarillo-claro: #ffda6a;
            --naranja: #fd7e14;
            --naranja-claro: #ffb74d;
            --azul: #0d6efd;
            --azul-claro: #9ec5fe;
            --oscuro: #212529;
            --gris-oscuro: #495057;
            --gris-claro: #e9ecef;
            --claro: #f8f9fa;
            --blanco: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            outline: none !important;
        }

        html, body {
            overflow-x: hidden;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #fef6ff, #f0f4ff);
        }

        /* LOGIN */
        .login-page {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, var(--oscuro), var(--secundario), var(--principal));
        }

        .login-box {
            width: 400px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(15px);
            padding: 40px;
            border-radius: 25px;
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0px 12px 35px rgba(0, 0, 0, 0.35);
            color: white;
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: 700;
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .form-control, .form-select {
            border-radius: 14px;
            padding: 12px 15px;
            border: 1px solid var(--gris-claro);
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--principal);
            box-shadow: 0 0 0 0.25rem rgba(214, 51, 132, 0.25);
        }

        .btn-login {
            width: 100%;
            border: none;
            padding: 13px;
            border-radius: 14px;
            background: linear-gradient(90deg, var(--principal), var(--secundario));
            color: white;
            font-weight: 600;
            font-size: 17px;
            transition: 0.3s ease;
            box-shadow: 0 4px 12px rgba(214, 51, 132, 0.3);
        }

        .btn-login:hover {
            transform: scale(1.03);
            box-shadow: 0 6px 15px rgba(214, 51, 132, 0.4);
            color: white;
        }

        /* SISTEMA */
        #sistema {
            display: none;
        }

        .navbar {
            background: linear-gradient(90deg, var(--oscuro), var(--secundario));
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .navbar-brand {
            font-size: 24px;
            font-weight: bold;
            color: var(--blanco) !important;
        }

        /* MENU */
        .nav-pills {
            border: none !important;
            box-shadow: none !important;
        }

        .nav-pills .nav-link {
            border: none !important;
            outline: none !important;
            box-shadow: none !important;
            border-radius: 14px;
            font-weight: 600;
            color: var(--secundario);
            margin: 5px;
            transition: 0.3s ease;
            background: var(--blanco);
            padding: 10px 18px;
        }

        .nav-pills .nav-link:hover {
            background: var(--claro);
            transform: translateY(-2px);
            color: var(--principal);
        }

        .nav-pills .nav-link.active {
            background: linear-gradient(90deg, var(--principal), var(--secundario));
            color: var(--blanco) !important;
            font-weight: 700;
            transform: scale(1.05);
            box-shadow: 0px 5px 15px rgba(102, 16, 242, 0.35);
            border: 2px solid var(--blanco);
        }

        /* DASHBOARD */
        .dashboard-card {
            border-radius: 22px;
            color: white;
            padding: 25px;
            transition: 0.3s ease;
            box-shadow: 0px 10px 25px rgba(0, 0, 0, 0.1);
        }

        .dashboard-card:hover {
            transform: translateY(-6px);
            box-shadow: 0px 14px 30px rgba(0, 0, 0, 0.18);
        }

        .card1 { background: linear-gradient(135deg, var(--principal), var(--principal-claro)); }
        .card2 { background: linear-gradient(135deg, var(--verde), var(--verde-claro)); }
        .card3 { background: linear-gradient(135deg, var(--rojo), var(--rojo-claro)); }
        .card4 { background: linear-gradient(135deg, var(--secundario), var(--secundario-claro)); }
        .card5 { background: linear-gradient(135deg, var(--amarillo), var(--amarillo-claro)); }
        .card6 { background: linear-gradient(135deg, var(--azul), var(--azul-claro)); }

        /* CAJAS */
        .box {
            background: var(--blanco);
            padding: 30px;
            border-radius: 25px;
            box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid var(--gris-claro);
        }

        /* BOTONES */
        .btn-custom {
            border: none;
            border-radius: 14px;
            padding: 12px 22px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary-custom {
            background: linear-gradient(90deg, var(--principal), var(--secundario));
            color: var(--blanco);
            box-shadow: 0 3px 8px rgba(214, 51, 132, 0.25);
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 12px rgba(214, 51, 132, 0.35);
            color: var(--blanco);
        }

        .btn-success-custom {
            background: linear-gradient(90deg, var(--verde), var(--verde-claro));
            color: var(--blanco);
            box-shadow: 0 3px 8px rgba(25, 135, 84, 0.25);
        }

        .btn-success-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 12px rgba(25, 135, 84, 0.35);
            color: var(--blanco);
        }

        .btn-warning-custom {
            background: linear-gradient(90deg, var(--amarillo), var(--naranja));
            color: var(--oscuro);
            box-shadow: 0 3px 8px rgba(255, 193, 7, 0.25);
        }

        .btn-warning-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 12px rgba(255, 193, 7, 0.35);
            color: var(--oscuro);
        }

        /* TABLA */
        .table {
            border-radius: 20px;
            overflow: hidden;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table thead {
            background: linear-gradient(90deg, var(--oscuro), var(--secundario));
            color: var(--blanco);
        }

        .table thead th {
            font-weight: 600;
            border: none;
            padding: 15px 10px;
        }

        .table tbody tr {
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background: var(--claro);
            transform: scale(1.002);
        }

        .stock-bajo {
            background: rgba(220, 53, 69, 0.08) !important;
        }

        .vencido {
            background: rgba(220, 53, 69, 0.15) !important;
        }

        .por-vencer {
            background: rgba(255, 193, 7, 0.15) !important;
        }

        /* IMAGEN PRODUCTO */
        .img-producto {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid var(--secundario);
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* ALERTAS */
        .alert {
            border: none;
            border-radius: 16px;
            padding: 15px 20px;
        }

        /* FOOTER */
        footer {
            margin-top: 40px;
            background: linear-gradient(90deg, var(--oscuro), var(--secundario));
            color: white;
            text-align: center;
            padding: 18px;
            box-shadow: 0 -4px 12px rgba(0,0,0,0.1);
        }

        /* ETIQUETAS DE ESTADO */
        .badge {
            padding: 8px 12px;
            border-radius: 8px;
            font-weight: 600;
        }
    </style>
</head>

<body>

    <div class="login-page" id="loginPage">
        <div class="login-box">
            <h2>
                <i class="fa-solid fa-store"></i> &nbsp;La Buena Compra
            </h2>
            <div class="mb-3">
                <label class="form-label">Usuario</label>
                <input type="text" id="usuario" class="form-control" placeholder="Ingrese usuario">
            </div>
            <div class="mb-4">
                <label class="form-label">Contraseña</label>
                <input type="password" id="password" class="form-control" placeholder="Ingrese contraseña">
            </div>
            <button class="btn-login" onclick="iniciarSesion()">
                <i class="fa-solid fa-right-to-bracket"></i> &nbsp;Ingresar
            </button>
        </div>
    </div>

    <div id="sistema">
        <nav class="navbar navbar-dark shadow p-3">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <i class="fa-solid fa-store"></i> &nbsp;Almacén La Buena Compra 
                </a>
                <button class="btn btn-danger" onclick="cerrarSesion()">
                    <i class="fa-solid fa-right-from-bracket"></i> &nbsp;Salir
                </button>
            </div>
        </nav>

        <div class="container mt-4">
            <ul class="nav nav-pills mb-4 justify-content-center" id="menuTabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" id="tab-dashboard" data-bs-toggle="pill" data-bs-target="#dashboard" type="button">
                        <i class="fa-solid fa-house"></i> &nbsp;Panel Principal
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="tab-registro" data-bs-toggle="pill" data-bs-target="#registro" type="button">
                        <i class="fa-solid fa-plus"></i> &nbsp;Registrar con Caso de Prueba
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="tab-inventario" data-bs-toggle="pill" data-bs-target="#inventario" type="button">
                        <i class="fa-solid fa-boxes-stacked"></i> &nbsp;Gestión Inventario
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="tab-alertas" data-bs-toggle="pill" data-bs-target="#alertas" type="button">
                        <i class="fa-solid fa-bell"></i> &nbsp;Alertas Inteligentes
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="tab-reportes" data-bs-toggle="pill" data-bs-target="#reportes" type="button">
                        <i class="fa-solid fa-chart-line"></i> &nbsp;Centro de Reportes
                    </button>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="dashboard">
                    <div class="row g-4">
                        <div class="col-md-3">
                            <div class="dashboard-card card1">
                                <h5><i class="fa-solid fa-box"></i> Casos Evaluados</h5>
                                <h2 id="totalProductos">0</h2>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="dashboard-card card2">
                                <h5><i class="fa-solid fa-money-bill-wave"></i> Costo Inversión</h5>
                                <h2 id="valorTotal">0 Bs</h2>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="dashboard-card card3">
                                <h5><i class="fa-solid fa-triangle-exclamation"></i> Stock Bajo</h5>
                                <h2 id="stockBajo">0</h2>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="dashboard-card card4">
                                <h5><i class="fa-solid fa-layer-group"></i> Categorías</h5>
                                <h2 id="categorias">0</h2>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="dashboard-card card5">
                                <h5><i class="fa-solid fa-calendar-times"></i> Productos Vencidos</h5>
                                <h2 id="vencidos">0</h2>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="dashboard-card card6">
                                <h5><i class="fa-solid fa-clock"></i> Por Vencer</h5>
                                <h2 id="porVencer">0</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="registro">
                    <div class="box">
                        <h3 class="mb-4">
                            <i class="fa-solid fa-plus text-primary"></i> &nbsp;Registrar Producto mediante Caso de Prueba
                        </h3>
                        <div class="row g-4">
                           <!-- ID Caso de Prueba Automático -->
                        <div class="col-md-4">
                             <label class="form-label">ID Caso de Prueba</label>
                                <input type="text" id="productoId" class="form-control" readonly>
                                    </div>

                                    <script>
                                    document.addEventListener("DOMContentLoaded", function () {
                                     generarIDAutomatico();
                                        });

                                        function generarIDAutomatico() {
                                         // Obtener el último número guardado
                                        let ultimoNumero = localStorage.getItem("ultimoCasoPrueba");
                                           if (ultimoNumero === null) {
                                           ultimoNumero = 1;
                                               } else {
                                           ultimoNumero = parseInt(ultimoNumero) + 1;
                                              }
                                              // Crear ID con formato ABB001, ABB002...
                                              let nuevoID = "ABB" + String(ultimoNumero).padStart(3, "0");
                                              // Mostrar ID en el campo
                                           document.getElementById("productoId").value = nuevoID;
                                               // Guardar el número para el próximo registro
                                             localStorage.setItem("ultimoCasoPrueba", ultimoNumero);
                                            }
                                    </script>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Nombre del Producto</label>
                                <input type="text" id="nombre" class="form-control" placeholder="Ej: Arroz, Refresco...">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Categoría</label>
                                <select id="categoria" class="form-select">
                                    <option value="">Seleccione</option>
                                    <option>Abarrotes</option>
                                    <option>Bebidas</option>
                                    <option>Lácteos</option>
                                    <option>Snacks</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Cantidad (Stock)</label>
                                <input type="number" id="cantidad" class="form-control" min="1">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Costo (Bs)</label>
                                <input type="number" id="costo" class="form-control" min="0" step="0.01">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Proveedor</label>
                                <select id="Provedor" class="form-select">
                                    <option>Proveedor Local</option>
                                    <option>Nestlé</option>
                                    <option>Coca-Cola</option>
                                    <option>Pil Andino</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Fecha de Ejecución</label>
                                <input type="date" id="fecha" class="form-control">
                            </div>
                            <!-- NUEVO CAMPO: FECHA DE VENCIMIENTO -->
                            <div class="col-md-4">
                                <label class="form-label">Fecha de Vencimiento</label>
                                <input type="date" id="fechaVencimiento" class="form-control">
                            </div>
                        </div>
                        <div class="mt-4 d-flex gap-3">
                            <button class="btn btn-custom btn-primary-custom" onclick="guardarProducto()">
                                Guardar Producto
                            </button>
                            <button class="btn btn-custom btn-success-custom" onclick="limpiarCampos()">
                                Limpiar Campos
                            </button>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="inventario">
                    <div class="box">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3>
                                <i class="fa-solid fa-boxes-stacked text-primary"></i> &nbsp;Gestión Inventario (Muestras de Pruebas)
                            </h3>
                            <input type="text" id="buscador" class="form-control w-25" placeholder="Buscar por nombre..." onkeyup="buscarProducto()">
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID Caso</th>
                                        <th>Imagen Real</th>
                                        <th>Producto</th>
                                        <th>Categoría</th>
                                        <th>Cantidad</th>
                                        <th>Costo</th>
                                        <th>Total</th>
                                        <th>Proveedor</th>
                                        <th>Vencimiento</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaProductos"></tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="alertas">
                    <div class="box">
                        <h3 class="text-danger mb-4">
                            <i class="fa-solid fa-bell"></i> &nbsp;Alertas Inteligentes
                        </h3>
                        <div id="listaCriticos"></div>
                    </div>
                </div>

                <div class="tab-pane fade" id="reportes">
                    <div class="box">
                        <h3 class="mb-4 text-success">
                            <i class="fa-solid fa-chart-line"></i> &nbsp;Centro de Reportes Automatizado
                        </h3>
                        <p class="text-muted">Descarga reportes estructurados reales en formato Excel (.xlsx) con los datos asociados a tus Casos de Prueba.</p>
                        <div class="row g-4">
                            <div class="col-md-4">
                                <div class="card p-4 shadow border-0 rounded-4 text-center">
                                    <i class="fa-solid fa-box fa-3x text-primary"></i>
                                    <h5 class="mt-3">Inventario Completo</h5>
                                    <button class="btn btn-primary mt-2" onclick="descargarReporte('Productos')">Descargar Excel</button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card p-4 shadow border-0 rounded-4 text-center">
                                    <i class="fa-solid fa-triangle-exclamation fa-3x text-danger"></i>
                                    <h5 class="mt-3">Productos Críticos (Stock Bajo / Vencidos)</h5>
                                    <button class="btn btn-danger mt-2" onclick="descargarReporte('Stock Bajo')">Descargar Excel</button>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card p-4 shadow border-0 rounded-4 text-center">
                                    <i class="fa-solid fa-money-bill-wave fa-3x text-success"></i>
                                    <h5 class="mt-3">Resumen Financiero</h5>
                                    <button class="btn btn-success mt-2" onclick="descargarReporte('Financiero')">Descargar Excel</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer>
            <i class="fa-solid fa-store"></i> &nbsp;Sistema del Almacen - La Buena Compra © 2026
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

const imagenesReales = {
    "Abarrotes": "https://source.unsplash.com/300x300/?grocery",
    "Bebidas": "https://source.unsplash.com/300x300/?soft-drink",
    "Lácteos": "https://source.unsplash.com/300x300/?milk",
    "Snacks": "https://source.unsplash.com/300x300/?snacks",
    "General": "https://source.unsplash.com/300x300/?supermarket"
};

// LOGIN
function iniciarSesion() {
    let usuario = document.getElementById("usuario").value;
    let password = document.getElementById("password").value;

    if (usuario === "stefany" && password === "9087957") {
        document.getElementById("loginPage").style.display = "none";
        document.getElementById("sistema").style.display = "block";
        cargarProductos();
        Swal.fire({
            icon: 'success',
            title: 'Bienvenida',
            text: 'Inicio de sesión correcto',
            confirmButtonColor: '#6610f2'
        });
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Usuario o contraseña incorrectos'
        });
    }
}

function cerrarSesion() {
    Swal.fire({
        title: '¿Cerrar sesión?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#dc3545'
    }).then((result) => {
        if(result.isConfirmed){
            location.reload();
        }
    });
}

// ARRAY PRINCIPAL
let productos = [];

// FUNCIÓN PARA CALCULAR ESTADO DE VENCIMIENTO
function obtenerEstadoVencimiento(fechaVenc) {
    const hoy = new Date();
    const fechaVencimiento = new Date(fechaVenc);
    const diferencia = fechaVencimiento - hoy;
    const diasRestantes = Math.ceil(diferencia / (1000 * 60 * 60 * 24));

    if (diasRestantes < 0) return { estado: "VENCIDO", clase: "vencido", badge: "bg-danger" };
    if (diasRestantes <= 15) return { estado: "POR VENCER", clase: "por-vencer", badge: "bg-warning text-dark" };
    return { estado: "VIGENTE", clase: "", badge: "bg-success" };
}

// CARGAR PRODUCTOS
function cargarProductos() {
    fetch("obtener_productos.php?t=" + new Date().getTime())
    .then(response => response.json())
    .then(data => {
        console.log("DATOS RECIBIDOS:", data);
        productos = data;
        renderizarTabla(productos);
        actualizarDashboard();
        mostrarCriticos();
    })
    .catch(error => {
        console.log("ERROR:", error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudieron cargar los productos'
        });
    });
}

// GUARDAR PRODUCTO
function guardarProducto() {
    let codigo = document.getElementById("productoId").value;
    let nombre = document.getElementById("nombre").value;
    let categoria = document.getElementById("categoria").value;
    let cantidad = parseInt(document.getElementById("cantidad").value);
    let costo = parseFloat(document.getElementById("costo").value);
    let proveedor = document.getElementById("Provedor").value;
    let fecha = document.getElementById("fecha").value;
    let fechaVencimiento = document.getElementById("fechaVencimiento").value;

    if (
        nombre === "" ||
        categoria === "" ||
        isNaN(cantidad) ||
        isNaN(costo) ||
        fechaVencimiento === ""
    ) {
        Swal.fire({
            icon: 'warning',
            title: 'Campos incompletos',
            text: 'Complete todos los campos, incluyendo fecha de vencimiento'
        });
        return;
    }

    let total = cantidad * costo;
    let imagen = imagenesReales[categoria] || imagenesReales["General"];

    let producto = {
        codigo: codigo,
        nombre: nombre,
        categoria: categoria,
        cantidad: cantidad,
        costo: costo,
        total: total,
        proveedor: proveedor,
        fecha: fecha,
        fechaVencimiento: fechaVencimiento,
        imagen: imagen
    };

    fetch("guardar_producto.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(producto)
    })
    .then(response => response.json())
    .then(data => {
        console.log("RESPUESTA:", data);
        if(data.success){
            Swal.fire({
                icon: 'success',
                title: 'Producto Guardado',
                html: `
                    <b>${nombre}</b><br>
                    Categoría: ${categoria}<br>
                    Cantidad: ${cantidad}<br>
                    Vence: ${fechaVencimiento}<br>
                    Total: ${total} Bs
                `,
                confirmButtonColor: '#6610f2'
            });
            cargarProductos();
            limpiarCampos();
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.error
            });
        }
    })
    .catch(error => {
        console.log(error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo guardar el producto'
        });
    });
}

// TABLA
function renderizarTabla(lista = productos) {
    let tabla = document.getElementById("tablaProductos");
    tabla.innerHTML = "";

    if(lista.length === 0){
        tabla.innerHTML = `
            <tr>
                <td colspan="11" class="text-center text-muted p-4">
                    No existen productos registrados
                </td>
            </tr>
        `;
        return;
    }

    lista.forEach((producto) => {
        const estadoStock = producto.cantidad < 5
            ? `<span class="badge bg-danger">STOCK BAJO</span>`
            : `<span class="badge bg-success">DISPONIBLE</span>`;

        const estadoVenc = obtenerEstadoVencimiento(producto.fechaVencimiento);
        const claseFila = producto.cantidad < 5 ? 'stock-bajo' : estadoVenc.clase;

        tabla.innerHTML += `
        <tr class="${claseFila}">
            <td>
                <span class="badge bg-dark p-2">
                    ${producto.codigo}
                </span>
            </td>
            <td>
                <img src="${producto.imagen}" class="img-producto" alt="Producto">
            </td>
            <td>
                <strong>${producto.nombre}</strong>
            </td>
            <td>${producto.categoria}</td>
            <td>${producto.cantidad}</td>
            <td>${producto.costo} Bs</td>
            <td>${producto.total} Bs</td>
            <td>${producto.proveedor}</td>
            <td>${producto.fechaVencimiento}</td>
            <td>
                ${estadoStock}<br>
                <span class="badge ${estadoVenc.badge} mt-1">${estadoVenc.estado}</span>
            </td>
            <td>
                <button
                    class="btn btn-danger btn-sm"
                    onclick="eliminarProducto(${producto.id})"
                    title="Eliminar producto"
                >
                    <i class="fa-solid fa-trash"></i>
                </button>
            </td>
        </tr>
        `;
    });
}

// ELIMINAR
function eliminarProducto(id) {
    Swal.fire({
        title: '¿Eliminar producto?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#dc3545'
    }).then((result) => {
        if(result.isConfirmed){
            fetch("eliminar_producto.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ id: id })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success){
                    Swal.fire({
                        icon: 'success',
                        title: 'Eliminado',
                        text: 'Producto eliminado correctamente'
                    });
                    cargarProductos();
                }
            });
        }
    });
}

// ALERTAS
function mostrarCriticos() {
    let lista = document.getElementById("listaCriticos");
    lista.innerHTML = "";

    let criticos = productos.filter(p => {
        const venc = obtenerEstadoVencimiento(p.fechaVencimiento);
        return p.cantidad < 5 || venc.estado === "VENCIDO" || venc.estado === "POR VENCER";
    });

    if (criticos.length === 0) {
        lista.innerHTML = `
        <div class="alert alert-success">
            <i class="fa-solid fa-circle-check"></i>
            No existen productos críticos por stock o vencimiento.
        </div>
        `;
        return;
    }

    criticos.forEach(p => {
        const venc = obtenerEstadoVencimiento(p.fechaVencimiento);
        let mensaje = "";
        let claseAlerta = "alert-danger";

        if (p.cantidad < 5) mensaje += `Stock bajo (${p.cantidad}) `;
        if (venc.estado === "VENCIDO") { mensaje += "Producto VENCIDO "; claseAlerta = "alert-danger"; }
        if (venc.estado === "POR VENCER") { mensaje += "Próximo a vencer "; claseAlerta = "alert-warning text-dark"; }

        lista.innerHTML += `
        <div class="alert ${claseAlerta} mb-2">
            <b>[${p.codigo}]</b> ${p.nombre} <br>
            <small>${mensaje} | Vence: ${p.fechaVencimiento}</small>
        </div>
        `;
    });
}

// DASHBOARD
function actualizarDashboard() {
    document.getElementById("totalProductos").innerText = productos.length;

    let total = productos.reduce((acc, p) => acc + parseFloat(p.total), 0);
    document.getElementById("valorTotal").innerText = total.toFixed(2) + " Bs";

    let bajos = productos.filter(p => p.cantidad < 5);
    document.getElementById("stockBajo").innerText = bajos.length;

    let vencidos = productos.filter(p => obtenerEstadoVencimiento(p.fechaVencimiento).estado === "VENCIDO");
    document.getElementById("vencidos").innerText = vencidos.length;

    let porVencer = productos.filter(p => obtenerEstadoVencimiento(p.fechaVencimiento).estado === "POR VENCER");
    document.getElementById("porVencer").innerText = porVencer.length;

    let categorias = [...new Set(productos.map(p => p.categoria))];
    document.getElementById("categorias").innerText = categorias.length;
}

// BUSCADOR
function buscarProducto() {
    let texto = document.getElementById("buscador").value.toLowerCase();
    let filtrados = productos.filter(p =>
        p.nombre.toLowerCase().includes(texto) ||
        p.codigo.toLowerCase().includes(texto) ||
        p.categoria.toLowerCase().includes(texto)
    );
    renderizarTabla(filtrados);
}

// LIMPIAR
function limpiarCampos() {
    document.getElementById("productoId").value = "";
    document.getElementById("nombre").value = "";
    document.getElementById("categoria").value = "";
    document.getElementById("cantidad").value = "";
    document.getElementById("costo").value = "";
    document.getElementById("Provedor").selectedIndex = 0;
    document.getElementById("fecha").value = "";
    document.getElementById("fechaVencimiento").value = "";
    generarIDAutomatico(); // Generar nuevo ID al limpiar
}

// DESCARGAR REPORTES
function descargarReporte(tipo) {
    if(productos.length === 0){
        Swal.fire({
            icon: 'warning',
            title: 'Sin datos',
            text: 'No existen productos registrados'
        });
        return;
    }

    let datosProcesados = [];
    let nombreArchivo = "";

    if(tipo === "Productos"){
        nombreArchivo = "Inventario_Completo.xlsx";
        datosProcesados = productos.map(p => ({
            "Código": p.codigo,
            "Nombre": p.nombre,
            "Categoría": p.categoria,
            "Cantidad": p.cantidad,
            "Costo": p.costo,
            "Total": p.total,
            "Proveedor": p.proveedor,
            "Fecha Ejecución": p.fecha,
            "Fecha Vencimiento": p.fechaVencimiento,
            "Estado Vencimiento": obtenerEstadoVencimiento(p.fechaVencimiento).estado
        }));
    }

    else if(tipo === "Stock Bajo"){
        nombreArchivo = "Productos_Criticos.xlsx";
        let filtrados = productos.filter(p => {
            const venc = obtenerEstadoVencimiento(p.fechaVencimiento);
            return p.cantidad < 5 || venc.estado === "VENCIDO" || venc.estado === "POR VENCER";
        });
        datosProcesados = filtrados.map(p => ({
            "Código": p.codigo,
            "Producto": p.nombre,
            "Cantidad": p.cantidad,
            "Fecha Vencimiento": p.fechaVencimiento,
            "Estado": obtenerEstadoVencimiento(p.fechaVencimiento).estado,
            "Observación": p.cantidad < 5 ? "Stock Bajo" : "Vencimiento próximo/pasado"
        }));
    }

    else if(tipo === "Financiero"){
        nombreArchivo = "Resumen_Financiero.xlsx";
        let totalCapital = productos.reduce((acc, p) => acc + parseFloat(p.total), 0);
        let totalVencidos = productos.filter(p => obtenerEstadoVencimiento(p.fechaVencimiento).estado === "VENCIDO").length;

        datosProcesados = [
            {"Métrica": "Productos Registrados", "Valor": productos.length},
            {"Métrica": "Capital Total Invertido", "Valor": totalCapital.toFixed(2) + " Bs"},
            {"Métrica": "Productos Vencidos", "Valor": totalVencidos},
            {"Métrica": "Valor en riesgo", "Valor": totalVencidos > 0 ? "Revisar inventario" : "Sin riesgo"}
        ];
    }

    let hoja = XLSX.utils.json_to_sheet(datosProcesados);
    let libro = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(libro, hoja, tipo);
    XLSX.writeFile(libro, nombreArchivo);

    Swal.fire({
        icon: 'success',
        title: 'Reporte Generado',
        text: 'El archivo Excel fue descargado correctamente'
    });
}

</script>
</body>
</html>