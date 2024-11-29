<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
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
            padding: 10px 0;
        }

        .content {
            padding: 20px;
            text-align: center;
        }

        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: 0 auto;
        }

        .form-container h2 {
            margin-bottom: 20px;
        }

        .input-field {
            margin-bottom: 15px;
            width: 100%;
        }

        .input-field input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .input-field button {
            width: 100%;
            padding: 12px;
            background-color: #1e3a8a;
            /* Azul oscuro */
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .input-field button:hover {
            background-color: #3347b2;
        }

        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <header>
        <h1>Iniciar Sesión</h1>
    </header>
    <div class="content">
        <div class="form-container">
            <h2>Accede a tu cuenta</h2>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="input-field">
                    <input type="text" name="name" placeholder="Nombre de usuario" required>
                </div>
                <div class="input-field">
                    <input type="password" name="password" placeholder="Contraseña" required>
                </div>
                <div class="input-field">
                    <button type="submit">Iniciar Sesión</button>
                </div>

                @if(session('error'))
                <div class="error-message">{{ session('error') }}</div>
                @endif
            </form>
        </div>
    </div>
</body>

</html>