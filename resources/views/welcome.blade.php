<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido - Sistema de Inventarios</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        /* General */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fa;
            color: #333;
        }

        /* Encabezado */
        header {
            background-color: #1e3a8a;
            /* Azul oscuro */
            color: white;
            text-align: center;
            padding: 30px 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        header h1 {
            font-size: 36px;
            margin: 0;
        }

        /* Contenido */
        .content {
            padding: 40px 20px;
            text-align: center;
            background-color: #ffffff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin: 30px 10%;
            border-radius: 8px;
        }

        .content p {
            font-size: 18px;
            color: #555;
        }

        /* Enlaces */
        .content a {
            color: #1e3a8a;
            font-size: 18px;
            text-decoration: none;
            font-weight: 500;
            border: 2px solid #1e3a8a;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        .content a:hover {
            background-color: #1e3a8a;
            color: white;
        }

        /* Footer */
        footer {
            background-color: #1e3a8a;
            color: white;
            text-align: center;
            padding: 15px 0;
            position: fixed;
            inset-block-end: 0;
            inline-size: 100%;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <header>
        <h1>Theragenis Costa Rica</h1>
    </header>

    <!-- Main Content -->
    <div class="content">
        <p>¡Hola! Bienvenido a la página de inicio del sistema de inventarios. Este sistema te permitirá gestionar el inventario de tooling e insertos de manera eficiente.</p>
        <p>Aquí podrás saber la cantidad disponible de cada herramienta e insertar nueva información cuando sea necesario.</p>
        <a href="{{ route('loginForm') }}" class="btn-login">Iniciar Sesión</a>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Theragenis Costa Rica. Todos los derechos reservados.</p>
    </footer>
</body>

</html>