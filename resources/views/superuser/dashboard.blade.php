<!DOCTYPE html>
<html lang="es">

<head>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #1e3a8a;
            /* Azul oscuro */
            color: white;
            text-align: center;
            padding: 15px 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #1e3a8a;
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        .menu-options {
            margin-top: 20px;
        }

        .menu-options ul {
            list-style-type: none;
            padding: 0;
        }

        .menu-options ul li {
            margin: 10px 0;
        }

        /* Asegura que todos los botones tengan el mismo tamaño */
        .menu-options ul a,
        .logout-btn {
            display: block;
            width: 100%;
            text-decoration: none;
            background-color: #1e3a8a;
            color: white;
            padding: 12px;
            border-radius: 8px;
            font-size: 16px;
            transition: background-color 0.3s ease;
            text-align: center;
        }

        .menu-options ul a:hover,
        .logout-btn:hover {
            background-color: #3347b2;
            /* Azul más claro */
        }

        /* Estilo del contenedor de las opciones y botón */
        .options-container {
            display: flex;
            justify-content: space-between; /* Alinea los elementos a los extremos */
            align-items: center;
            margin-top: 20px;
        }

        /* Estilo del botón de logout */
        .logout-btn {
            background-color: transparent;
            color: #dc3545;
            border: 2px solid #dc3545;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            text-align: center;
            display: inline-block;
            text-decoration: none;
            transition: all 0.3s ease;
            cursor: pointer;
            width: auto; /* Ajusta el ancho al contenido */
        }

        .logout-btn:hover {
            color: white;
            background-color: #dc3545;
            border-color: #c82333;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Bienvenido SuperUser, {{ Auth::user()->name }}</h1>

        <!-- Contenedor de las opciones y botón de cerrar sesión alineados -->
        <div class="options-container">
            <div class="menu-options">
                <ul>
                    <li><a href="{{ route('registerForm') }}">Registrar un nuevo usuario</a></li>
                    <li><a href="{{ route('inventory.index') }}">Gestionar el Inventario</a></li>
                    <li><a href="{{ route('inventory.inventario') }}">Tabla de Inventarios</a></li>

                </ul>
            </div>

            <!-- Botón de Cerrar Sesión -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn">Cerrar Sesión</button>
            </form>
        </div>

    </div>

</body>

</html>
