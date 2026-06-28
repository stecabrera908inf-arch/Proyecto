<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Buena Compra - Sistema de Inventarios</title>

    <!-- ========== LIBRERÍAS EXTERNAS ========== -->
    <!-- Bootstrap 5 para estilos y componentes responsivos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome 6 para íconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <!-- Google Fonts (Poppins) para tipografía moderna -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- SheetJS (XLSX) para generar reportes en Excel desde el navegador -->
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>

    <style>
        /* ========== VARIABLES CSS (paleta de colores) ========== */
        :root {
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

        /* ========== RESET Y ESTILOS GLOBALES ========== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            outline: none !important; /* Elimina el contorno azul en focos */
        }

        html, body {
            overflow-x: hidden;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #fef6ff, #f0f4ff); /* Fondo suave degradado */
        }

        /* ========== PANTALLA DE LOGIN ========== */
        .login-page {
            height: 100vh; /* Ocupa toda la altura de la ventana */
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, var(--oscuro), var(--secundario), var(--principal));
        }

        .login-box {
            width: 400px;
            background: rgba(255, 255, 255, 0.15); /* Fondo semitransparente */
            backdrop-filter: blur(15px); /* Efecto cristal (glassmorphism) */
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

        /* ========== ESTILOS DE FORMULARIOS ========== */
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

        /* ========== BOTÓN DE LOGIN ========== */
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

        /* ========== CONTENEDOR PRINCIPAL DEL SISTEMA (oculto hasta login) ========== */
        #sistema {
            display: none;
        }

        /* ========== BARRA DE NAVEGACIÓN ========== */
        .navbar {
            background: linear-gradient(90deg, var(--oscuro), var(--secundario));
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .navbar-brand {
            font-size: 24px;
            font-weight: bold;
            color: var(--blanco) !important;
        }

        /* ========== MENÚ DE PESTAÑAS (TABS) ========== */
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

        /* ========== TARJETAS DEL DASHBOARD ========== */
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

        /* Cada tarjeta tiene un degradado de color diferente */
        .card1 { background: linear-gradient(135deg, var(--principal), var(--principal-claro)); }
        .card2 { background: linear-gradient(135deg, var(--verde), var(--verde-claro)); }
        .card3 { background: linear-gradient(135deg, var(--rojo), var(--rojo-claro)); }
        .card4 { background: linear-gradient(135deg, var(--secundario), var(--secundario-claro)); }
        .card5 { background: linear-gradient(135deg, var(--amarillo), var(--amarillo-claro)); }
        .card6 { background: linear-gradient(135deg, var(--azul), var(--azul-claro)); }

        /* ========== CAJAS DE CONTENIDO ========== */
        .box {
            background: var(--blanco);
            padding: 30px;
            border-radius: 25px;
            box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid var(--gris-claro);
        }

        /* ========== BOTONES PERSONALIZADOS ========== */
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

        /* ========== TABLA DE PRODUCTOS ========== */
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

        /* Clases para resaltar filas según estado */
        .stock-bajo {
            background: rgba(220, 53, 69, 0.08) !important;
        }

        .vencido {
            background: rgba(220, 53, 69, 0.15) !important;
        }

        .por-vencer {
            background: rgba(255, 193, 7, 0.15) !important;
        }

        /* ========== IMAGEN DE PRODUCTO ========== */
        .img-producto {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid var(--secundario);
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* ========== ALERTAS ========== */
        .alert {
            border: none;
            border-radius: 16px;
            padding: 15px 20px;
        }

        /* ========== FOOTER ========== */
        footer {
            margin-top: 40px;
            background: linear-gradient(90deg, var(--oscuro), var(--secundario));
            color: white;
            text-align: center;
            padding: 18px;
            box-shadow: 0 -4px 12px rgba(0,0,0,0.1);
        }

        /* ========== ETIQUETAS (BADGES) ========== */
        .badge {
            padding: 8px 12px;
            border-radius: 8px;
            font-weight: 600;
        }
    </style>
</head>

<body>

    <!-- ============================================================ -->
    <!-- ==================== PANTALLA DE LOGIN ==================== -->
    <!-- ============================================================ -->
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

    <!-- ============================================================ -->
    <!-- ================ SISTEMA PRINCIPAL (oculto) ================ -->
    <!-- ============================================================ -->
    <div id="sistema">

        <!-- ===== BARRA DE NAVEGACIÓN ===== -->
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

            <!-- ===== MENÚ DE PESTAÑAS (TABS) ===== -->
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

            <!-- ===== CONTENIDO DE LAS PESTAÑAS ===== -->
            <div class="tab-content">

                <!-- ========== PANEL DASHBOARD ========== -->
                <div class="tab-pane fade show active" id="dashboard">
                    <div class="row g-4">
                        <!-- Tarjeta: Total productos -->
                        <div class="col-md-3">
                            <div class="dashboard-card card1">
                                <h5><i class="fa-solid fa-box"></i> Casos Evaluados</h5>
                                <h2 id="totalProductos">0</h2>
                            </div>
                        </div>
                        <!-- Tarjeta: Valor total del inventario -->
                        <div class="col-md-3">
                            <div class="dashboard-card card2">
                                <h5><i class="fa-solid fa-money-bill-wave"></i> Costo Inversión</h5>
                                <h2 id="valorTotal">0 Bs</h2>
                            </div>
                        </div>
                        <!-- Tarjeta: Productos con stock bajo -->
                        <div class="col-md-3">
                            <div class="dashboard-card card3">
                                <h5><i class="fa-solid fa-triangle-exclamation"></i> Stock Bajo</h5>
                                <h2 id="stockBajo">0</h2>
                            </div>
                        </div>
                        <!-- Tarjeta: Número de categorías -->
                        <div class="col-md-3">
                            <div class="dashboard-card card4">
                                <h5><i class="fa-solid fa-layer-group"></i> Categorías</h5>
                                <h2 id="categorias">0</h2>
                            </div>
                        </div>
                        <!-- Tarjeta: Productos vencidos -->
                        <div class="col-md-3">
                            <div class="dashboard-card card5">
                                <h5><i class="fa-solid fa-calendar-times"></i> Productos Vencidos</h5>
                                <h2 id="vencidos">0</h2>
                            </div>
                        </div>
                        <!-- Tarjeta: Productos por vencer (próximos 15 días) -->
                        <div class="col-md-3">
                            <div class="dashboard-card card6">
                                <h5><i class="fa-solid fa-clock"></i> Por Vencer</h5>
                                <h2 id="porVencer">0</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ========== PESTAÑA REGISTRO DE PRODUCTOS ========== -->
                <div class="tab-pane fade" id="registro">
                    <div class="box">
                        <h3 class="mb-4">
                            <i class="fa-solid fa-plus text-primary"></i> &nbsp;Registrar Producto mediante Caso de Prueba
                        </h3>
                        <div class="row g-4">
                            <!-- ID del caso de prueba (se genera automáticamente) -->
                            <div class="col-md-4">
                                <label class="form-label">ID Caso de Prueba</label>
                                <input type="text" id="productoId" class="form-control" readonly>
                            </div>
                            <!-- Script que genera el ID automático al cargar la página -->
                            <script>
                                document.addEventListener("DOMContentLoaded", function () {
                                    generarIDAutomatico();
                                });

                                function generarIDAutomatico() {
                                    // Obtiene el último número guardado en localStorage o inicia en 1
                                    let ultimoNumero = localStorage.getItem("ultimoCasoPrueba");
                                    if (ultimoNumero === null) {
                                        ultimoNumero = 1;
                                    } else {
                                        ultimoNumero = parseInt(ultimoNumero) + 1;
                                    }
                                    // Formato: ABB001, ABB002, ...
                                    let nuevoID = "ABB" + String(ultimoNumero).padStart(3, "0");
                                    document.getElementById("productoId").value = nuevoID;
                                    // Guarda el número actualizado para la próxima vez
                                    localStorage.setItem("ultimoCasoPrueba", ultimoNumero);
                                }
                            </script>
                            <!-- Campo: Nombre -->
                            <div class="col-md-4">
                                <label class="form-label">Nombre del Producto</label>
                                <input type="text" id="nombre" class="form-control" placeholder="Ej: Arroz, Refresco...">
                            </div>
                            <!-- Campo: Categoría -->
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
                            <!-- Campo: Cantidad -->
                            <div class="col-md-4">
                                <label class="form-label">Cantidad (Stock)</label>
                                <input type="number" id="cantidad" class="form-control" min="1">
                            </div>
                            <!-- Campo: Costo unitario -->
                            <div class="col-md-4">
                                <label class="form-label">Costo (Bs)</label>
                                <input type="number" id="costo" class="form-control" min="0" step="0.01">
                            </div>
                            <!-- Campo: Proveedor -->
                            <div class="col-md-4">
                                <label class="form-label">Proveedor</label>
                                <select id="Provedor" class="form-select">
                                    <option>Proveedor Local</option>
                                    <option>Nestlé</option>
                                    <option>Coca-Cola</option>
                                    <option>Pil Andino</option>
                                </select>
                            </div>
                            <!-- Campo: Fecha de ejecución (registro) -->
                            <div class="col-md-4">
                                <label class="form-label">Fecha de Ejecución</label>
                                <input type="date" id="fecha" class="form-control">
                            </div>
                            <!-- Campo: Fecha de vencimiento (NUEVO) -->
                            <div class="col-md-4">
                                <label class="form-label">Fecha de Vencimiento</label>
                                <input type="date" id="fechaVencimiento" class="form-control">
                            </div>
                        </div>
                        <!-- Botones de acción -->
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

                <!-- ========== PESTAÑA GESTIÓN DE INVENTARIO ========== -->
                <div class="tab-pane fade" id="inventario">
                    <div class="box">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3>
                                <i class="fa-solid fa-boxes-stacked text-primary"></i> &nbsp;Gestión Inventario (Muestras de Pruebas)
                            </h3>
                            <!-- Buscador en tiempo real -->
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

                <!-- ========== PESTAÑA ALERTAS INTELIGENTES ========== -->
                <div class="tab-pane fade" id="alertas">
                    <div class="box">
                        <h3 class="text-danger mb-4">
                            <i class="fa-solid fa-bell"></i> &nbsp;Alertas Inteligentes
                        </h3>
                        <div id="listaCriticos"></div>
                    </div>
                </div>

                <!-- ========== PESTAÑA CENTRO DE REPORTES ========== -->
                <div class="tab-pane fade" id="reportes">
                    <div class="box">
                        <h3 class="mb-4 text-success">
                            <i class="fa-solid fa-chart-line"></i> &nbsp;Centro de Reportes Automatizado
                        </h3>
                        <p class="text-muted">Descarga reportes estructurados reales en formato Excel (.xlsx) con los datos asociados a tus Casos de Prueba.</p>
                        <div class="row g-4">
                            <!-- Reporte: Inventario completo -->
                            <div class="col-md-4">
                                <div class="card p-4 shadow border-0 rounded-4 text-center">
                                    <i class="fa-solid fa-box fa-3x text-primary"></i>
                                    <h5 class="mt-3">Inventario Completo</h5>
                                    <button class="btn btn-primary mt-2" onclick="descargarReporte('Productos')">Descargar Excel</button>
                                </div>
                            </div>
                            <!-- Reporte: Productos críticos -->
                            <div class="col-md-4">
                                <div class="card p-4 shadow border-0 rounded-4 text-center">
                                    <i class="fa-solid fa-triangle-exclamation fa-3x text-danger"></i>
                                    <h5 class="mt-3">Productos Críticos (Stock Bajo / Vencidos)</h5>
                                    <button class="btn btn-danger mt-2" onclick="descargarReporte('Stock Bajo')">Descargar Excel</button>
                                </div>
                            </div>
                            <!-- Reporte: Resumen financiero -->
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

            </div><!-- .tab-content -->
        </div><!-- .container -->

        <!-- ===== FOOTER ===== -->
        <footer>
            <i class="fa-solid fa-store"></i> &nbsp;Sistema del Almacen - La Buena Compra © 2026
        </footer>
    </div><!-- #sistema -->

    <!-- ========== SCRIPTS DE BOOTSTRAP Y SWEETALERT2 ========== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- ============================================================ -->
    <!-- ==================== JAVASCRIPT PRINCIPAL ==================== -->
    <!-- ============================================================ -->
    <script>

        // ========== DICCIONARIO DE IMÁGENES POR CATEGORÍA ==========
        // Se usan URLs de Unsplash para obtener imágenes reales de muestra.
        const imagenesReales = {
            "Abarrotes": "https://source.unsplash.com/300x300/?grocery",
            "Bebidas": "https://source.unsplash.com/300x300/?soft-drink",
            "Lácteos": "https://source.unsplash.com/300x300/?milk",
            "Snacks": "https://source.unsplash.com/300x300/?snacks",
            "General": "https://source.unsplash.com/300x300/?supermarket"
        };

        // ============================================================
        // ========== FUNCIONES DE LOGIN / LOGOUT ==========
        // ============================================================

        /**
         * iniciaSesion - Valida las credenciales y muestra el sistema.
         * Usuario fijo: stefany / contraseña: 9087957
         */
        function iniciarSesion() {
            let usuario = document.getElementById("usuario").value;
            let password = document.getElementById("password").value;

            if (usuario === "stefany" && password === "9087957") {
                // Oculta login y muestra el sistema
                document.getElementById("loginPage").style.display = "none";
                document.getElementById("sistema").style.display = "block";
                // Carga los productos desde la base de datos
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

        /**
         * cerrarSesion - Pregunta al usuario y recarga la página para volver al login.
         */
        function cerrarSesion() {
            Swal.fire({
                title: '¿Cerrar sesión?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#dc3545'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload(); // Recarga la página, volviendo al login
                }
            });
        }

        // ============================================================
        // ========== VARIABLE GLOBAL Y FUNCIONES DE ESTADO ==========
        // ============================================================

        // Arreglo que contendrá todos los productos (se llena desde el backend)
        let productos = [];

        /**
         * obtenerEstadoVencimiento - Calcula si un producto está vigente,
         * por vencer (≤15 días) o vencido, a partir de su fecha de vencimiento.
         * @param {string} fechaVenc - Fecha en formato YYYY-MM-DD
         * @returns {object} { estado, clase, badge }
         */
        function obtenerEstadoVencimiento(fechaVenc) {
            const hoy = new Date();
            const fechaVencimiento = new Date(fechaVenc);
            const diferencia = fechaVencimiento - hoy;
            const diasRestantes = Math.ceil(diferencia / (1000 * 60 * 60 * 24));

            if (diasRestantes < 0) return { estado: "VENCIDO", clase: "vencido", badge: "bg-danger" };
            if (diasRestantes <= 15) return { estado: "POR VENCER", clase: "por-vencer", badge: "bg-warning text-dark" };
            return { estado: "VIGENTE", clase: "", badge: "bg-success" };
        }

        // ============================================================
        // ========== CRUD DE PRODUCTOS (CON BACKEND PHP) ==========
        // ============================================================

        /**
         * cargarProductos - Obtiene la lista de productos desde el servidor
         * mediante una petición GET a 'obtener_productos.php'.
         * Luego actualiza la tabla, el dashboard y las alertas.
         */
        function cargarProductos() {
            // Se añade un parámetro de tiempo para evitar caché
            fetch("obtener_productos.php?t=" + new Date().getTime())
                .then(response => response.json())
                .then(data => {
                    console.log("DATOS RECIBIDOS:", data);
                    productos = data; // Guarda en la variable global
                    renderizarTabla(productos);   // Pinta la tabla
                    actualizarDashboard();         // Actualiza las tarjetas
                    mostrarCriticos();             // Muestra alertas
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

        /**
         * guardarProducto - Toma los datos del formulario, los valida,
         * y los envía al servidor mediante POST a 'guardar_producto.php'.
         * Si todo es correcto, recarga la lista y limpia el formulario.
         */
        function guardarProducto() {
            let codigo = document.getElementById("productoId").value;
            let nombre = document.getElementById("nombre").value;
            let categoria = document.getElementById("categoria").value;
            let cantidad = parseInt(document.getElementById("cantidad").value);
            let costo = parseFloat(document.getElementById("costo").value);
            let proveedor = document.getElementById("Provedor").value;
            let fecha = document.getElementById("fecha").value;
            let fechaVencimiento = document.getElementById("fechaVencimiento").value;

            // Validación: todos los campos obligatorios (incluyendo vencimiento)
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

            // Construye el objeto producto
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

            // Envía al servidor
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
                    if (data.success) {
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
                        cargarProductos();  // Recarga la tabla
                        limpiarCampos();     // Limpia el formulario
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

        /**
         * eliminarProducto - Envía una solicitud para eliminar un producto
         * por su ID. Si el usuario confirma, se elimina y se recarga la lista.
         * @param {number} id - ID del producto en la base de datos.
         */
        function eliminarProducto(id) {
            Swal.fire({
                title: '¿Eliminar producto?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '#dc3545'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("eliminar_producto.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({ id: id })
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
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

        // ============================================================
        // ========== RENDERIZADO DE TABLA ==========
        // ============================================================

        /**
         * renderizarTabla - Pinta los productos en el <tbody> de la tabla.
         * Aplica clases de estilo según stock y vencimiento.
         * @param {Array} lista - Arreglo de productos (por defecto usa 'productos').
         */
        function renderizarTabla(lista = productos) {
            let tabla = document.getElementById("tablaProductos");
            tabla.innerHTML = "";

            if (lista.length === 0) {
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
                // Estado de stock (menos de 5 unidades = bajo)
                const estadoStock = producto.cantidad < 5
                    ? `<span class="badge bg-danger">STOCK BAJO</span>`
                    : `<span class="badge bg-success">DISPONIBLE</span>`;

                // Estado de vencimiento
                const estadoVenc = obtenerEstadoVencimiento(producto.fechaVencimiento);
                // Clase para la fila (resaltado)
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

        // ============================================================
        // ========== ALERTAS INTELIGENTES ==========
        // ============================================================

        /**
         * mostrarCriticos - Filtra los productos con stock bajo, vencidos
         * o por vencer, y los muestra en la pestaña de alertas.
         */
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
                if (venc.estado === "VENCIDO") {
                    mensaje += "Producto VENCIDO ";
                    claseAlerta = "alert-danger";
                }
                if (venc.estado === "POR VENCER") {
                    mensaje += "Próximo a vencer ";
                    claseAlerta = "alert-warning text-dark";
                }

                lista.innerHTML += `
                    <div class="alert ${claseAlerta} mb-2">
                        <b>[${p.codigo}]</b> ${p.nombre} <br>
                        <small>${mensaje} | Vence: ${p.fechaVencimiento}</small>
                    </div>
                `;
            });
        }

        // ============================================================
        // ========== DASHBOARD (INDICADORES) ==========
        // ============================================================

        /**
         * actualizarDashboard - Calcula y actualiza los valores de las
         * tarjetas del panel principal (total productos, valor, stock bajo,
         * vencidos, por vencer, categorías).
         */
        function actualizarDashboard() {
            // Total de productos
            document.getElementById("totalProductos").innerText = productos.length;

            // Suma total de 'total' (cantidad * costo)
            let total = productos.reduce((acc, p) => acc + parseFloat(p.total), 0);
            document.getElementById("valorTotal").innerText = total.toFixed(2) + " Bs";

            // Productos con cantidad < 5
            let bajos = productos.filter(p => p.cantidad < 5);
            document.getElementById("stockBajo").innerText = bajos.length;

            // Productos vencidos
            let vencidos = productos.filter(p => obtenerEstadoVencimiento(p.fechaVencimiento).estado === "VENCIDO");
            document.getElementById("vencidos").innerText = vencidos.length;

            // Productos por vencer (próximos 15 días)
            let porVencer = productos.filter(p => obtenerEstadoVencimiento(p.fechaVencimiento).estado === "POR VENCER");
            document.getElementById("porVencer").innerText = porVencer.length;

            // Número de categorías distintas
            let categorias = [...new Set(productos.map(p => p.categoria))];
            document.getElementById("categorias").innerText = categorias.length;
        }

        // ============================================================
        // ========== BUSCADOR EN TIEMPO REAL ==========
        // ============================================================

        /**
         * buscarProducto - Filtra la tabla según el texto ingresado
         * en el campo de búsqueda (coincidencia en nombre, código o categoría).
         */
        function buscarProducto() {
            let texto = document.getElementById("buscador").value.toLowerCase();
            let filtrados = productos.filter(p =>
                p.nombre.toLowerCase().includes(texto) ||
                p.codigo.toLowerCase().includes(texto) ||
                p.categoria.toLowerCase().includes(texto)
            );
            renderizarTabla(filtrados);
        }

        // ============================================================
        // ========== LIMPIEZA DE FORMULARIO ==========
        // ============================================================

        /**
         * limpiarCampos - Vacía todos los campos del formulario de registro
         * y genera un nuevo ID automático para el siguiente producto.
         */
        function limpiarCampos() {
            document.getElementById("productoId").value = "";
            document.getElementById("nombre").value = "";
            document.getElementById("categoria").value = "";
            document.getElementById("cantidad").value = "";
            document.getElementById("costo").value = "";
            document.getElementById("Provedor").selectedIndex = 0;
            document.getElementById("fecha").value = "";
            document.getElementById("fechaVencimiento").value = "";
            generarIDAutomatico(); // Genera un nuevo ID al limpiar
        }

        // ============================================================
        // ========== DESCARGA DE REPORTES (EXCEL) ==========
        // ============================================================

        /**
         * descargarReporte - Genera y descarga un archivo Excel con los
         * datos según el tipo de reporte solicitado.
         * @param {string} tipo - 'Productos', 'Stock Bajo' o 'Financiero'.
         */
        function descargarReporte(tipo) {
            if (productos.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Sin datos',
                    text: 'No existen productos registrados'
                });
                return;
            }

            let datosProcesados = [];
            let nombreArchivo = "";

            if (tipo === "Productos") {
                // Reporte: inventario completo
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
            } else if (tipo === "Stock Bajo") {
                // Reporte: productos críticos (stock bajo, vencidos o por vencer)
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
            } else if (tipo === "Financiero") {
                // Reporte: resumen financiero (métricas agregadas)
                nombreArchivo = "Resumen_Financiero.xlsx";
                let totalCapital = productos.reduce((acc, p) => acc + parseFloat(p.total), 0);
                let totalVencidos = productos.filter(p => obtenerEstadoVencimiento(p.fechaVencimiento).estado === "VENCIDO").length;

                datosProcesados = [
                    { "Métrica": "Productos Registrados", "Valor": productos.length },
                    { "Métrica": "Capital Total Invertido", "Valor": totalCapital.toFixed(2) + " Bs" },
                    { "Métrica": "Productos Vencidos", "Valor": totalVencidos },
                    { "Métrica": "Valor en riesgo", "Valor": totalVencidos > 0 ? "Revisar inventario" : "Sin riesgo" }
                ];
            }

            // Convierte a hoja de Excel y descarga
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