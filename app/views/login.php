<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Futuro Inversión</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

    <header class="encabezado">
        <h1>Control de Acceso</h1>
        <p>Ingrese sus credenciales para operar en el sistema de Futuro Inversión</p>
    </header>

    <nav class="menu">
        <a href="index.php?page=home">← Regresar al Inicio</a>
    </nav>

    <main class="contenido" style="max-width: 450px;">
        <section class="caja">
            <h2>Identificación</h2>
            
            <form action="#" method="POST" class="formulario-contacto">
                <div class="campo-form">
                    <label for="correo">Correo Electrónico / Usuario:</label>
                    <input type="email" id="correo" name="correo" required>
                </div>

                <div class="campo-form">
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <div style="margin-top: 10px;">
                    <a href="#" style="font-size: 0.85rem; color: #0d409f; text-decoration: none;">¿Olvidó sus datos de acceso?</a>
                </div>

                <button type="submit" class="btn" style="width: 100%; margin-top: 15px;">Ingresar</button>
            </form>
        </section>
    </main>

    <footer class="pie">
        <p>&copy; 2026 - Futuro Inversión. Todos los derechos reservados.</p>
    </footer>

</body>
</html>

